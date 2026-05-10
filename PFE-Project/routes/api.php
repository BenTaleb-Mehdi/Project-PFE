<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientMetricsController;
use App\Http\Controllers\ClientProgramController;
use App\Http\Controllers\Api\MealCategoryController;
use App\Http\Controllers\Api\ChatbotController;

Route::post('/nutrition/categories/ai-create', [MealCategoryController::class, 'store']);
Route::post('/chatbot/send', [ChatbotController::class, 'sendToN8n']);
Route::get('/client/{id}/metrics', [ClientMetricsController::class, 'show']);
Route::post('/client/{id}/metrics', [ClientMetricsController::class, 'update']);
Route::get('/client/{id}/program', [ClientProgramController::class, 'show']);