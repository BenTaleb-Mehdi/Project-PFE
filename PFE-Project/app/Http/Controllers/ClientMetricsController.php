<?php
namespace App\Http\Controllers;

use App\Services\DashboardService;

class ClientMetricsController extends Controller
{
    public function show($id)
    {
        $service = new DashboardService();

        $data = $service->getClientMetrics($id);

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }
}
