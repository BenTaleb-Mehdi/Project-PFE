<?php

namespace App\Services;

use App\Models\SystemSetting;

class LandingPageService
{
    /**
     * Retrieve all landing page information and settings.
     *
     * @return array
     */
    public function getLandingPageData(): array
    {
        $whatsappNumber = SystemSetting::getVal('whatsapp_number', '212600000000');
        
        $jsonPath = public_path('data.json');
        $landingpageData = [];
        if (file_exists($jsonPath)) {
            $landingpageData = json_decode(file_get_contents($jsonPath), true) ?? [];
        }

        return array_merge([
            'whatsappNumber' => $whatsappNumber,
        ], $landingpageData);
    }
}
