<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    /**
     * Chatbot powered directly by Gemini API.
     * Handles conversation AND category creation without n8n.
     * Accepts { chatInput, history[] } → returns { output, created[] }
     */

    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'chatInput' => 'required|string|max:2000',
            'history'   => 'nullable|array',
        ]);
        $userMessage = trim($validated['chatInput']);

        // Early handling: direct category creation commands (e.g., "Generate Breakfast")
        $lowerMessage = strtolower($userMessage);
        if (strpos($lowerMessage, 'generate') === 0) {
            // Extract the part after the keyword
            $parts = preg_split('/\s+/', $userMessage, 2);
            $categoryName = $parts[1] ?? '';
            $categoryName = trim($categoryName);
            if ($categoryName !== '') {
                try {
                    $category = $this->categoryService->addSequenceSlot($categoryName);
                    $created = [$category];
                    $aiText = "✅ Category \"{$categoryName}\" has been created successfully!";
                    session()->flash('success', $aiText);
                    return response()->json([
                        'output' => $aiText,
                        'created' => $created,
                    ]);
                } catch (\Exception $e) {
                    $aiText = "⚠️ I tried to create the category \"{$categoryName}\" but encountered an error: " . $e->getMessage();
                    return response()->json([
                        'output' => $aiText,
                        'created' => [],
                    ], 500);
                }
            }
        }

        // Early handling: if user directly requests category creation
        if (preg_match('/^generate\s+(.+)/i', $userMessage, $matches)) {
            $categoryName = trim($matches[1]);
            try {
                $category = $this->categoryService->addSequenceSlot($categoryName);
                $created = [$category];
                $aiText = "✅ Category \"{$categoryName}\" has been created successfully!";
                session()->flash('success', $aiText);
                return response()->json([
                    'output' => $aiText,
                    'created' => $created,
                ]);
            } catch (\Exception $e) {
                $aiText = "⚠️ I tried to create the category \"{$categoryName}\" but encountered an error: " . $e->getMessage();
                return response()->json([
                    'output' => $aiText,
                    'created' => [],
                ], 500);
            }
        }

        $history = $validated['history'] ?? [];

        $systemInstruction = [
            'parts' => [[
                'text' => <<<PROMPT
You are CoachBot AI, an expert nutrition & fitness assistant for the IronCoach platform.

Your main capabilities:
1. Answer fitness, nutrition, and health questions.
2. Create meal/nutrition CATEGORIES when the user asks (e.g. "create a category called Breakfast", "add Snack category", "generate a Lunch category").

When you detect a category creation request, you MUST respond with ONLY valid JSON in this exact format — no markdown, no extra text:
{"action":"create_category","name":"<CategoryName>","message":"<friendly confirmation message>"}

For all other messages, respond naturally as a helpful coach assistant.
PROMPT
            ]]
        ];

        // Build conversation turns from history
        $contents = [];
        foreach ($history as $item) {
            if (!empty($item['text']) && !empty($item['role'])) {
                $contents[] = [
                    'role'  => $item['role'] === 'ai' ? 'model' : 'user',
                    'parts' => [['text' => $item['text']]],
                ];
            }
        }
        // Add current user message
        $contents[] = [
            'role'  => 'user',
            'parts' => [['text' => $userMessage]],
        ];

        // ── 2. Call Gemini 2.0/2.5 API ────────────────────────────────────
        $apiKey = config('services.gemini.api_key', env('GEMINI_API_KEY'));
        if (empty($apiKey)) {
            Log::error('Gemini API key is not set');
            return response()->json([
                'output' => '⚠️ Gemini API key is missing. Please configure GEMINI_API_KEY.',
                'created' => [],
            ], 500);
        }
        $url    = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";

        try {
            $geminiResponse = Http::retry(3, 100)
                ->timeout(60)
                ->withoutVerifying()
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, [
                    'system_instruction' => $systemInstruction,
                    'contents' => $contents,
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 512,
                    ],
                ]);
        } catch (\Exception $e) {
            Log::error('Gemini API request failed after retries: ' . $e->getMessage());
            return response()->json([
                'output' => 'Sorry, we encountered an unexpected error while contacting the AI service. Please try again later.',
                'created' => [],
            ], 500);
        }

        if (!$geminiResponse->successful()) {
            Log::warning('Gemini API responded with error status.', ['status' => $geminiResponse->status()]);
            return response()->json([
                'output' => 'Sorry, the AI service is currently unavailable. Please try again in a few minutes.',
                'created' => [],
            ], 503);
        }

        $aiText = $geminiResponse->json(
            'candidates.0.content.parts.0.text',
            'I had trouble generating a response. Please try again.'
        );

        // ── 3. Detect creation actions ──────────────────────────────
        $created = [];
        $cleanText = trim($aiText);

        // Strip markdown code fences if present
        $cleanText = preg_replace('/^```(?:json)?\s*/i', '', $cleanText);
        $cleanText = preg_replace('/\s*```$/', '', $cleanText);
        $cleanText = trim($cleanText);

        $decodedData = json_decode($cleanText, true);
        $decoded = $decodedData;
        if (json_last_error() !== JSON_ERROR_NONE) {
            if (preg_match('/^generate\s+(\w+)/i', $cleanText, $matches)) {
                $decoded = [
                    'action' => 'create_category',
                    'name' => $matches[1],
                    'message' => "✅ Category \"{$matches[1]}\" has been created successfully!",
                ];
            }
        }

        if (json_last_error() === JSON_ERROR_NONE && isset($decoded['action'])) {
            $action = $decoded['action'];
            if ($action === 'create_category' && !empty($decoded['name'])) {
                try {
                    $category = $this->categoryService->addSequenceSlot($decoded['name']);
                    $created[] = $category;
                    $aiText = $decoded['message'] ?? "✅ Category \"{$decoded['name']}\" has been created successfully!";
                    session()->flash('success', $aiText);
                } catch (\Exception $e) {
                    $aiText = "⚠️ I tried to create the category \"{$decoded['name']}\" but encountered an error: " . $e->getMessage();
                }
            }
        }

        // ── 4. Return response ───────────────────────────────────────────────
        return response()->json([
            'output'  => $aiText,
            'created' => $created,
        ]);
    }
}
