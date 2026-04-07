<?php
namespace App\Services;

use App\Models\Meal;
use App\Models\Program;
use Illuminate\Support\Facades\DB;

class NutritionService {
    public function registerMeal(array $data) {
        $data['protein'] = (float)($data['protein'] ?? 0);
        $data['carbs'] = (float)($data['carbs'] ?? 0);
        $data['fats'] = (float)($data['fats'] ?? 0);
        
        $data['calories'] = ($data['protein'] * 4) + ($data['carbs'] * 4) + ($data['fats'] * 9);
        return Meal::create($data);
    }

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