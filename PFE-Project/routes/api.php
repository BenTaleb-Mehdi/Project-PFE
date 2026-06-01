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
use App\Http\Controllers\Api\NotificationController;

// --- Nutrition AI ---
Route::post('/nutrition/categories/ai-create', [MealCategoryController::class, 'store']);

// --- n8n Chatbot (legacy) ---
Route::post('/chatbot/send', [ChatbotController::class, 'sendToN8n']);


// --- System Notifications (auth required via session cookie) ---
Route::middleware('web')->group(function () {
    Route::get('/notifications',          [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead']);
});

// --- Client Metrics (duplicate-safe) ---
Route::get('/client/{id}/metrics',  [ClientMetricsController::class, 'show']);
Route::post('/client/{id}/metrics', [ClientMetricsController::class, 'update']);
Route::get('/client/{id}/program',  [ClientProgramController::class, 'show']);
