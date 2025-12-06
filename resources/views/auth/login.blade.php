@extends('layouts.base')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-md bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Iniciar sesión</h1>

        @if(session('status'))
            <div class="mb-4 text-sm text-green-600">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Email</label>
                <input name="email" type="email" value="{{ old('email') }}" required autofocus class="w-full border rounded px-3 py-2" />
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Contraseña</label>
                <input name="password" type="password" required class="w-full border rounded px-3 py-2" />
                @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-between mb-4">
                <div>
                    <input type="checkbox" name="remember" id="remember" class="mr-1" /> <label for="remember">Recordarme</label>
                </div>
                @if($canResetPassword ?? false)
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600">¿Olvidaste tu contraseña?</a>
                @endif
            </div>

            <div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Entrar</button>
            </div>
        </form>

        <p class="text-sm mt-4">¿No tienes cuenta? <a href="{{ route('register') }}" class="text-blue-600">Regístrate</a></p>
    </div>
</div>
@endsection
