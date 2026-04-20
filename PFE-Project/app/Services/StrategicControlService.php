<?php
namespace App\Services;

use App\Models\Staff;
use App\Models\Payment;

class StrategicControlService {
    public function getTeamManifest() {
        return Staff::with('user')->withCount('clients')->get();
    }

    public function getTransactionLogs($filter = 'all') {
        $query = Payment::with('client.user')->latest();
        
        if ($filter !== 'all') {
            $query->where('status', $filter);
        }

        return $query->paginate(20);
    }
}