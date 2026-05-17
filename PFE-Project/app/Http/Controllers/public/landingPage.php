<?php

namespace App\Http\Controllers\public;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class landingPage extends Controller
{
    public function index(){
        $whatsappNumber = \App\Models\SystemSetting::getVal('whatsapp_number', '212600000000');
        
        $jsonPath = public_path('data.json');
        $landingpageData = [];
        if (file_exists($jsonPath)) {
            $landingpageData = json_decode(file_get_contents($jsonPath), true) ?? [];
        }

        return view("landingpage", array_merge([
            'whatsappNumber' => $whatsappNumber,
        ], $landingpageData));
    }
}
