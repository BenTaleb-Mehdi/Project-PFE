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

        if (preg_match('/^generate\s+(.+)/i', $userMessage, $matches)) {
            return $this->createCategoryFromName(trim($matches[1]));
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
            if ($decoded['action'] === 'create_category' && !empty($decoded['name'])) {
                $result = $this->createCategoryFromName($decoded['name'], $decoded['message'] ?? null);
                $aiText = $result->getData()->output;
                $created = $result->getData()->created;
            }
        }

        // ── 4. Return response ───────────────────────────────────────────────
        return response()->json([
            'output'  => $aiText,
            'created' => $created,
        ]);
    }

    private function createCategoryFromName(string $name, ?string $successMessage = null): \Illuminate\Http\JsonResponse
    {
        try {
            $category = $this->categoryService->addSequenceSlot($name);
            $message = $successMessage ?? "✅ Category \"{$name}\" has been created successfully!";
            session()->flash('success', $message);
            return response()->json([
                'output' => $message,
                'created' => [$category],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'output' => "⚠️ I tried to create the category \"{$name}\" but encountered an error: " . $e->getMessage(),
                'created' => [],
            ], 500);
        }
    }
}
