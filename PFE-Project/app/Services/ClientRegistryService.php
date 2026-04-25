<?php
namespace App\Services;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Notifications\SendClientCredentials;
use Illuminate\Support\Facades\Log;

class ClientRegistryService {
    public function getDetailedRegistry($search = null, $status = 'ALL_STATUSES') {
        $query = Client::with(['user', 'evolutions', 'program']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('user', fn($sq) => $sq->where('name', 'like', "%$search%"))
                  ->orWhere('id', 'like', "%$search%");
            });
        }

        if ($status !== 'ALL_STATUSES') {
            $query->where('status', $status);
        }

        return $query->latest()->paginate(15);
    }
    public function addClient(array $data) {
        $password = Str::random(12);

        // 1. Create User and Client in transaction — ensure data integrity
        $user = DB::transaction(function () use ($data, $password) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($password),
            ]);

            // Assign Spatie Role
            $user->assignRole('client');

            $user->client()->create([
                'phone_number'   => $data['phone_number'] ?? null,
                'status'         => $data['status'] ?? 'active',
                'target_goal'    => $data['target_goal'] ?? null,
                'current_weight' => $data['current_weight'] ?? null,
                'height'         => $data['height'] ?? null,
            ]);

            return $user;
        });

        // 2. Send credentials via Laravel Notification with error handling
        try {
            $user->notify(new SendClientCredentials($password));
            Log::info("CREDENTIALS_SENT // Registry_Success // User: " . $user->email);
        } catch (\Exception $e) {
            Log::error("EMAIL_FAILURE // Registry_Warning // User: " . $user->email . " // Error: " . $e->getMessage());
        }

        return $user->client;
    }

    public function updateClient(int $id, array $data) {
        return DB::transaction(function () use ($id, $data) {
            $client = Client::findOrFail($id);
            
            // Separate User data from Client data
            $userData = array_intersect_key($data, array_flip(['name', 'email']));
            $clientData = array_diff_key($data, array_flip(['name', 'email']));

            // Update Client record
            if (!empty($clientData)) {
                $client->update($clientData);
            }

            // Update associated User record
            if (!empty($userData)) {
                $client->user->update($userData);
            }

            return $client->fresh(['user']);
        });
    }

    public function deleteClient(int $id) {
        return DB::transaction(function () use ($id) {
            $client = Client::findOrFail($id);
            $user = $client->user;
            $client->delete();
            return $user->delete();
        });
    }

    public function calculateBioMetrics(Client $client) {
        $latest = $client->evolutions->sortByDesc('recorded_at')->first();
        if (!$latest) return null;
        return [
            'bmi' => round($latest->weight / (($client->height / 100) ** 2), 2),
            'trend' => $this->getWeightTrend($client)
        ];
    }

    private function getWeightTrend($client) {
        $lastTwo = $client->evolutions->sortByDesc('recorded_at')->take(2)->values();
        if ($lastTwo->count() < 2) return 0;
        return $lastTwo[0]->weight - $lastTwo[1]->weight;
    }

    /**
     * Get all clients for selection dropdowns.
     */
    public function getAllClients()
    {
        return Client::with('user')->get();
    }
}