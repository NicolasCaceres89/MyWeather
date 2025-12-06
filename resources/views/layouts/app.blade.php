<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Utiliza @yield('title') para que cada vista hija defina su título --}}
    <title>@yield('title', config('app.name', 'MyWeather'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gradient-to-br from-background to-muted flex flex-col">
        
        {{-- =================================== --}}
        {{-- HEADER (Barra de Navegación)        --}}
        {{-- =================================== --}}
        <header class="border-b border-border">
            <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
                {{-- Logo --}}
                <div class="flex items-center gap-2">
                    {{-- Cloud icon SVG --}}
                    <svg class="w-8 h-8 text-primary" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 17.58A4.5 4.5 0 0 0 17.5 9h-.26A6 6 0 0 0 6 10.5C4.34 10.5 3 11.84 3 13.5S4.34 16.5 6 16.5h11a3 3 0 0 0 3-3 3 3 0 0 0-0.1-0.83" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
                    </svg>
                    <span class="text-2xl font-bold text-foreground">MyWeather</span>
                </div>

                {{-- Navegación --}}
                <nav class="hidden md:flex items-center gap-8">
                    @guest
                        <a href="{{ route('login') }}" class="text-foreground hover:text-primary transition">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="text-foreground hover:text-primary transition">Registrarse</a>
                    @else
                        {{-- Rutas de Usuario Autenticado --}}
                        <a href="{{ route('dashboard') }}" class="text-foreground hover:text-primary transition">Dashboard</a>
                        <a href="{{ route('weather.search') }}" class="text-foreground hover:text-primary transition">Buscar Clima</a>
                        <a href="{{ route('profile.edit') }}" class="text-foreground hover:text-primary transition">Perfil</a>
                        
                        {{-- Formulario para cerrar sesión (siempre se usa POST) --}}
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-foreground hover:text-primary transition">Cerrar Sesión</button>
                        </form>
                    @endguest
                </nav>
                
                {{-- Icono de Menú para Móviles (No funcional, solo estético) --}}
                <button class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-foreground">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
                    </svg>
                </button>
            </div>
        </header>

        {{-- ================================= --}}
        {{-- CONTENIDO DINÁMICO (@yield)       --}}
        {{-- ================================= --}}
        {{-- Las vistas hijas inyectan su contenido aquí --}}
        <main class="flex-1 flex items-center justify-center px-4">
            @yield('content')
        </main>

        {{-- ================================= --}}
        {{-- FOOTER                            --}}
        {{-- ================================= --}}
        <footer class="border-t border-border py-8 px-4 mt-auto">
            <div class="max-w-7xl mx-auto text-center text-muted-foreground text-sm">
                <p>&copy; 2025 MyWeather. Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>
</body>
</html>