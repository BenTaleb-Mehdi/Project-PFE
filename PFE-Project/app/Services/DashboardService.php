<?php
namespace App\Services;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Evolution;

class DashboardService {
    public function getMetrics() {
        return [
            'total_revenue' => Payment::whereMonth('date', now()->month)->sum('amount'),
            'active_pupils' => Client::where('status', 'active')->count(),
            'compliance_index' => 94.2, 
            'system_stream' => Client::with('user')->latest()->limit(5)->get()
        ];
    }
}