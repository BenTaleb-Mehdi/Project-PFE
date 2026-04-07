<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coach\StoreMealRequest;
use App\Http\Requests\Coach\StoreCategoryRequest;
use App\Services\NutritionService;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class NutritionController extends Controller
{
    protected $nutritionService;
    protected $categoryService;

    public function __construct(NutritionService $nutritionService, CategoryService $categoryService)
    {
        $this->nutritionService = $nutritionService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getSequenceSlots();
        // Assuming we'll need programs later, but for now just categories for the meal creator
        return view('coach.nutrition.index', compact('categories'));
    }

    public function categories()
    {
        $categories = $this->categoryService->getSequenceSlots();
        return view('coach.nutrition.categories', compact('categories'));
    }

    /* Category Actions */
    public function storeCategory(StoreCategoryRequest $request)
    {
        $this->categoryService->addSequenceSlot($request->name);
        return redirect()->back()->with('success', 'CATEGORY_CREATED // ID_Sync');
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|unique:meal_categories,name,'.$id]);
        $this->categoryService->updateSequenceSlot($id, $request->name);
        return redirect()->back()->with('success', 'CATEGORY_MODIFIED // Update_Live');
    }

    public function destroyCategory($id)
    {
        try {
            $this->categoryService->deleteSequenceSlot($id);
            return redirect()->back()->with('success', 'CATEGORY_WIPED // Node_Removed');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /* Meal Actions */
    public function storeMeal(StoreMealRequest $request)
    {
        $this->nutritionService->registerMeal($request->validated());
        return redirect()->back()->with('success', 'MEAL_CATALOGUED // Bio_Data_Active');
    }
}
