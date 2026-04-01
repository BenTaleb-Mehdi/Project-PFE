<?php
namespace App\Http\Controllers;

use App\Http\Helpers\ApiHelper;

class ProgramController extends Controller
{
    public function show($id)
    {
        return view('program', ['clientId' => $id]);
    }

    public function api($id)
    {
        $response = ApiHelper::fetchFromApi("/client/{$id}/program");

        if (!$response) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot connect to backend API'
            ], 500);
        }

        return response()->json($response->json());
    }
}
