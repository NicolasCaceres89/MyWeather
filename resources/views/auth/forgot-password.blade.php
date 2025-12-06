@extends('layouts.base')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-md bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Recuperar contraseña</h1>

        @if(session('status'))
            <div class="mb-4 text-sm text-green-600">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Email</label>
                <input name="email" type="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2" />
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Enviar enlace de recuperación</button>
            </div>
        </form>

        <p class="text-sm mt-4">¿Recordaste tu contraseña? <a href="{{ route('login') }}" class="text-blue-600">Iniciar sesión</a></p>
    </div>
</div>
@endsection
