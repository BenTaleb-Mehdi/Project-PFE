<?php
namespace App\Services;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'] ?? 'password123'),
            ]);

            return $user->client()->create([
                'phone_number' => $data['phone_number'] ?? null,
                'status' => $data['status'] ?? 'active',
                'target_goal' => $data['target_goal'] ?? null,
                'current_weight' => $data['current_weight'] ?? null,
                'height' => $data['height'] ?? null,
            ]);
        });
    }

    public function updateClient(int $id, array $data) {
        return DB::transaction(function () use ($id, $data) {
            $client = Client::findOrFail($id);
            $client->update($data);

            if (isset($data['name']) || isset($data['email'])) {
                $client->user->update(array_filter([
                    'name' => $data['name'] ?? null,
                    'email' => $data['email'] ?? null,
                ]));
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