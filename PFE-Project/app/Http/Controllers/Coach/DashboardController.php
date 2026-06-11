<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use App\Services\FinanceService;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(FinanceService $financeService, DashboardService $dashboardService)
    {
        $financeMetrics = $financeService->getMetrics();

        $data = $dashboardService->getCoachDashboardData($financeMetrics);

        return view('coach.dashboard', $data);
    }

    /**
     * Update system settings via AJAX.
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'deadline_alert_threshold' => 'nullable|integer|min:0|max:30',
            'whatsapp_number' => 'nullable|string|max:20'
        ]);

        if (isset($validated['deadline_alert_threshold'])) {
            SystemSetting::setVal('deadline_alert_threshold', $validated['deadline_alert_threshold']);
        }
        
        if (isset($validated['whatsapp_number'])) {
            SystemSetting::setVal('whatsapp_number', $validated['whatsapp_number']);
        }

        return response()->json(['success' => true]);
    }

}
