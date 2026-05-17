<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/', function() { return redirect()->route('login'); });
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware([\App\Http\Middleware\CheckMobileAuth::class])->group(function () {
    Route::get('/client/{id}/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::get('/api/client/{id}/metrics', [DashboardController::class, 'metrics']);
    Route::post('/api/client/{id}/metrics', [DashboardController::class, 'updateMetrics']);

    Route::get('/client/{id}/program', [ProgramController::class, 'show'])->name('program');
    Route::get('/api/client/{id}/program', [ProgramController::class, 'api']);
});