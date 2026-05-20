<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\ClientProgramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MealValidationController extends Controller
{
    protected $clientProgramService;

    public function __construct(ClientProgramService $clientProgramService)
    {
        $this->clientProgramService = $clientProgramService;
    }

    /**
     * Validate a meal for today.
     */
    public function store(Request $request)
    {
        $request->validate([
            'program_item_id' => 'required|exists:program_items,id',
        ]);

        $client = Auth::user()->client;

        if (!$client) {
            return back()->with('error', 'Client context not found.');
        }

        $this->clientProgramService->validateMeal($client->id, $request->program_item_id);

        return back()->with('success', 'Meal validated! Sequence progress updated.');
    }
}
