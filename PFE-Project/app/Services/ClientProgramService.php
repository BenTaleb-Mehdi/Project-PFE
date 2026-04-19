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
        $program = Program::with(['items.meal.category'])->withCount('items')->latest()->first();

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
            'items_count'   => $program->items_count,
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
     * Get all programs for the history archive view.
     */
    public function getAllPrograms()
    {
        return Program::with(['items.meal.category'])->withCount('items')->latest()->paginate(10);
    }

    /**
     * Return a default empty program structure when no program is found.
     */
    private function emptyProgramResponse(): array
    {
        return [
            'program_title' => 'NO_ACTIVE_PROTOCOL',
            'items_count'   => 0,
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
