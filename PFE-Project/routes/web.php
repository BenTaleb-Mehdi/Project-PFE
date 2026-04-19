<?php


use App\Http\Controllers\public\landingPage;
use App\Http\Controllers\Coach\DashboardController;
use App\Http\Controllers\Coach\ClientController;
use App\Http\Controllers\Coach\NutritionController;
use App\Http\Controllers\Coach\PaymentController;
use App\Http\Controllers\Coach\StaffController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\EvolutionController;
use Illuminate\Support\Facades\Route;

Route::get("/", [landingPage::class,"index"])->name("landingpage");

// Client Portal (Responsive Web Exp)
Route::prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/evolution', [EvolutionController::class, 'index'])->name('evolution.index');
    Route::post('/evolution', [EvolutionController::class, 'store'])->name('evolution.store');
    
    Route::get('/programs', [ClientDashboardController::class, 'programs'])->name('programs.index');
    Route::get('/history', [ClientDashboardController::class, 'history'])->name('history.index');
});

Route::prefix('coach')->name('coach.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Client Management
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::post('/clients/{id}/assign', [ClientController::class, 'assignProgram'])->name('clients.assign');
    Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    
    // Nutrition Hub
    Route::get('/nutrition', [NutritionController::class, 'index'])->name('nutrition.index');
    Route::post('/nutrition/meals', [NutritionController::class, 'storeMeal'])->name('nutrition.meals.store');
    
    Route::get('/nutrition/programs', function() { return redirect()->route('coach.nutrition.index'); });
    Route::post('/nutrition/programs', [NutritionController::class, 'storeProgram'])->name('nutrition.programs.store');
    Route::delete('/nutrition/programs/{program}', [NutritionController::class, 'destroyProgram'])->name('nutrition.programs.destroy');
    
    // Categories
    Route::get('/nutrition/categories', [NutritionController::class, 'categories'])->name('nutrition.categories');
    Route::post('/nutrition/categories', [NutritionController::class, 'storeCategory'])->name('nutrition.categories.store');
    Route::put('/nutrition/categories/{category}', [NutritionController::class, 'updateCategory'])->name('nutrition.categories.update');
    Route::delete('/nutrition/categories/{category}', [NutritionController::class, 'destroyCategory'])->name('nutrition.categories.destroy');

    // Team Registry
    Route::get('/team', [StaffController::class, 'index'])->name('team');
    Route::post('/team', [StaffController::class, 'store'])->name('team.store');
    Route::put('/team/{team}', [StaffController::class, 'update'])->name('team.update');
    Route::delete('/team/{team}', [StaffController::class, 'destroy'])->name('team.destroy');

    // Finance Flow
    Route::get('/finance', [PaymentController::class, 'index'])->name('finance');
    Route::post('/finance', [PaymentController::class, 'store'])->name('finance.store');
    Route::put('/finance/{finance}', [PaymentController::class, 'update'])->name('finance.update');
    Route::delete('/finance/{finance}', [PaymentController::class, 'destroy'])->name('finance.destroy');
});


