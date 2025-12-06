@extends('layouts.base')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-background to-muted flex flex-col">
  <header class="border-b border-border">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
      <div class="flex items-center gap-2">
        <svg class="w-8 h-8 text-primary" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M20 17.58A4.5 4.5 0 0 0 17.5 9h-.26A6 6 0 0 0 6 10.5C4.34 10.5 3 11.84 3 13.5S4.34 16.5 6 16.5h11a3 3 0 0 0 3-3 3 3 0 0 0-0.1-0.83" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <span class="text-2xl font-bold text-foreground">MyWeather</span>
      </div>

      <nav class="hidden md:flex items-center gap-8">
        <a href="{{ route('login') }}" class="text-foreground hover:text-primary transition">Iniciar Sesión</a>
        <a href="{{ route('register') }}" class="text-foreground hover:text-primary transition">Registrarse</a>
      </nav>

      <button class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-foreground">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>
    </div>
  </header>

  <main class="flex-1 flex items-center justify-center px-4">
    <div class="text-center max-w-2xl">
      <h1 class="text-5xl md:text-6xl font-bold text-foreground mb-6">Consulta el Clima en Tiempo Real</h1>
      <p class="text-lg text-muted-foreground mb-12">MyWeather es tu aplicación minimalista para estar siempre al tanto del clima en tus ubicaciones favoritas. Diseño limpio, información clara y acceso rápido.</p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="/search" class="px-6 py-3 bg-primary text-white rounded-md text-lg">Explorar Clima</a>
        <a href="{{ route('register') }}" class="px-6 py-3 border border-current rounded-md text-lg">Crear Cuenta</a>
      </div>
    </div>
  </main>

  <footer class="border-t border-border py-8 px-4">
    <div class="max-w-7xl mx-auto text-center text-muted-foreground text-sm">
      <p>&copy; 2025 MyWeather. Todos los derechos reservados.</p>
    </div>
  </footer>
</div>
@endsection
