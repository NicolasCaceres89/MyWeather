@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <?php
        // 🚨 ADVERTENCIA: Esta es una consulta directa a la base de datos
        // (MALA PRÁCTICA, solo para cumplir con la petición inmediata)
        
        // 1. Importar los modelos y helpers necesarios
        use App\Models\Favorite;
        use App\Models\Consult;
        use Illuminate\Support\Facades\Auth;
        
        // Obtener ID del usuario
        $userId = Auth::id();

        // 2. Obtener datos para las estadísticas
        $totalLocations = Favorite::where('user_id', $userId)->count();
        $consultsThisMonth = Consult::where('user_id', $userId)
                                    ->where('created_at', '>=', now()->startOfMonth())
                                    ->count();
        
        $topFavorite = Favorite::where('user_id', $userId)
                                ->with('location')
                                ->latest()
                                ->first();
        
        // 3. Obtener la lista de ubicaciones favoritas (El arreglo que necesitabas)
        $favorites = Favorite::where('user_id', $userId)
                             ->with('location')
                             ->latest()
                             ->take(5) 
                             ->get();
                             
        // 4. Preparar el arreglo de estadísticas
        $stats = [
            'totalLocations' => $totalLocations,
            'consultsThisMonth' => $consultsThisMonth,
            'favoriteLocationName' => $topFavorite->location->name ?? 'N/A',
            'daysActive' => 24, 
        ];
    ?>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 w-full">
        <h2 class="text-3xl font-bold text-foreground mb-8">Hola, {{ Auth::user()->name ?? 'Usuario' }}</h2>

        {{-- Section: Stats --}}
        <h3 class="text-2xl font-bold text-foreground mb-6">Resumen</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-10">
            {{-- Ubicaciones Favoritas --}}
            <div class="bg-card p-6 shadow-lg rounded-lg border border-border flex items-center justify-between">
                <div>
                    <p class="text-sm text-muted-foreground">Ubicaciones</p>
                    <p class="text-3xl font-bold text-foreground mt-2">{{ $stats['totalLocations'] }}</p>
                </div>
                <svg class="w-12 h-12 text-primary opacity-30" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
            </div>
            
            {{-- Consultas del Mes --}}
            <div class="bg-card p-6 shadow-lg rounded-lg border border-border flex items-center justify-between">
                <div>
                    <p class="text-sm text-muted-foreground">Consultas (Mes)</p>
                    <p class="text-3xl font-bold text-foreground mt-2">{{ $stats['consultsThisMonth'] }}</p>
                </div>
                <svg class="w-12 h-12 text-primary opacity-30" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
            </div>
            
            {{-- Ubicación Favorita Principal --}}
            <div class="bg-card p-6 shadow-lg rounded-lg border border-border flex items-center justify-between">
                <div>
                    <p class="text-sm text-muted-foreground">Ubicación Fav.</p>
                    <p class="text-3xl font-bold text-foreground mt-2">{{ $stats['favoriteLocationName'] }}</p>
                </div>
                <svg class="w-12 h-12 text-primary opacity-30" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21.5c-4.97 0-9-4.03-9-9s4.03-9 9-9 9 4.03 9 9-4.03 9-9 9z"/><path d="M12 17a5 5 0 0 0-4-8v1h8v-1a5 5 0 0 0-4-8z"/></svg>
            </div>
            
            {{-- Días Activos --}}
            <div class="bg-card p-6 shadow-lg rounded-lg border border-border flex items-center justify-between">
                <div>
                    <p class="text-sm text-muted-foreground">Días Activos</p>
                    <p class="text-3xl font-bold text-foreground mt-2">{{ $stats['daysActive'] }}</p>
                </div>
                <svg class="w-12 h-12 text-primary opacity-30" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
        </div>
        
        {{-- Section: Favorite Locations (Ahora usa la variable $favorites generada arriba) --}}
        <h3 class="text-2xl font-bold text-foreground mb-6">Mis Ubicaciones Favoritas (Últimas 5)</h3>
        <div class="bg-card p-4 shadow-lg rounded-lg border border-border">
            @if ($favorites->isEmpty())
                <div class="text-center text-muted-foreground py-6">
                    <p>Aún no tienes ubicaciones favoritas guardadas.</p>
                    <a href="{{ route('weather.search') }}" class="text-primary hover:underline mt-2 inline-block">¡Busca y añade una ahora!</a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($favorites as $favorite)
                        <a href="{{ route('favorites.show', $favorite->id) }}" class="flex items-center justify-between p-4 rounded-lg bg-muted/50 hover:bg-muted transition duration-150">
                            <div class="flex items-center gap-4">
                                <div>
                                    <p class="font-semibold text-foreground">{{ $favorite->location->name }}</p>
                                    <p class="text-sm text-muted-foreground">{{ $favorite->location->country }}</p>
                                </div>
                            </div>
                            <svg class="w-6 h-6 text-yellow-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection