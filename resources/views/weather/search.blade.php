@extends('layouts.app')

@section('title', 'Buscar Clima')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-12 w-full">
        <h1 class="text-4xl font-bold text-primary mb-8 text-center">Búsqueda de Clima</h1>

        {{-- FORMULARIO CORREGIDO CON LA NUEVA RUTA --}}
        <form action="{{ route('weather.search.submit') }}" method="POST" class="mb-12">
            @csrf 
            <div class="relative">
                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input
                    type="text"
                    name="city_name" 
                    placeholder="Busca una ciudad, ej: Madrid"
                    value="{{ old('city_name', $search_term ?? '') }}"
                    class="w-full pl-12 pr-4 py-3 rounded-lg border border-border bg-card text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary"
                    required
                />
            </div>
            @error('city_name')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
            <div class="mt-4">
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md">Buscar</button>
            </div>
        </form>

        {{-- Mostrar Resultados (Lógica del WeatherController) --}}
        @isset($results)
            <div class="bg-card p-10 shadow-2xl rounded-xl">
                @if ($results['status'] === 'success')
                    <div class="text-center">
                        <h2 class="text-3xl font-bold text-foreground mb-2">{{ $results['location']->name }}</h2>
                        <p class="text-lg text-muted-foreground mb-6">{{ $results['location']->country }}</p>
                        @if(isset($results['location']->latitude) && isset($results['location']->longitude))
                            <div class="inline-block text-sm text-muted-foreground mb-4 px-3 py-2 bg-muted/10 rounded">
                                <strong>Ubicación:</strong>
                                {{ $results['location']->latitude }}, {{ $results['location']->longitude }}
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $results['location']->latitude }},{{ $results['location']->longitude }}" target="_blank" class="ml-3 text-primary underline">Ver en mapa</a>
                            </div>
                        @endif

                        <div class="text-6xl font-extrabold text-primary">
                            {{ $results['weather']['main']['temp'] ?? 'N/A' }}°C
                        </div>
                        <p class="text-xl text-muted-foreground mt-2">
                             Condición: {{ $results['weather']['weather'][0]['description'] ?? 'Soleado (Ejemplo)' }}
                        </p>
                        
                        <div class="mt-8">
                            <button id="save-favorite" data-location-id="{{ $results['location']->id }}" class="inline-block px-4 py-2 bg-primary text-white rounded-md">
                                Guardar como Favorito
                            </button>
                            <p id="favorite-feedback" class="mt-3 text-sm text-green-600 hidden"></p>
                        </div>
                    </div>
                @else
                    <div class="text-center text-red-600 bg-red-100 p-6 rounded-lg">
                        <h2 class="text-2xl font-semibold mb-3">Error en la Consulta</h2>
                        <p class="text-lg">
                            No se pudo obtener el clima de la API externa.
                        </p>
                    </div>
                @endif
            </div>
        @else
             {{-- Mensaje Inicial --}}
             <div class="bg-card p-10 shadow-2xl rounded-xl text-center">
                <h2 class="text-2xl font-semibold text-foreground mb-4">¡Busca tu ubicación!</h2>
                <p class="text-lg text-muted-foreground">
                    Ingresa el nombre de una ciudad arriba para consultar el clima.
                </p>
            </div>
        @endisset
    </div>
    <script>
        (function(){
            const btn = document.getElementById('save-favorite');
            if (!btn) return;
            btn.addEventListener('click', async function(e){
                e.preventDefault();
                const locationId = btn.dataset.locationId;
                const feedback = document.getElementById('favorite-feedback');
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                try {
                    const res = await fetch("{{ route('favorites.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ location_id: locationId })
                    });

                    const data = await res.json();
                    if (res.ok) {
                        feedback.textContent = data.location_name ? ('Guardado: ' + data.location_name) : 'Favorito guardado';
                        feedback.classList.remove('hidden');
                        setTimeout(()=> feedback.classList.add('hidden'), 4000);
                    } else {
                        const msg = data.message || data.error || 'Error al guardar favorito';
                        feedback.textContent = msg;
                        feedback.classList.remove('hidden');
                        feedback.classList.add('text-red-600');
                        setTimeout(()=> feedback.classList.add('hidden'), 4000);
                    }
                } catch(err){
                    feedback.textContent = 'Error de red al guardar favorito';
                    feedback.classList.remove('hidden');
                    feedback.classList.add('text-red-600');
                    setTimeout(()=> feedback.classList.add('hidden'), 4000);
                }
            });
        })();
    </script>
@endsection