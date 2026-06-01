<?php

namespace App\Services;

use App\Models\SystemSetting;

class LandingPageService
{
    public function getLandingPageData(): array
    {
        $whatsappNumber = SystemSetting::getVal('whatsapp_number', '212600000000');

        $jsonPath = resource_path('js/data.json');
        $raw = [];
        if (file_exists($jsonPath)) {
            $raw = json_decode(file_get_contents($jsonPath), true) ?? [];
        }

        return [
            'whatsappNumber' => $whatsappNumber,
            'gallery'        => $this->getGallery($raw),
            'features'       => $this->getFeatures($raw),
            'stats'          => $this->getStats($raw),
            'certs'          => $this->getCerts($raw),
            'timeline'       => $this->getTimeline($raw),
            'testimonials'   => $this->getTestimonials($raw),
            'posts'          => $raw['posts'] ?? [],
            'contactInfo'    => $this->getContactInfo($raw),
            'socials'        => $raw['socials'] ?? [],
        ];
    }

    private function getGallery(array $raw): array
    {
        return $raw['gallery'] ?? [
            ['before' => '/images/clients/client-01/before.jpg', 'after' => '/images/clients/client-01/after.jpg', 'alt' => 'Client Transformation',     'duration' => '12 Weeks', 'goal' => 'Fat Loss',    'details' => 'Lost 14kg with personalized nutrition and strength coaching.'],
            ['before' => '/images/clients/client-02/before.jpg', 'after' => '/images/clients/client-02/after.jpg', 'alt' => 'Body Recomposition',        'duration' => '16 Weeks', 'goal' => 'Muscle Gain', 'details' => 'Built lean muscle mass while reducing body fat percentage.'],
            ['before' => '/images/clients/client-03/before.jpg', 'after' => '/images/clients/client-03/after.jpg', 'alt' => 'Strength Transformation',   'duration' => '10 Weeks', 'goal' => 'Strength',    'details' => 'Improved overall strength and athletic performance.'],
        ];
    }

    private function getFeatures(array $raw): array
    {
        return $raw['features'] ?? [
            'Personalized programs — not templates',
            '24/7 WhatsApp support',
            'Weekly progress reviews',
            'Science-backed, no-BS approach',
        ];
    }

    private function getStats(array $raw): array
    {
        if (!empty($raw['stats'])) {
            return array_map(fn($s) => [
                'value' => $s['display'] ?? ($s['value'] ?? ''),
                'label' => $s['label'] ?? '',
            ], $raw['stats']);
        }
        return [
            ['value' => '500+', 'label' => 'Clients coached'],
            ['value' => '8+',   'label' => 'Years experience'],
            ['value' => '97%',  'label' => 'Client retention'],
            ['value' => '3x',   'label' => 'Avg strength gain'],
        ];
    }

    private function getCerts(array $raw): array
    {
        return $raw['certs'] ?? [
            'NSCA-CSCS',
            'NASM-CPT',
            'Precision Nutrition L2',
            'FMS Level 2',
        ];
    }

    private function getTimeline(array $raw): array
    {
        return $raw['timeline'] ?? [
            ['year' => '2016', 'title' => 'Started Fitness Journey',         'desc' => 'Began personal training after struggling with weight and energy for years.'],
            ['year' => '2017', 'title' => 'NASM Certification',              'desc' => 'Obtained CPT certification and began coaching clients at a local gym.'],
            ['year' => '2019', 'title' => 'NSCA-CSCS',                      'desc' => 'Earned the Certified Strength & Conditioning Specialist credential.'],
            ['year' => '2021', 'title' => 'Launched Online Coaching',        'desc' => 'Scaled to 100+ online clients worldwide using app-based programming.'],
            ['year' => '2024', 'title' => '500 Clients Milestone',           'desc' => 'Reached 500 transformed clients with a 97% retention rate.'],
        ];
    }

    private function getTestimonials(array $raw): array
    {
        if (!empty($raw['testimonials'])) {
            return array_map(fn($t) => [
                'name'   => $t['name'] ?? '',
                'quote'  => $t['quote'] ?? $t['text'] ?? '',
                'result' => $t['result'] ?? '',
            ], $raw['testimonials']);
        }
        return [
            ['name' => 'Sarah K.',  'quote' => 'Alex transformed not just my body but my entire relationship with fitness. Down 28 lbs in 16 weeks and I actually enjoy working out now.',       'result' => '–28 lbs in 16 weeks'],
            ['name' => 'Marcus T.', 'quote' => 'Best investment I\'ve ever made. The online program is incredibly detailed and the check-ins keep me accountable even when motivation dips.', 'result' => '+18 lbs muscle in 6 months'],
            ['name' => 'Priya M.',  'quote' => 'I was skeptical about online coaching but the app and daily support made it feel like Alex was right there with me every session.',           'result' => 'First 5K in 28 minutes'],
        ];
    }

    private function getContactInfo(array $raw): array
    {
        return $raw['contactInfo'] ?? [
            ['label' => 'Email',    'value' => 'alex@coachfitnesspro.com', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>'],
            ['label' => 'Location', 'value' => 'Los Angeles, CA (& online)', 'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'],
        ];
    }
}
