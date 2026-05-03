<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Services\FinanceService;
use App\Models\Client;
use App\Models\Evolution;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(FinanceService $financeService)
    {
        $financeMetrics = $financeService->getMetrics();
        
        $activePupils = Client::where('status', 'active')->count();
        $totalPupils  = Client::count();
        $pupilsPercent = $totalPupils > 0 ? round(($activePupils / $totalPupils) * 100) : 0;
        
        // Compliance: % of active clients who logged in the last 7 days
        $loggedLast7Days = Evolution::where('recorded_at', '>=', now()->subDays(7))
            ->distinct('client_id')
            ->count();
        
        $complianceIndex = $activePupils > 0 
            ? min(100, round(($loggedLast7Days / $activePupils) * 100, 1)) 
            : 100;

        // Deadline Alerts
        $threshold = (int) SystemSetting::getVal('deadline_alert_threshold', 2);
        $clients = Client::where('status', 'active')
            ->whereNotNull('program_started_at')
            ->with('user')
            ->get();
        
        $deadlineAlerts = $clients->filter(function($c) use ($threshold) {
            $daysLeft = $c->days_left;
            return $daysLeft !== null && $daysLeft >= 0 && $daysLeft <= $threshold;
        })->sortBy('days_left');

        // System Stream
        $recentClients = Client::whereHas('user')->with('user')->latest()->take(5)->get()->map(function($c) {
            return [
                'type' => 'REGISTRATION',
                'title' => 'New_Registration',
                'desc' => "Client #{$c->id} (" . ($c->user->name ?? 'Unknown') . ") joined Performance Engine.",
                'time' => $c->created_at
            ];
        });

        $recentLogs = Evolution::whereHas('client.user')->with('client.user')->latest()->take(5)->get()->map(function($e) {
            return [
                'type' => 'LOG',
                'title' => 'Bio_Metric_Sync',
                'desc' => ($e->client->user->name ?? 'Unknown') . " logged a new weight entry: {$e->weight}kg.",
                'time' => $e->created_at
            ];
        });

        $systemStream = $recentClients->concat($recentLogs)->sortByDesc('time')->take(5);

        return view('coach.dashboard', compact(
            'financeMetrics', 
            'activePupils', 
            'totalPupils', 
            'pupilsPercent',
            'complianceIndex', 
            'systemStream',
            'deadlineAlerts',
            'threshold'
        ));
    }

    /**
     * Update system settings via AJAX.
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'deadline_alert_threshold' => 'required|integer|min:0|max:30'
        ]);

        SystemSetting::setVal('deadline_alert_threshold', $validated['deadline_alert_threshold']);

        return response()->json(['success' => true]);
    }

    public function team()
    {
        return view('coach.team');
    }

    public function finance()
    {
        return view('coach.finance');
    }
}
