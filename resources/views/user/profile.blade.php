@extends('layouts.app')

@section('title', 'Perfil de Usuario')

@section('content')
    <main class="max-w-3xl mx-auto px-4 py-12 w-full">
        <h1 class="text-3xl font-bold text-foreground mb-6">Mi Perfil</h1>

        <div class="space-y-6">
            {{-- Card de Información Personal --}}
            <div class="bg-card p-6 shadow-lg rounded-lg border border-border">
                <h2 class="text-xl font-semibold text-foreground mb-4">Información Personal</h2>
                
                <div class="space-y-4">
                    {{-- Campo Nombre --}}
                    <div>
                        <label class="block text-sm font-medium text-muted-foreground mb-1">Nombre</label>
                        <p class="text-foreground text-lg">{{ Auth::user()->name ?? 'N/A' }}</p>
                    </div>

                    {{-- Campo Email --}}
                    <div>
                        <label class="block text-sm font-medium text-muted-foreground mb-1">Email</label>
                        <p class="text-foreground text-lg">{{ Auth::user()->email ?? 'N/A' }}</p>
                    </div>
                    
                    <button class="w-full px-4 py-2 bg-primary text-white rounded-md mt-4">
                        Editar Perfil
                    </button>
                </div>
            </div>

            {{-- Card de Zona de Peligro (Basado en el page.tsx) --}}
            <div class="bg-card p-6 shadow-lg rounded-lg border border-destructive/50">
                <h2 class="text-xl font-semibold text-destructive mb-4">Zona de Peligro</h2>
                <button class="w-full px-4 py-2 bg-destructive text-white rounded-md">
                    Eliminar Cuenta
                </button>
            </div>
        </div>
    </main>
@endsection