<?php

namespace App\Http\Controllers;

use App\Services\GeminiService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct(protected GeminiService $gemini) {}

    public function index()
    {
        return view('chat');
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:4000',
            'history' => 'nullable|array',
        ]);

        try {
            $reply = $this->gemini->chat(
                $request->input('message'),
                $request->input('history', [])
            );

            return response()->json(['reply' => $reply]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}