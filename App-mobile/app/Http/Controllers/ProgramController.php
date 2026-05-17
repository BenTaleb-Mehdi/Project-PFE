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

        $data = $response->json();
        
        if (isset($data['data']['program_title'])) {
            // Since we don't have a direct program_id in this specific response yet, 
            // but we are viewing the program page, we can clear the notification flag.
            session()->forget('has_new_program');
            
            // We'll update the last_seen_program_id next time metrics are fetched 
            // or we could try to get it here if the API provided it.
        }

        return response()->json($data);
    }
}
