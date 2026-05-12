<?php
namespace App\Services;

use App\Models\Client;
use App\Models\Evolution;
use App\Models\Payment;

class DashboardService {

    protected $evolutionService;
    
    public function __construct() {
        $this->evolutionService = new EvolutionService();
    }

    public function getClientMetrics(int $clientId)
    {
        $client = Client::with('user')
            ->where('id', $clientId)
            ->orWhere('user_id', $clientId)
            ->firstOrFail();

        $latestEvolution = Evolution::where('client_id', $client->id)
                            ->latest()
                            ->first();

        $previousEvolution = Evolution::where('client_id', $client->id)
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
            'streak'         => $this->evolutionService->calculateStreak($client->id),
            'compliance'     => $this->evolutionService->calculateCompliance($client->id),
            'program_id'     => $client->program_id,
        ];
    }

    public function getMetrics()
    {
        return [
            'total_revenue'    => Payment::whereMonth('date', now()->month)->sum('amount'),
            'active_pupils'    => Client::where('status', 'active')->count(),
            'compliance_index' => 85, // Placeholder for business logic
            'system_stream'    => Client::latest()->take(5)->get(),
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