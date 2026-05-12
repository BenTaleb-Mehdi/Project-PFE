<?php

namespace App\Http\Controllers\public;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class landingPage extends Controller
{
    public function index(){
        $whatsappNumber = \App\Models\SystemSetting::getVal('whatsapp_number', '212600000000');
        return view("landingpage", compact('whatsappNumber'));
    }
}
