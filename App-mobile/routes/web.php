<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgramController;

Route::get('/client/{id}/dashboard', [DashboardController::class, 'show']);
Route::get('/api/client/{id}/metrics', [DashboardController::class, 'metrics']);

Route::get('/client/{id}/program', [ProgramController::class, 'show']);
Route::get('/api/client/{id}/program', [ProgramController::class, 'api']);