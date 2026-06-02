<?php


use App\Http\Controllers\public\landingPage;
use App\Http\Controllers\Coach\DashboardController;
use App\Http\Controllers\Coach\ClientController;
use App\Http\Controllers\Coach\NutritionController;
use App\Http\Controllers\Coach\PaymentController;
use App\Http\Controllers\Coach\StaffController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\EvolutionController;
use App\Http\Controllers\Client\MealValidationController;
use App\Http\Controllers\ProfileSettingsController;
use Illuminate\Support\Facades\Route;

Route::get("/", [landingPage::class,"index"])->name("landingpage");
Route::post("/contact", [landingPage::class, "submitContact"])->name("contact.submit");

// Public Signed Downloads
Route::get('/receipts/{id}/download/signed', [App\Http\Controllers\Coach\PaymentController::class, 'downloadReceiptSigned'])
    ->name('receipts.download.signed')
    ->middleware('signed');

// Profile Settings (Shared)
Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [ProfileSettingsController::class, 'index'])->name('profile.settings');
    Route::put('/settings', [ProfileSettingsController::class, 'update'])->name('profile.settings.update');
    Route::put('/settings/password', [ProfileSettingsController::class, 'updatePassword'])->name('profile.settings.password');
});

// Client Portal (Responsive Web Exp)
Route::prefix('client')->name('client.')->middleware(['auth', 'role:client'])->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/evolution', [EvolutionController::class, 'index'])->name('evolution.index');
    Route::post('/evolution', [EvolutionController::class, 'store'])->name('evolution.store');
    Route::delete('/evolution/{id}', [EvolutionController::class, 'destroy'])->name('evolution.destroy');
    
    Route::get('/programs', [ClientDashboardController::class, 'programs'])->name('programs.index');
    Route::get('/history', [ClientDashboardController::class, 'history'])->name('history.index');
    Route::post('/meals/validate', [MealValidationController::class, 'store'])->name('meals.validate');

    // Chat Messaging Space
    Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/contacts', [App\Http\Controllers\ChatController::class, 'getContacts'])->name('chat.contacts');
    Route::get('/chat/messages/{contactId}', [App\Http\Controllers\ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/send/{contactId}', [App\Http\Controllers\ChatController::class, 'send'])->name('chat.send');
});

Route::prefix('coach')->name('coach.')->middleware(['auth', 'role:admin|co-coach'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Chat Messaging Space
    Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/contacts', [App\Http\Controllers\ChatController::class, 'getContacts'])->name('chat.contacts');
    Route::get('/chat/messages/{contactId}', [App\Http\Controllers\ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/send/{contactId}', [App\Http\Controllers\ChatController::class, 'send'])->name('chat.send');
    
    // Client Management
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::post('/clients/{id}/assign', [ClientController::class, 'assignProgram'])->name('clients.assign');
    Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    
    // Nutrition Hub
    Route::get('/nutrition', [NutritionController::class, 'index'])->name('nutrition.index');
    Route::post('/nutrition/meals', [NutritionController::class, 'storeMeal'])->name('nutrition.meals.store');
    Route::put('/nutrition/meals/{meal}', [NutritionController::class, 'updateMeal'])->name('nutrition.meals.update');
    Route::delete('/nutrition/meals/{meal}', [NutritionController::class, 'destroyMeal'])->name('nutrition.meals.destroy');
    
    Route::get('/nutrition/programs/export', [NutritionController::class, 'exportPrograms'])->name('nutrition.programs.export');
    
    Route::get('/nutrition/programs', function() { return redirect()->route('coach.nutrition.index'); });
    Route::post('/nutrition/programs', [NutritionController::class, 'storeProgram'])->name('nutrition.programs.store');
    Route::delete('/nutrition/programs/{program}', [NutritionController::class, 'destroyProgram'])->name('nutrition.programs.destroy');
    
    // Categories
    Route::get('/nutrition/categories', [NutritionController::class, 'categories'])->name('nutrition.categories');
    Route::post('/nutrition/categories', [NutritionController::class, 'storeCategory'])->name('nutrition.categories.store');
    Route::put('/nutrition/categories/{category}', [NutritionController::class, 'updateCategory'])->name('nutrition.categories.update');
    Route::delete('/nutrition/categories/{category}', [NutritionController::class, 'destroyCategory'])->name('nutrition.categories.destroy');
    // --- ADMIN ONLY SECTION ---
    Route::middleware(['role:admin'])->group(function () {
        // Team Registry
        Route::get('/team', [StaffController::class, 'index'])->name('team');
        Route::post('/team', [StaffController::class, 'store'])->name('team.store');
        Route::put('/team/{team}', [StaffController::class, 'update'])->name('team.update');
        Route::delete('/team/{team}', [StaffController::class, 'destroy'])->name('team.destroy');

        // Specialty Management
        Route::post('/team/specialties', [StaffController::class, 'storeSpecialty'])->name('team.specialties.store');
        Route::put('/team/specialties/{specialty}', [StaffController::class, 'updateSpecialty'])->name('team.specialties.update');
        Route::delete('/team/specialties/{specialty}', [StaffController::class, 'destroySpecialty'])->name('team.specialties.destroy');

        // Finance Flow
        Route::get('/finance', [PaymentController::class, 'index'])->name('finance');
        Route::post('/finance', [PaymentController::class, 'store'])->name('finance.store');
        Route::get('/finance/{id}/receipt', [PaymentController::class, 'downloadReceipt'])->name('finance.receipt.download');
        Route::put('/finance/{finance}', [PaymentController::class, 'update'])->name('finance.update');
        Route::delete('/finance/{finance}', [PaymentController::class, 'destroy'])->name('finance.destroy');

        // System Settings
        Route::post('/settings/update', [DashboardController::class, 'updateSettings'])->name('settings.update');
    });
});



Auth::routes(['register' => false]);

Route::get('/home', function() {
    return redirect()->route('coach.dashboard');
})->name('home');
