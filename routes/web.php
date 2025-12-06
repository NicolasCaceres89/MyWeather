<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\ConsultController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/index', function () {
    return view('welcome');
})->name('index'); 

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Weather Routes (Consolidadas)
    // GET /weather/search (Muestra el formulario)
    Route::get('/weather/search', [WeatherController::class, 'showSearchForm'])->name('weather.search');
    // POST /weather/search (Procesa el formulario)
    Route::post('/weather/search', [WeatherController::class, 'search'])->name('weather.search.submit');
    
    // Consults Routes
    Route::get('/consults', [ConsultController::class, 'index'])->name('consults.index');

    // Preferences Routes
    Route::get('/preferences', [PreferenceController::class, 'edit'])->name('preferences.edit');
    Route::put('/preferences', [PreferenceController::class, 'update'])->name('preferences.update');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Favorite Routes
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::get('/favorites/{id}', [FavoriteController::class, 'show'])->name('favorites.show');
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // Locations Routes
    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
});

require __DIR__.'/auth.php';