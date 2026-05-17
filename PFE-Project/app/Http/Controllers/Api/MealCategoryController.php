<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class MealCategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

  public function store(Request $request)
{
    // 1. Validation kattrje3 array
    $data = $request->validate([
        'name' => 'required|string|max:255',
    ]);

    // 2. Sift ghir l-String 'name' l-service (machi l-$data kamla)
    $category = $this->categoryService->addSequenceSlot($data['name']);

    return response()->json([
        'status' => 'success',
        'message' => 'Category created via AI Chatbot',
        'data' => $category
    ], 201);
}
}