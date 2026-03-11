<?php
namespace App\Services;

use App\Models\Meal;
use App\Models\Program;
use Illuminate\Support\Facades\DB;

class NutritionService {
    // Logic dial l-Meal Creator
    public function registerMeal(array $data) {
        $data['calories'] = ($data['protein'] * 4) + ($data['carbs'] * 4) + ($data['fats'] * 9);
        return Meal::create($data);
    }

    // Logic dial PROTOCOL_TIMELINE_BUILDER
    public function finalizeProtocol(string $name, array $items) {
        return DB::transaction(function () use ($name, $items) {
            $program = Program::create(['title' => $name, 'created_by_staff_id' => auth()->id()]);
            
            foreach ($items as $item) {
                $program->items()->create([
                    'meal_id' => $item['meal_id'],
                    'day_of_week' => $item['day'],
                    'time_slot' => $item['slot']
                ]);
            }
            return $program;
        });
    }
}