<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use App\Services\LandingPageService;

class landingPage extends Controller
{
    protected $landingPageService;

    public function __construct(LandingPageService $landingPageService)
    {
        $this->landingPageService = $landingPageService;
    }

    public function index()
    {
        $data = $this->landingPageService->getLandingPageData();

        return view("landingpage", $data);
    }
}
