<?php

namespace App\Services;

use App\Models\Program;

class ClientProgramService
{
    /**
     * Get the active program data formatted for the mobile client.
     *
     * For the MVP, since there is no pivot table mapping a Client to a Program,
     * we fetch the latest Program as the active one.
     *
     * @param int $clientId
     * @return array
     */
    public function getClientProgramData(int $clientId): array
    {
        $program = Program::with(['items.meal.category'])->latest()->first();

        if (!$program) {
            return $this->emptyProgramResponse();
        }

        $mealsData = [];
        $totalKcal  = 0;
        $totalP     = 0;
        $totalC     = 0;
        $totalF     = 0;

        foreach ($program->items as $item) {
            $meal = $item->meal;

            $mealsData[] = [
                'cat'     => $meal->category->name ?? 'Meal',
                'time'    => $item->time_slot ?? '00:00',
                'menu'    => $meal->name,
                'kcal'    => $meal->calories,
                'p'       => $meal->protein,
                'c'       => $meal->carbs,
                'f'       => $meal->fats,
                'details' => $meal->details,
            ];

            $totalKcal += $meal->calories;
            $totalP    += $meal->protein;
            $totalC    += $meal->carbs;
            $totalF    += $meal->fats;
        }

        return [
            'program_title' => $program->title,
            'dailyMacros'   => [
                'kcal' => $totalKcal,
                'p'    => $totalP,
                'c'    => $totalC,
                'f'    => $totalF,
            ],
            'meals' => $mealsData,
        ];
    }

    /**
     * Return a default empty program structure when no program is found.
     */
    private function emptyProgramResponse(): array
    {
        return [
            'program_title' => 'No Active Program',
            'dailyMacros'   => [
                'kcal' => 0,
                'p'    => 0,
                'c'    => 0,
                'f'    => 0,
            ],
            'meals' => [],
        ];
    }
}
