<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ProgramController extends Controller
{
    public function show($id)
    {
        return view('program', ['clientId' => $id]);
    }

    public function api($id)
    {
        $response = Http::get(env('WEB_A_API_URL') . "/client/{$id}/program");

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot connect to Web A Dashboard'
            ], 500);
        }

        return response()->json($response->json());
    }
}
