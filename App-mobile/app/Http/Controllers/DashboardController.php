<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function show($id)
    {
        return view('dashboard', ['clientId' => $id]);
    }

    public function metrics($id)
    {
        $response = Http::get(env('WEB_A_API_URL') . "/client/{$id}/metrics");

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot connect to Web A'
            ], 500);
        }

        return response()->json($response->json());
    }
}