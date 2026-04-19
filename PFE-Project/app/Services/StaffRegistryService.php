<?php

namespace App\Services;

use App\Models\User;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffRegistryService
{
    /**
     * Create a new Staff member with an associated User account.
     *
     * @param array $data
     * @return Staff
     */
    public function addStaff(array $data): Staff
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password'] ?? 'staff123'),
            ]);

            return Staff::create([
                'user_id'   => $user->id,
                'specialty' => $data['specialty'] ?? 'Coach',
                'bio'       => $data['bio'] ?? '',
            ]);
        });
    }

    /**
     * Get all staff members with optional search and specialty filters.
     */
    public function getTeam(?string $search = null, ?string $specialty = null)
    {
        $query = Staff::with('user');

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($specialty && $specialty !== 'ALL_SPECIALIZATIONS') {
            $query->where('specialty', 'like', "%{$specialty}%");
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

            return $staff->update([
                'specialty' => $data['specialty'],
                'bio'       => $data['bio'] ?? $staff->bio,
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
