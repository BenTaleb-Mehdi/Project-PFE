<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\ClientProgramService;
use App\Services\EvolutionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $programService;
    protected $evolutionService;

    public function __construct(ClientProgramService $programService, EvolutionService $evolutionService)
    {
        $this->programService = $programService;
        $this->evolutionService = $evolutionService;
    }

    /**
     * Display the mobile-responsive client dashboard.
     */
    public function index()
    {
        $client = $this->getClient();
        $clientId = $client->id;

        // Fetch Program Data
        $programData = $this->programService->getClientProgramData($clientId);

        // Fetch Evolution Stats
        $biometrics = $this->evolutionService->calculateBioMetrics($clientId);
        $history    = $this->evolutionService->getWeightHistory($clientId);
        $latest      = $this->evolutionService->getLatestStats($clientId);

        return view('client.dashboard', compact('programData', 'biometrics', 'history', 'latest'));
    }

    /**
     * Display assigned programs for the pupil.
     */
    public function programs()
    {
        $client = $this->getClient();
        $clientId = $client->id;
        $programData = $this->programService->getClientProgramData($clientId);

        return view('client.programs.index', compact('programData'));
    }

    /**
     * Display past program history.
     */
    public function history()
    {
        $client = $this->getClient();
        $clientId = $client->id;
        $history = $this->programService->getClientPrograms($clientId);

        return view('client.history.index', [
            'programData' => ['all_programs' => $history],
        ]);
    }

    /**
     * Internal helper to get client context in dev/prod.
     */
    private function getClient()
    {
        // Debug/Preview Mode: Allow manual client selection via URL
        if ($clientId = request('client_id')) {
            return \App\Models\Client::find($clientId) ?? \App\Models\Client::first();
        }

        $user = Auth::user();
        $client = $user ? $user->client : \App\Models\Client::first();

        if (!$client) {
            abort(404, 'DEPLOYMENT_ERROR: No Client context found.');
        }

        return $client;
    }
}
