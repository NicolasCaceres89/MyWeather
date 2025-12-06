@extends('layouts.app')

@section('title', 'Cargando...')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-12 w-full">
        {{-- Título transparente, solo para mantener el espacio --}}
        <h1 class="text-4xl font-bold text-primary mb-8 text-center opacity-0">Búsqueda de Clima</h1>
        
        {{-- Search Bar Skeleton --}}
        <div class="mb-12">
            <div class="h-12 rounded-lg bg-muted animate-pulse" />
        </div>

        {{-- Results Grid Skeleton --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @for ($i = 0; $i < 6; $i++)
                <div class="bg-card shadow-lg rounded-lg h-full p-6">
                    <div class="space-y-4">
                        <div class="flex items-start justify-between">
                            <div class="space-y-2 flex-1">
                                <div class="h-5 bg-muted rounded w-3/4 animate-pulse" />
                                <div class="h-4 bg-muted rounded w-1/2 animate-pulse" />
                            </div>
                            <div class="h-8 w-8 bg-muted rounded animate-pulse ml-2" />
                        </div>
                        <div class="h-8 bg-muted rounded w-1/4 animate-pulse" />
                        <div class="h-3 bg-muted rounded w-1/3 animate-pulse" />
                    </div>
                </div>
            @endfor
        </div>
    </div>
@endsection