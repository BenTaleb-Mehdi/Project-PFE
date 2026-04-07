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

    public function __construct(ClientRegistryService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index(Request $request)
    {
        $clients = $this->clientService->getDetailedRegistry($request->search);
        return view('coach.clients.index', compact('clients'));
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
