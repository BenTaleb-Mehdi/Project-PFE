<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Program;
use Illuminate\Http\Request;

class ClientProgramController extends Controller
{
    public function show($id)
    {
        // For the MVP, as there is no pivot table mapping Client to Program, 
        // we will fetch the latest Program as the active program.
        $program = Program::with(['items.meal.category'])->latest()->first();

        if (!$program) {
            return response()->json([
                'success' => true,
                'data' => [
                    'program_title' => 'No Active Program',
                    'dailyMacros' => [
                        'kcal' => 0,
                        'p' => 0,
                        'c' => 0,
                        'f' => 0
                    ],
                    'meals' => []
                ]
            ]);
        }

        $mealsData = [];
        $totalKcal = 0; 
        $totalP = 0; 
        $totalC = 0; 
        $totalF = 0;

        foreach ($program->items as $item) {
            $meal = $item->meal;
            $mealsData[] = [
                'cat' => $meal->category->name ?? 'Meal',
                'time' => $item->time_slot ?? '00:00',
                'menu' => $meal->name,
                'kcal' => $meal->calories,
                'p' => $meal->protein,
                'c' => $meal->carbs,
                'f' => $meal->fats,
                'details' => $meal->details
            ];

            $totalKcal += $meal->calories;
            $totalP += $meal->protein;
            $totalC += $meal->carbs;
            $totalF += $meal->fats;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'program_title' => $program->title,
                'dailyMacros' => [
                    'kcal' => $totalKcal,
                    'p' => $totalP,
                    'c' => $totalC,
                    'f' => $totalF
                ],
                'meals' => $mealsData
            ]
        ]);
    }
}
