<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coach\StoreMealRequest;
use App\Http\Requests\Coach\StoreCategoryRequest;
use App\Services\NutritionService;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProgramsExport;

class NutritionController extends Controller
{
    protected $nutritionService;
    protected $categoryService;

    public function __construct(NutritionService $nutritionService, CategoryService $categoryService)
    {
        $this->nutritionService = $nutritionService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        ini_set('memory_limit', '512M'); // V3_Safety_Node // Support High-Capacity Protocols
        $categories = $this->categoryService->getSequenceSlots();
        
        $meals = $this->nutritionService->getMeals(
            $request->meal_search, 
            $request->meal_category ?? 'ALL_CATEGORIES'
        );
        
        $programs = $this->nutritionService->getPrograms(
            $request->program_search
        );
        
        return view('coach.nutrition.index', compact('categories', 'meals', 'programs'));
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

    public function updateMeal(StoreMealRequest $request, $id)
    {
        $this->nutritionService->updateMeal($id, $request->validated());
        return redirect()->back()->with('success', 'MEAL_MODIFIED // Update_Live');
    }

    public function destroyMeal($id)
    {
        $this->nutritionService->deleteMeal($id);
        return redirect()->back()->with('success', 'MEAL_WIPED // Node_Removed');
    }

    /* Program Actions */
    public function storeProgram(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'items' => 'required|array',
            'id' => 'nullable|integer|exists:programs,id'
        ]);

        $this->nutritionService->finalizeProtocol($request->title, $request->items, $request->id);
        return redirect()->back()->with('success', 'PROTOCOL_FINALIZED // Grid_Sync_Complete');
    }

    public function destroyProgram($id)
    {
        \App\Models\Program::destroy($id);
        return redirect()->back()->with('success', 'PROTOCOL_PURGED // Node_Removed');
    }

    public function exportPrograms()
    {
        return Excel::download(new ProgramsExport, 'nutrition_programs_' . date('Y-m-d') . '.xlsx');
    }
}
