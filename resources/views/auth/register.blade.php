@extends('layouts.base')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-md bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Crear cuenta</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Nombre</label>
                <input name="name" type="text" value="{{ old('name') }}" required class="w-full border rounded px-3 py-2" />
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Email</label>
                <input name="email" type="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2" />
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Contraseña</label>
                <input name="password" type="password" required class="w-full border rounded px-3 py-2" />
                @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Confirmar contraseña</label>
                <input name="password_confirmation" type="password" required class="w-full border rounded px-3 py-2" />
            </div>

            <div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Crear cuenta</button>
            </div>
        </form>

        <p class="text-sm mt-4">¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-blue-600">Iniciar sesión</a></p>
    </div>
</div>
@endsection
