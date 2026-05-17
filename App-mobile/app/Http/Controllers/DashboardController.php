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

        $data = $response->json();
        
        // Notification Logic: Check for new program assignments
        if (isset($data['data']['program_id'])) {
            $currentProgramId = $data['data']['program_id'];
            $lastSeenProgramId = session('last_seen_program_id');

            // If we have a last seen ID and it differs from current, mark as new
            if ($lastSeenProgramId && $currentProgramId != $lastSeenProgramId) {
                session(['has_new_program' => true]);
            }
            
            // If first time seeing a program, store it
            if (!$lastSeenProgramId && $currentProgramId) {
                session(['last_seen_program_id' => $currentProgramId]);
            }
        }

        return response()->json($data);
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