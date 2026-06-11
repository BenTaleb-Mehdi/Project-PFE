<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreEvolutionRequest;
use App\Services\EvolutionService;
use App\Traits\GetClientTrait;
use Illuminate\Http\Request;

class EvolutionController extends Controller
{
    use GetClientTrait;

    protected $evolutionService;

    public function __construct(EvolutionService $evolutionService)
    {
        $this->evolutionService = $evolutionService;
    }

    /**
     * Display the progression history / Evolution Hub.
     */
    public function index()
    {
        $client = $this->getClient();
        $clientId = $client->id;

        $biometrics = $this->evolutionService->calculateBioMetrics($clientId);
        $history    = $this->evolutionService->getWeightHistory($clientId);
        $latest      = $this->evolutionService->getLatestStats($clientId);

        return view('client.evolution.index', compact('biometrics', 'history', 'latest'));
    }

    /**
     * Store a new progress log (weight & photo).
     */
    public function store(StoreEvolutionRequest $request)
    {
        $client = $this->getClient();

        if (!$client) {
            return redirect()->back()->with('error', 'DEPLOYMENT_ERROR: Ensure at least ONE client exists in the Registry.');
        }

        $clientId = $client->id;
        
        $this->evolutionService->logEvolution($clientId, $request->validated());

        return redirect()->route('client.evolution.index', ['client_id' => $clientId])->with('success', 'PROGRESS_CATALOGUED // Bio_Sync_Complete');
    }

    /**
     * Remove a specific log entry.
     */
    public function destroy(int $id)
    {
        $this->evolutionService->deleteEvolution($id);
        return redirect()->back()->with('success', 'RECORD_PURGED // Sync_Integrity_Maintained');
    }

}
