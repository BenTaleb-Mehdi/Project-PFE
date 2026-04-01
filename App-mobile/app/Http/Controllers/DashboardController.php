<?php
namespace App\Http\Controllers;

use App\Http\Helpers\ApiHelper;

class DashboardController extends Controller
{
    public function show($id)
    {
        return view('dashboard', ['clientId' => $id]);
    }

    public function metrics($id)
    {
        $response = ApiHelper::fetchFromApi("/client/{$id}/metrics");

        if (!$response) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot connect to backend API'
            ], 500);
        }

        if (!$response->successful()) {
            return response()->json([
                'success' => false,
                'message' => $response->json('message') ?? 'Backend server error'
            ], $response->status());
        }

        return response()->json($response->json());
    }

    public function updateMetrics(\Illuminate\Http\Request $request, $id)
    {
        $response = ApiHelper::postToApi("/client/{$id}/metrics", $request->only('weight'));

        if (!$response) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot connect to backend API'
            ], 500);
        }

        if (!$response->successful()) {
            $json = $response->json();
            $message = $json['message'] ?? 'Backend validation error';
            
            // If there are detailed validation errors, pick the first one
            if (isset($json['errors']) && is_array($json['errors'])) {
                $firstError = collect($json['errors'])->flatten()->first();
                if ($firstError) {
                    $message = $firstError;
                }
            }

            return response()->json([
                'success' => false,
                'message' => $message
            ], $response->status());
        }

        return response()->json($response->json());
    }
}