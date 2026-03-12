<?php
namespace App\Services;

use App\Models\Client;

class ClientRegistryService {
    public function getDetailedRegistry($search = null) {
        $query = Client::with(['user', 'evolutions' => fn($q) => $q->latest()]);

        if ($search) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%$search%"));
        }

        return $query->paginate(10);
    }

    public function calculateBioMetrics(Client $client) {
        $latest = $client->evolutions->sortByDesc('recorded_at')->first();
        if (!$latest) return null;
        return [
            'bmi' => round($latest->weight / ($client->height ** 2), 1),
            'trend' => $this->getWeightTrend($client)
        ];
    }

    private function getWeightTrend($client) {
        $lastTwo = $client->evolutions->sortByDesc('recorded_at')->take(2)->values();
        if ($lastTwo->count() < 2) return 0;
        return $lastTwo[0]->weight - $lastTwo[1]->weight;
    }
}