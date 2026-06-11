<?php
namespace App\Services;

use App\Models\Client;
use App\Models\Evolution;
use App\Models\Payment;
use App\Models\SystemSetting;

class DashboardService
{
    public function getClientMetrics(int $clientId): array
    {
        $evolutionService = new EvolutionService();

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
            'streak'         => $evolutionService->calculateStreak($client->id),
            'compliance'     => $evolutionService->calculateCompliance($client->id),
            'program_id'     => $client->program_id,
        ];
    }

    public function getMetrics(): array
    {
        return [
            'total_revenue'    => Payment::whereMonth('date', now()->month)->sum('amount'),
            'active_pupils'    => Client::where('status', 'active')->count(),
            'compliance_index' => 85,
            'system_stream'    => Client::latest()->take(5)->get(),
        ];
    }

    public function updateWeight(int $clientId, float $weight): Evolution
    {
        return Evolution::create([
            'client_id' => $clientId,
            'weight'    => $weight,
            'recorded_at' => now(),
        ]);
    }

    public function getCoachDashboardData(array $financeMetrics): array
    {
        $activePupils = Client::where('status', 'active')->count();
        $totalPupils  = Client::count();
        $pupilsPercent = $totalPupils > 0 ? round(($activePupils / $totalPupils) * 100) : 0;

        $loggedLast7Days = Evolution::where('recorded_at', '>=', now()->subDays(7))
            ->distinct('client_id')
            ->count();

        $complianceIndex = $activePupils > 0
            ? min(100, round(($loggedLast7Days / $activePupils) * 100, 1))
            : 100;

        $threshold = (int) SystemSetting::getVal('deadline_alert_threshold', 2);
        $clients = Client::where('status', 'active')
            ->whereNotNull('program_started_at')
            ->with('user')
            ->get();

        $deadlineAlerts = $clients->filter(function ($c) use ($threshold) {
            $daysLeft = $c->days_left;
            return $daysLeft !== null && $daysLeft >= 0 && $daysLeft <= $threshold;
        })->sortBy('days_left');

        $recentClients = Client::whereHas('user')->with('user')->latest()->take(5)->get()->map(function ($c) {
            return [
                'type'  => 'REGISTRATION',
                'title' => 'New_Registration',
                'desc'  => "Client #{$c->id} (" . ($c->user->name ?? 'Unknown') . ") joined Performance Engine.",
                'time'  => $c->created_at,
            ];
        });

        $recentLogs = Evolution::whereHas('client.user')->with('client.user')->latest()->take(5)->get()->map(function ($e) {
            return [
                'type'  => 'LOG',
                'title' => 'Bio_Metric_Sync',
                'desc'  => ($e->client->user->name ?? 'Unknown') . " logged a new weight entry: {$e->weight}kg.",
                'time'  => $e->created_at,
            ];
        });

        $systemStream = $recentClients->concat($recentLogs)->sortByDesc('time')->take(5);

        $whatsappNumber = SystemSetting::getVal('whatsapp_number', '212600000000');

        return compact(
            'financeMetrics',
            'activePupils',
            'totalPupils',
            'pupilsPercent',
            'complianceIndex',
            'systemStream',
            'deadlineAlerts',
            'threshold',
            'whatsappNumber'
        );
    }
}