<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coach\StoreStaffRequest;
use App\Http\Requests\Coach\UpdateStaffRequest;
use App\Services\StaffRegistryService;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    protected $staffService;

    public function __construct(StaffRegistryService $staffService)
    {
        $this->staffService = $staffService;
    }

    /**
     * Display the team registry.
     */
    public function index(Request $request)
    {
        $team = $this->staffService->getTeam(
            $request->search,
            $request->specialty
        );
        return view('coach.team', compact('team'));
    }

    /**
     * Register a new staff member.
     */
    public function store(StoreStaffRequest $request)
    {
        $this->staffService->addStaff($request->validated());
        return redirect()->route('coach.team')->with('success', 'STAFF_ONBOARDED // ID_Sync_Complete');
    }

    /**
     * Update an existing staff member.
     */
    public function update(UpdateStaffRequest $request, $id)
    {
        $this->staffService->updateStaff($id, $request->validated());
        return redirect()->route('coach.team')->with('success', 'STAFF_MODIFIED // Profile_Updated');
    }

    /**
     * Remove a staff member from the ecosystem.
     */
    public function destroy($id)
    {
        $this->staffService->removeStaff($id);
        return redirect()->route('coach.team')->with('success', 'STAFF_WIPED // Access_Revoked');
    }
}
