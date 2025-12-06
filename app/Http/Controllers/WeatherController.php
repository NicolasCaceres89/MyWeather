<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use App\Models\Location;
use App\Models\Consult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function showSearchForm(): View
    {
        return view('weather.search');
    }

    public function search(Request $request): View
    {
        $request->validate([
            'city_name' => 'required|string|max:255',
        ]);
        
        $cityName = $request->input('city_name');
        
        // Buscar por nombre de ciudad usando la API de clima (OpenWeatherMap soporta q=city)
        $weatherData = $this->weatherService->fetchWeatherByCity($cityName);

        if ($weatherData && isset($weatherData['coord'])) {
            $latitude = $weatherData['coord']['lat'] ?? null;
            $longitude = $weatherData['coord']['lon'] ?? null;

            $location = Location::firstOrCreate(
                ['latitude' => $latitude ?? 0, 'longitude' => $longitude ?? 0],
                [
                    'cityName' => $cityName,
                    'name' => $weatherData['name'] ?? $cityName,
                    'country' => $weatherData['sys']['country'] ?? null,
                    'latitude' => $latitude ?? 0,
                    'longitude' => $longitude ?? 0,
                ]
            );
        } else {
            // Fallback si la API no respondió, crear registro con datos mínimos
            $location = Location::firstOrCreate(
                ['cityName' => $cityName],
                ['name' => $cityName, 'country' => null, 'latitude' => 0, 'longitude' => 0]
            );
        }

        Consult::create([
            'user_id' => Auth::id(),
            'location_id' => $location->id,
            'search_term' => $cityName,
            'was_successful' => $weatherData !== null,
        ]);
        
        $results = [
            'location' => $location,
            'weather' => $weatherData ?? ['error' => 'No se pudo obtener el clima de la API externa.'],
            'status' => $weatherData ? 'success' : 'error'
        ];
        
        return view('weather.search', [
            'results' => $results,
            'search_term' => $cityName
        ]);
    }
}