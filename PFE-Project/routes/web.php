<?php


use App\Http\Controllers\public\landingPage;
use Illuminate\Support\Facades\Route;



Route::get("/", [landingPage::class,"index"])->name("landingpage");


