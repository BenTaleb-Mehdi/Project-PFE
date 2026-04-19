<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coach\StoreClientRequest;
use App\Http\Requests\Coach\UpdateClientRequest;
use App\Services\ClientRegistryService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $clientService;
    protected $assignmentService;
    protected $nutritionService;

    public function __construct(
        ClientRegistryService $clientService, 
        \App\Services\AssignmentService $assignmentService,
        \App\Services\NutritionService $nutritionService
    ) {
        $this->clientService = $clientService;
        $this->assignmentService = $assignmentService;
        $this->nutritionService = $nutritionService;
    }

    public function index(Request $request)
    {
        $clients = $this->clientService->getDetailedRegistry($request->search, $request->status ?? 'ALL_STATUSES');
        $protocols = $this->nutritionService->getPrograms();
        
        return view('coach.clients.index', compact('clients', 'protocols'));
    }

    public function assignProgram(Request $request, $id)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'duration_weeks' => 'required|integer|min:1'
        ]);

        $this->assignmentService->assignProtocol($id, $request->program_id, $request->duration_weeks);

        return redirect()->back()->with('success', 'PROTOCOL_LINKED // ID_Sync_Complete');
    }

    public function store(StoreClientRequest $request)
    {
        $this->clientService->addClient($request->validated());
        return redirect()->back()->with('success', 'CLIENT_ONBOARDED // Session_Secure');
    }

    public function update(UpdateClientRequest $request, $id)
    {
        $this->clientService->updateClient($id, $request->validated());
        return redirect()->back()->with('success', 'PROFILE_SYNCED // Record_Modified');
    }

    public function destroy($id)
    {
        $this->clientService->deleteClient($id);
        return redirect()->back()->with('success', 'RECORD_PURGED // Wipe_Complete');
    }
}
