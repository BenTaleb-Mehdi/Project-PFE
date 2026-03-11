<?php
namespace App\Services;

use App\Models\MealCategory;
use Illuminate\Support\Facades\DB;

class CategoryService 
{
    /**
     * Get all categories for the sequence builder.
     */
    public function getSequenceSlots() 
    {
        return MealCategory::orderBy('id', 'asc')->get();
    }

    /**
     * Create a new sequence slot (Category).
     */
    public function addSequenceSlot(string $name) 
    {
        return MealCategory::create(['name' => $name]);
    }

    /**
     * Update an existing category name.
     */
    public function updateSequenceSlot(int $id, string $newName) 
    {
        $category = MealCategory::findOrFail($id);
        $category->update(['name' => $newName]);
        return $category;
    }

    /**
     * Delete a category.
     * Rule: Prevent deletion if meals are attached (Data Integrity).
     */
    public function deleteSequenceSlot(int $id) 
    {
        return DB::transaction(function () use ($id) {
            $category = MealCategory::withCount('meals')->findOrFail($id);

            if ($category->meals_count > 0) {
                // Tqder t-throwi custom exception hna bach t-afichiha f l-UI
                throw new \Exception("Cannot delete category: Contains " . $category->meals_count . " meals.");
            }

            return $category->delete();
        });
    }
}