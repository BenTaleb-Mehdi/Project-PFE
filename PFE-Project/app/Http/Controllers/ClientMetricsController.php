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

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $request->validate(['weight' => 'required|numeric|min:20|max:500']);

        $service = new DashboardService();
        $service->updateWeight($id, (float) $request->weight);

        return response()->json(['success' => true]);
    }
}
