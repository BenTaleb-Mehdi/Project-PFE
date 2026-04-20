<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('coach.dashboard');
    }

    public function team()
    {
        return view('coach.team');
    }

    public function finance()
    {
        return view('coach.finance');
    }
}
