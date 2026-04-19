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
            $user = auth()->user();
            $staffId = $user->staff->id ?? 1; // Dev_Mode_Fallback // Use Staff_1

            $program = Program::create(['title' => $name, 'created_by_staff_id' => $staffId]);
            
            foreach ($items as $item) {
                // V3_Integrity_Node // Skip empty slots to prevent data-sync failures
                if (empty($item['meal_id'])) continue;

                $program->items()->create([
                    'meal_id' => $item['meal_id'],
                    'day_of_week' => $item['day'],
                    'time_slot' => $item['slot']
                ]);
            }
            return $program;
        });
    }

    /**
     * Get all meals with categories.
     */
    public function getMeals($search = null, $category = 'ALL_CATEGORIES')
    {
        $query = Meal::select(['id', 'name', 'category_id', 'protein', 'carbs', 'fats', 'calories', 'details'])
            ->with('category');

        if ($search) {
            $query->where('name', 'like', "%$search%");
        }

        if ($category !== 'ALL_CATEGORIES') {
            $query->whereHas('category', fn($q) => $q->where('name', $category));
        }

        return $query->get();
    }

    /**
     * Get all nutritional programs.
     */
    public function getPrograms($search = null)
    {
        $query = Program::with(['items.meal.category'])->withCount('items');

        if ($search) {
            $query->where('title', 'like', "%$search%");
        }

        return $query->get();
    }
}