<?php


use App\Http\Controllers\public\landingPage;
use App\Http\Controllers\Coach\DashboardController;
use App\Http\Controllers\Coach\ClientController;
use App\Http\Controllers\Coach\NutritionController;
use Illuminate\Support\Facades\Route;

Route::get("/", [landingPage::class,"index"])->name("landingpage");

Route::prefix('coach')->name('coach.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Client Management
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    
    // Nutrition Hub
    Route::get('/nutrition', [NutritionController::class, 'index'])->name('nutrition.index');
    Route::post('/nutrition/meals', [NutritionController::class, 'storeMeal'])->name('nutrition.meals.store');
    
    // Categories
    Route::get('/nutrition/categories', [NutritionController::class, 'categories'])->name('nutrition.categories');
    Route::post('/nutrition/categories', [NutritionController::class, 'storeCategory'])->name('nutrition.categories.store');
    Route::put('/nutrition/categories/{category}', [NutritionController::class, 'updateCategory'])->name('nutrition.categories.update');
    Route::delete('/nutrition/categories/{category}', [NutritionController::class, 'destroyCategory'])->name('nutrition.categories.destroy');

    Route::get('/team', [DashboardController::class, 'team'])->name('team');
    Route::get('/finance', [DashboardController::class, 'finance'])->name('finance');
});


