<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiHelper
{
    /**
     * Try multiple base URLs to reach the PFE-Project API.
     */
    protected static function getUrls(): array
    {
        return array_unique(array_filter([
            'http://127.0.0.1:8000/api',
            'http://localhost:8000/api',
            'http://10.0.2.2:8000/api', // Android Emulator Host
            'http://192.168.2.128:8000/api', // Machine IP
            'http://172.25.80.1:8000/api', // Default Switch
            env('WEB_A_API_URL'),
        ]));
    }

    protected static function getHeaders(): array
    {
        $headers = [
            'Accept' => 'application/json',
            'X-Mobile-Client' => 'NativePHP/Android'
        ];

        if (session()->has('api_token')) {
            $headers['Authorization'] = 'Bearer ' . session('api_token');
        }

        return $headers;
    }

    public static function fetchFromApi(string $path): ?\Illuminate\Http\Client\Response
    {
        $urls = self::getUrls();
        $lastResponse = null;

        foreach ($urls as $baseUrl) {
            $fullUrl = rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
            try {
                $response = Http::timeout(5)
                    ->withHeaders(self::getHeaders())
                    ->get($fullUrl);
                
                if ($response->successful()) {
                    return $response;
                }

                Log::warning("API_FETCH_ERROR // URL: {$fullUrl} // Status: " . $response->status() . " // Body: " . $response->body());
                $lastResponse = $response;
            } catch (\Exception $e) {
                Log::error("API_BRIDGE_EXCEPTION // URL: {$fullUrl} // Error: " . $e->getMessage());
                continue;
            }
        }

        return $lastResponse;
    }

    public static function postToApi(string $path, array $data): ?\Illuminate\Http\Client\Response
    {
        $urls = self::getUrls();
        $lastResponse = null;

        foreach ($urls as $baseUrl) {
            $fullUrl = rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
            try {
                $response = Http::timeout(5)
                    ->withHeaders(self::getHeaders())
                    ->post($fullUrl, $data);
                
                if ($response->successful()) {
                    return $response;
                }

                Log::warning("API_POST_ERROR // URL: {$fullUrl} // Status: " . $response->status() . " // Body: " . $response->body());
                $lastResponse = $response;
            } catch (\Exception $e) {
                Log::error("API_BRIDGE_EXCEPTION // URL: {$fullUrl} // Error: " . $e->getMessage());
                continue;
            }
        }

        return $lastResponse;
    }
}
