<?php

namespace App\Services;

use App\Models\Evolution;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EvolutionService
{
    /**
     * Log a new evolution entry for a client.
     */
    public function logEvolution(int $clientId, array $data): Evolution
    {
        $imageUrls = [];
        if (isset($data['photos']) && is_array($data['photos'])) {
            foreach ($data['photos'] as $photo) {
                $imageUrls[] = $photo->store('evolutions', 'public');
            }
        }

        return Evolution::create([
            'client_id'    => $clientId,
            'weight'       => $data['weight'],
            'images'       => $imageUrls,
            'recorded_at'  => $data['recorded_at'] ?? now()->toDateString(),
        ]);
    }


    /**
     * Get the latest evolution data for a client.
     */
    public function getLatestStats(int $clientId)
    {
        return Evolution::where('client_id', $clientId)->latest('recorded_at')->first();
    }

    /**
     * Get the weight history for charting.
     */
    public function getWeightHistory(int $clientId)
    {
        return Evolution::where('client_id', $clientId)
            ->latest('recorded_at')
            ->limit(10)
            ->get()
            ->reverse();
    }

    /**
     * Calculate Bio-Metrics (BMI, Trend).
     */
    public function calculateBioMetrics(int $clientId): array
    {
        $client = Client::findOrFail($clientId);
        $latest = $this->getLatestStats($clientId);
        
        if (!$latest || !$client->height) {
            return [
                'bmi'    => 'N/A',
                'trend'  => 'NEUTRAL',
                'weight' => $client->current_weight ?? 0
            ];
        }

        // BMI = weight(kg) / height(m)^2
        $heightM = $client->height / 100;
        $bmi = $latest->weight / ($heightM * $heightM);

        // Trend calculation (vs previous)
        $previous = Evolution::where('client_id', $clientId)
            ->where('id', '!=', $latest->id)
            ->latest('recorded_at')
            ->first();

        $trend = 'STABLE';
        if ($previous) {
            $diff = $latest->weight - $previous->weight;
            if ($diff > 0.5) $trend = 'INCREASING';
            if ($diff < -0.5) $trend = 'DECREASING';
        }

        return [
            'bmi'    => number_format($bmi, 1),
            'trend'  => $trend,
            'weight' => $latest->weight
        ];
    }
}
