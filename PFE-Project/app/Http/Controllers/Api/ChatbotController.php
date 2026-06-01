<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    /**
     * Landing page chatbot — powered by Gemini 2.5 Flash.
     * Accepts { message, history[] } and returns { output: string }.
     */
 

    public function sendToN8n(Request $request)
    {
        set_time_limit(150); // Prevent PHP 30s execution timeout
        
        $validated = $request->validate([
            'chatInput' => 'required|string',
        ]);

        try {
            // 1. Get current ngrok URL dynamically
            $ngrokUrl = null;
            try {
                $tunnelsResponse = Http::get('http://localhost:4040/api/tunnels');
                if ($tunnelsResponse->successful()) {
                    $tunnels = $tunnelsResponse->json()['tunnels'] ?? [];
                    foreach ($tunnels as $tunnel) {
                        if (str_contains($tunnel['public_url'], 'ngrok')) {
                            $ngrokUrl = $tunnel['public_url'];
                            break;
                        }
                    }
                }
            } catch (\Exception $e) {}

            // 2. Send to n8n with increased timeout
            $response = Http::withoutVerifying()
                ->timeout(120) 
                ->post('http://localhost:5678/webhook/4028c59a-0a3f-46ba-8d20-bff8b8560b3d/chat', [
                    'chatInput' => $validated['chatInput'],
                    'sessionId' => 'coach-flow-ai',
                    'callbackUrl' => ($ngrokUrl ?? url('/')) . '/api/nutrition/categories/ai-create',
                ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json([
                'output' => 'Error: n8n workflow failed.',
                'details' => $response->body()
            ], 500);
            
        } catch (\Exception $e) {
            return response()->json([
                'output' => 'SYS_ERROR: Connection failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
