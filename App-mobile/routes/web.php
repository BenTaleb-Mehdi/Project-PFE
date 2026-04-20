<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgramController;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/client/{id}/dashboard', [DashboardController::class, 'show']);
Route::get('/api/client/{id}/metrics', [DashboardController::class, 'metrics']);
Route::post('/api/client/{id}/metrics', [DashboardController::class, 'updateMetrics']);

Route::get('/client/{id}/program', [ProgramController::class, 'show']);
Route::get('/api/client/{id}/program', [ProgramController::class, 'api']);