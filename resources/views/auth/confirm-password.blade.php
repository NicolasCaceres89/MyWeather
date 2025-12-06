@extends('layouts.base')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-md bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Confirmar contraseña</h1>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Contraseña</label>
                <input name="password" type="password" required class="w-full border rounded px-3 py-2" />
                @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Confirmar</button>
            </div>
        </form>

    </div>
</div>
@endsection
