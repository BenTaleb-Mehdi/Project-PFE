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

        $evolution = Evolution::create([
            'client_id'    => $clientId,
            'weight'       => $data['weight'],
            'images'       => $imageUrls,
            'recorded_at'  => $data['recorded_at'] ?? now()->toDateString(),
        ]);

        // Sync weight to Client master record
        Client::where('id', $clientId)->update(['current_weight' => $data['weight']]);

        return $evolution;
    }


    /**
     * Get the latest evolution data for a client.
     */
    public function getLatestStats(int $clientId)
    {
        return Evolution::where('client_id', $clientId)
            ->orderByDesc('recorded_at')
            ->orderByDesc('id')
            ->first();
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
            ->reverse()
            ->values();
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
                'bmi'        => 'N/A',
                'trend'      => 'NEUTRAL',
                'weight'     => $client->current_weight ?? 0,
                'streak'     => 0,
                'compliance' => 0
            ];
        }

        // BMI = weight(kg) / height(m)^2
        $heightM = $client->height / 100;
        $bmi = ($heightM > 0) ? ($latest->weight / ($heightM * $heightM)) : 0;

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
            'bmi'        => number_format($bmi, 1),
            'trend'      => $trend,
            'weight'     => $latest->weight,
            'streak'     => $this->calculateStreak($clientId),
            'compliance' => $this->calculateCompliance($clientId)
        ];
    }

    /**
     * Calculate consecutive days of perfect meal compliance.
     */
    public function calculateStreak(int $clientId): int
    {
        $client = Client::find($clientId);
        if (!$client || !$client->program_id) return 0;
        
        $programItemsCount = \App\Models\ProgramItem::where('program_id', $client->program_id)->count();
        if ($programItemsCount == 0) return 0;

        $validations = \App\Models\MealValidation::where('client_id', $clientId)
            ->orderByDesc('validated_for')
            ->get()
            ->groupBy('validated_for');

        $streak = 0;
        $checkDate = Carbon::today();
        
        // If no validation today, streak might have ended, or we are still in today's window
        if (!isset($validations[$checkDate->toDateString()])) {
            $checkDate->subDay();
        }

        while (isset($validations[$checkDate->toDateString()])) {
            if ($validations[$checkDate->toDateString()]->count() >= $programItemsCount) {
                $streak++;
                $checkDate->subDay();
            } else {
                break;
            }
        }

        return $streak;
    }

    /**
     * Calculate % of meals validated in the last 7 days.
     */
    public function calculateCompliance(int $clientId): int
    {
        $client = Client::find($clientId);
        if (!$client || !$client->program_id) return 0;
        
        $programItemsCount = \App\Models\ProgramItem::where('program_id', $client->program_id)->count();
        if ($programItemsCount == 0) return 0;

        $start = Carbon::today()->subDays(6);
        $totalPotentialMeals = $programItemsCount * 7;
        
        $actualValidations = \App\Models\MealValidation::where('client_id', $clientId)
            ->where('validated_for', '>=', $start->toDateString())
            ->count();

        return min(100, (int) (($actualValidations / $totalPotentialMeals) * 100));
    }

    /**
     * Delete an evolution entry and its associated images.
     */
    public function deleteEvolution(int $evolutionId): bool
    {
        $evolution = Evolution::findOrFail($evolutionId);
        
        if ($evolution->images) {
            foreach ($evolution->images as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        return $evolution->delete();
    }
}
