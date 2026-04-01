<?php
namespace App\Services;

use App\Models\Client;
use App\Models\Evolution;

class DashboardService {

    public function getClientMetrics(int $clientId)
    {
        $client = Client::with('user')->findOrFail($clientId);

        $latestEvolution = Evolution::where('client_id', $clientId)
                            ->latest()
                            ->first();

        $previousEvolution = Evolution::where('client_id', $clientId)
                            ->latest()
                            ->skip(1)
                            ->first();

        $weightChange = 0;
        if ($latestEvolution && $previousEvolution) {
            $weightChange = round($latestEvolution->weight - $previousEvolution->weight, 1);
        }

        return [
            'client_id'      => $client->id,
            'client_name'    => $client->user->name,
            'status'         => $client->status,
            'target_goal'    => $client->target_goal,
            'current_weight' => $latestEvolution?->weight ?? $client->current_weight,
            'weight_change'  => $weightChange,
            'height'         => $client->height,
        ];
    }

    public function updateWeight(int $clientId, float $weight)
    {
        return Evolution::create([
            'client_id' => $clientId,
            'weight' => $weight,
            'recorded_at' => now(),
        ]);
    }
}