<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Meal;
use App\Models\Program;
use App\Models\MealCategory;
use App\Services\NutritionService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NutritionServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new NutritionService();
        
        $user = User::factory()->create();
        Auth::login($user);
    }

    public function test_it_registers_meal_with_calculated_calories()
    {
        $category = MealCategory::first();
        $data = [
            'category_id' => $category->id,
            'name' => 'Test Healthy Meal',
            'protein' => 20,
            'carbs' => 30,
            'fats' => 10
        ];

        $meal = $this->service->registerMeal($data);

        $this->assertDatabaseHas('meals', ['name' => 'Test Healthy Meal']);
        
        // Calories = (20 * 4) + (30 * 4) + (10 * 9) = 80 + 120 + 90 = 290
        $this->assertEquals(290, $meal->calories);
    }

    public function test_it_finalizes_protocol_in_transaction()
    {
        $meal = Meal::first();
        $items = [
            ['meal_id' => $meal->id, 'day' => 'Monday', 'slot' => 'Breakfast'],
            ['meal_id' => $meal->id, 'day' => 'Monday', 'slot' => 'Lunch']
        ];

        $program = $this->service->finalizeProtocol('Weight Loss Plan', $items);

        $this->assertInstanceOf(Program::class, $program);
        $this->assertEquals('Weight Loss Plan', $program->title);
        $this->assertCount(2, $program->items);
        $this->assertDatabaseHas('programs', ['title' => 'Weight Loss Plan']);
        $this->assertDatabaseHas('program_items', ['program_id' => $program->id, 'meal_id' => $meal->id]);
    }
}
