<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientMetricsController;
use App\Http\Controllers\ClientProgramController;

Route::get('/client/{id}/metrics', [ClientMetricsController::class, 'show']);
Route::post('/client/{id}/metrics', [ClientMetricsController::class, 'update']);
Route::get('/client/{id}/program', [ClientProgramController::class, 'show']);