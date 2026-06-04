<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    /**
     * Chatbot powered directly by Gemini API.
     * Handles conversation AND category creation without n8n.
     * Accepts { chatInput, history[] } → returns { output, created[] }
     */

    protected CategoryService $categoryService;
    protected \App\Services\FinanceService $financeService;
    protected \App\Services\ClientRegistryService $clientService;
    protected \App\Services\StaffRegistryService $staffService;

    public function __construct(
        CategoryService $categoryService,
        \App\Services\FinanceService $financeService,
        \App\Services\ClientRegistryService $clientService,
        \App\Services\StaffRegistryService $staffService
    ) {
        $this->categoryService = $categoryService;
        $this->financeService = $financeService;
        $this->clientService = $clientService;
        $this->staffService = $staffService;
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
3. Onboard a new client/pupil (e.g., "Create client named John Doe, email john@example.com, phone 123456").
4. Deploy/add a new staff member (e.g., "Create staff named Jane Smith, email jane@example.com, phone 654321, specialties [1]").
5. Catalogue/log a payment (e.g., "Create payment of 500 MAD for client John Doe, status paid, date 2026-06-03").

When you detect a category creation request, you MUST respond with ONLY valid JSON in this exact format — no markdown, no extra text:
{"action":"create_category","name":"<CategoryName>","message":"<friendly confirmation message>"}

When you detect a client onboarding request, you MUST respond with ONLY valid JSON in this exact format — no markdown, no extra text:
{"action":"create_client","name":"<ClientName>","email":"<ClientEmail>","phone_number":"<ClientPhone>","status":"active","message":"<friendly confirmation message>"}

When you detect a staff deployment request, you MUST respond with ONLY valid JSON in this exact format — no markdown, no extra text:
{"action":"create_staff","name":"<StaffName>","email":"<StaffEmail>","phone_number":"<StaffPhone>","specialties":[<SpecialtyIDs>],"bio":"","message":"<friendly confirmation message>"}

When you detect a payment logging request, you MUST respond with ONLY valid JSON in this exact format — no markdown, no extra text:
{"action":"create_payment","client_name":"<ClientName>","amount":<Amount>,"date":"<YYYY-MM-DD>","status":"<paid|pending>","message":"<friendly confirmation message>"}

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
            } elseif ($action === 'create_client') {
                try {
                    $clientData = [
                        'name' => $decoded['name'] ?? '',
                        'email' => $decoded['email'] ?? '',
                        'phone_number' => $decoded['phone_number'] ?? null,
                        'status' => $decoded['status'] ?? 'active',
                    ];
                    $client = $this->clientService->addClient($clientData);
                    $created[] = $client;
                    $aiText = $decoded['message'] ?? "✅ Client \"{$clientData['name']}\" has been onboarded successfully!";
                    session()->flash('success', 'CLIENT_ONBOARDED // Credentials_Sent');
                } catch (\Exception $e) {
                    $aiText = "⚠️ Failed to onboard client: " . $e->getMessage();
                }
            } elseif ($action === 'create_staff') {
                try {
                    $specialties = $decoded['specialties'] ?? [];
                    if (empty($specialties)) {
                        $firstSpec = \DB::table('specialties')->first();
                        if ($firstSpec) {
                            $specialties = [$firstSpec->id];
                        }
                    }
                    $staffData = [
                        'name' => $decoded['name'] ?? '',
                        'email' => $decoded['email'] ?? '',
                        'phone_number' => $decoded['phone_number'] ?? null,
                        'specialties' => $specialties,
                        'bio' => $decoded['bio'] ?? '',
                        'legacy_specialty' => 'Coach'
                    ];
                    $staff = $this->staffService->addStaff($staffData);
                    $created[] = $staff;
                    $aiText = $decoded['message'] ?? "✅ Staff member \"{$staffData['name']}\" has been deployed successfully!";
                    session()->flash('success', 'STAFF_ONBOARDED // ID_Sync_Complete // Credentials_Dispatched');
                } catch (\Exception $e) {
                    $aiText = "⚠️ Failed to deploy staff member: " . $e->getMessage();
                }
            } elseif ($action === 'create_payment') {
                try {
                    $clientName = $decoded['client_name'] ?? '';
                    if (empty($clientName)) {
                        throw new \Exception('Client name not provided.');
                    }

                    $clientName = trim($clientName);
                    $user = \App\Models\User::whereRaw('LOWER(name) = ?', [strtolower($clientName)])->first();
                    if (!$user) {
                        // Fallback: try to find client directly by name (if client has a name field in future)
                        $client = \App\Models\Client::whereRaw('LOWER(name) = ?', [strtolower($clientName)])->first();
                        if (!$client) {
                            throw new \Exception("Client '{$clientName}' not found.");
                        }
                    } else {
                        $client = $user->client;
                        if (!$client) {
                            throw new \Exception("User '{$clientName}' does not have an associated client.");
                        }
                    }

                    $paymentData = [
                        'client_id' => $client->id,
                        'amount'    => $decoded['amount'] ?? 0,
                        'date'      => $decoded['date'] ?? now()->toDateString(),
                        'status'    => $decoded['status'] ?? 'pending',
                    ];
                    $payment = $this->financeService->logPayment($paymentData);
                    $created[] = $payment;
                    $aiText = $decoded['message'] ?? "✅ Payment of {$paymentData['amount']} MAD for client \"{$client->name}\" has been logged successfully!";
                    Log::info("Payment logged: client={$client->name}, amount={$paymentData['amount']}, date={$paymentData['date']}, status={$paymentData['status']}");
                    session()->flash('success', 'PAYMENT_LOGGED // Receipt_Sent');
                } catch (\Exception $e) {
                    $aiText = "⚠️ Failed to log payment: " . $e->getMessage();
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
