<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\MealCategory;
use App\Models\Meal;
use App\Services\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\MealCategorySeeder;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CategoryService();
        $this->seed(MealCategorySeeder::class);
    }

    public function test_it_can_get_all_sequence_slots()
    {
        $slots = $this->service->getSequenceSlots();
        $this->assertNotEmpty($slots);
        $this->assertInstanceOf(MealCategory::class, $slots->first());
    }

    public function test_it_can_add_a_sequence_slot()
    {
        $name = 'New Test Category';
        $category = $this->service->addSequenceSlot($name);

        $this->assertDatabaseHas('meal_categories', [
            'name' => $name
        ]);
        $this->assertEquals($name, $category->name);
    }

    public function test_it_can_update_a_sequence_slot()
    {
        $category = MealCategory::first();
        $newName = 'Updated Category Name';

        $updatedCategory = $this->service->updateSequenceSlot($category->id, $newName);

        $this->assertEquals($newName, $updatedCategory->name);
        $this->assertDatabaseHas('meal_categories', [
            'id' => $category->id,
            'name' => $newName
        ]);
    }

    public function test_it_can_delete_a_category_without_meals()
    {
        $category = MealCategory::create(['name' => 'Empty Category']);
        
        $result = $this->service->deleteSequenceSlot($category->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('meal_categories', ['id' => $category->id]);
    }

    public function test_it_throws_exception_when_deleting_category_with_meals()
    {
        // Seeder already ran in setUp
        $category = MealCategory::first();
        
        Meal::create([
            'name' => 'Test Meal',
            'category_id' => $category->id,
            'protein' => 20,
            'carbs' => 30,
            'fats' => 10,
            'calories' => 300
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Cannot delete category: Contains 1 meals.");

        $this->service->deleteSequenceSlot($category->id);
    }
}
