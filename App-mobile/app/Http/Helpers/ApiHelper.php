<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Http;

class ApiHelper
{
    /**
     * Try multiple base URLs to reach the PFE-Project API.
     * - 127.0.0.1:8000 works for web browser testing (same PC)
     * - 10.0.2.2:8000  works for Android emulator (NativePHP)
     */
    public static function fetchFromApi(string $path): ?\Illuminate\Http\Client\Response
    {
        $urls = array_unique(array_filter([
            'http://127.0.0.1:8000/api',
            'http://localhost:8000/api',
            'http://10.0.2.2:8000/api', // Android Emulator Host
            env('WEB_A_API_URL'),
        ]));

        $lastResponse = null;

        foreach ($urls as $baseUrl) {
            try {
                $response = Http::timeout(3)
                    ->withHeaders([
                        'Accept' => 'application/json',
                        'X-Mobile-Client' => 'NativePHP/Android'
                    ])
                    ->get(rtrim($baseUrl, '/') . '/' . ltrim($path, '/'));
                
                if ($response->successful()) {
                    return $response;
                }
                $lastResponse = $response;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("API Bridge Failed: {$baseUrl} - " . $e->getMessage());
                continue;
            }
        }

        return $lastResponse;
    }

    public static function postToApi(string $path, array $data): ?\Illuminate\Http\Client\Response
    {
        $urls = array_unique(array_filter([
            'http://127.0.0.1:8000/api',
            'http://localhost:8000/api',
            'http://10.0.2.2:8000/api', // Android Emulator Host
            env('WEB_A_API_URL'),
        ]));

        $lastResponse = null;

        foreach ($urls as $baseUrl) {
            try {
                $response = Http::timeout(3)
                    ->withHeaders([
                        'Accept' => 'application/json',
                        'X-Mobile-Client' => 'NativePHP/Android'
                    ])
                    ->post(rtrim($baseUrl, '/') . '/' . ltrim($path, '/'), $data);
                
                if ($response->successful()) {
                    return $response;
                }
                $lastResponse = $response;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("API Bridge Failed: {$baseUrl} - " . $e->getMessage());
                continue;
            }
        }

        return $lastResponse;
    }
}
