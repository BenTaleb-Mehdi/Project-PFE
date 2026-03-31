<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;

Route::get('/client/{id}/dashboard', function ($id) {
    return view('dashboard', ['clientId' => $id]);
});