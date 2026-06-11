<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\ClientProgramService;
use App\Services\EvolutionService;
use App\Traits\GetClientTrait;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use GetClientTrait;

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

}
