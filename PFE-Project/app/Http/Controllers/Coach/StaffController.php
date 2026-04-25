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
    protected $specialtyService;

    public function __construct(StaffRegistryService $staffService, \App\Services\SpecialtyService $specialtyService)
    {
        $this->staffService = $staffService;
        $this->specialtyService = $specialtyService;
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
        $specialties = $this->specialtyService->getAllSpecialties();
        
        return view('coach.team', compact('team', 'specialties'));
    }

    /**
     * Register a new staff member.
     */
    public function store(StoreStaffRequest $request)
    {
        $this->staffService->addStaff($request->validated());
        return redirect()->route('coach.team')->with('success', 'STAFF_ONBOARDED // ID_Sync_Complete // Credentials_Dispatched');
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

    /**
     * Specialty Management: Add
     */
    public function storeSpecialty(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:specialties,name']);
        $this->specialtyService->addSpecialty($request->name);
        return redirect()->route('coach.team')->with('success', 'SPECIALTY_REGISTERED // Matrix_Updated');
    }

    /**
     * Specialty Management: Update
     */
    public function updateSpecialty(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|unique:specialties,name,' . $id]);
        $this->specialtyService->updateSpecialty($id, $request->name);
        return redirect()->route('coach.team')->with('success', 'SPECIALTY_MODIFIED // Matrix_Calibrated');
    }

    /**
     * Specialty Management: Remove
     */
    public function destroySpecialty($id)
    {
        $this->specialtyService->deleteSpecialty($id);
        return redirect()->route('coach.team')->with('success', 'SPECIALTY_DELETED // Matrix_Updated');
    }
}
