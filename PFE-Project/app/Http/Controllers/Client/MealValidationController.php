<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MealValidation;
use Illuminate\Support\Facades\Auth;

class MealValidationController extends Controller
{
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

        MealValidation::updateOrCreate([
            'client_id'       => $client->id,
            'program_item_id' => $request->program_item_id,
            'validated_for'   => now()->toDateString(),
        ]);

        return back()->with('success', 'Meal validated! Sequence progress updated.');
    }
}
