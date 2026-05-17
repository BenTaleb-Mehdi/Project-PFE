<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientMetricsController;
use App\Http\Controllers\ClientProgramController;

use App\Http\Controllers\Api\LoginController;

Route::post('/auth/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [LoginController::class, 'logout']);
    Route::get('/client/{id}/metrics', [ClientMetricsController::class, 'show']);
    Route::post('/client/{id}/metrics', [ClientMetricsController::class, 'update']);
    Route::get('/client/{id}/program', [ClientProgramController::class, 'show']);
});

use App\Http\Controllers\Api\MealCategoryController;
use App\Http\Controllers\Api\ChatbotController;

Route::post('/nutrition/categories/ai-create', [MealCategoryController::class, 'store']);
Route::post('/chatbot/send', [ChatbotController::class, 'sendToN8n']);
Route::get('/client/{id}/metrics', [ClientMetricsController::class, 'show']);
Route::post('/client/{id}/metrics', [ClientMetricsController::class, 'update']);
Route::get('/client/{id}/program', [ClientProgramController::class, 'show']);

