<?php

namespace App\Services;

use App\Models\User;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Notifications\SendStaffCredentials;
use Illuminate\Support\Facades\Log;

class StaffRegistryService
{
    /**
     * Create a new Staff member with an associated User account.
     */
    public function addStaff(array $data): Staff
    {
        $password = Str::random(12);

        $staff = DB::transaction(function () use ($data, $password) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($password),
            ]);

            $user->assignRole('co-coach');

            $staff = Staff::create([
                'user_id'      => $user->id,
                'specialty'    => $data['legacy_specialty'] ?? 'Coach', // Keeping for backward compatibility if needed
                'bio'          => $data['bio'] ?? '',
                'phone_number' => $data['phone_number'] ?? null,
                'status'       => 'active',
            ]);

            if (isset($data['specialties'])) {
                $staff->specialties()->sync($data['specialties']);
            }

            return $staff;
        });

        // Send credentials
        try {
            $staff->user->notify(new SendStaffCredentials($password));
            Log::info("STAFF_CREDENTIALS_SENT // User: " . $staff->user->email);
        } catch (\Exception $e) {
            Log::error("STAFF_EMAIL_FAILURE // User: " . $staff->user->email . " // Error: " . $e->getMessage());
        }

        return $staff;
    }

    /**
     * Get all staff members with optional search and specialty filters.
     */
    public function getTeam(?string $search = null, ?string $specialtyId = null)
    {
        $query = Staff::with(['user', 'specialties']);

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($specialtyId && $specialtyId !== 'ALL_SPECIALIZATIONS') {
            $query->whereHas('specialties', function ($q) use ($specialtyId) {
                $q->where('specialties.id', $specialtyId);
            });
        }

        return $query->latest()->paginate(10);
    }

    /**
     * Update an existing staff member's profile.
     */
    public function updateStaff(int $id, array $data): bool
    {
        return DB::transaction(function () use ($id, $data) {
            $staff = Staff::findOrFail($id);
            $staff->user->update([
                'name'  => $data['name'],
                'email' => $data['email'],
            ]);

            if (isset($data['specialties'])) {
                $staff->specialties()->sync($data['specialties']);
            }

            return $staff->update([
                'bio'          => $data['bio'] ?? $staff->bio,
                'phone_number' => $data['phone_number'] ?? $staff->phone_number,
                'status'       => $data['status'] ?? $staff->status,
            ]);
        });
    }

    /**
     * Permanent removal of a staff member.
     */
    public function removeStaff(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $staff = Staff::findOrFail($id);
            $user = $staff->user;
            $staff->delete();
            return $user->delete();
        });
    }
}
