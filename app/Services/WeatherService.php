<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('WEATHER_API_KEY');
        $this->baseUrl = env('WEATHER_API_URL', 'https://api.weather.example.com/data'); 
    }

    public function fetchWeatherByLocation(float $latitude, float $longitude): ?array
    {
        if (empty($this->apiKey)) {
            Log::error('API Key no definida en .env');
            return null;
        }

        try {
            // Ensure we build a correct endpoint regardless of trailing slash in baseUrl
            $base = rtrim($this->baseUrl, '/');
            // OpenWeatherMap current weather endpoint is `weather`
            $endpoint = "{$base}/weather";

            $response = Http::timeout(10)->get($endpoint, [
                'lat' => $latitude,
                'lon' => $longitude,
                'appid' => $this->apiKey,
                'units' => 'metric',
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('Weather API falló', [
                'status' => $response->status(), 
                'body' => $response->body()
            ]);
            return null;

        } catch (\Exception $e) {
            Log::error('Excepción al conectar con la API: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Fetch weather by city name (OpenWeatherMap supports `q=city` parameter).
     * Returns decoded JSON array on success or null on failure.
     *
     * @param string $cityName
     * @return array|null
     */
    public function fetchWeatherByCity(string $cityName): ?array
    {
        if (empty($this->apiKey)) {
            Log::error('API Key no definida en .env');
            return null;
        }

        try {
            $base = rtrim($this->baseUrl, '/');
            $endpoint = "{$base}/weather";

            $response = Http::timeout(10)->get($endpoint, [
                'q' => $cityName,
                'appid' => $this->apiKey,
                'units' => 'metric',
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('Weather API falló (city)', [
                'city' => $cityName,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Excepción al conectar con la API (city): ' . $e->getMessage());
            return null;
        }
    }
}