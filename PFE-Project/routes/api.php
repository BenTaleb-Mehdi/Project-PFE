<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientMetricsController;

Route::get('/client/{id}/metrics', [ClientMetricsController::class, 'show']);