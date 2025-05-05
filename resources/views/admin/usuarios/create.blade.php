@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">Nuevo Usuario</h2>

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-medium">Nombre</label>
            <input type="text" name="name" class="w-full border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Correo Electrónico</label>
            <input type="email" name="email" class="w-full border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Contraseña</label>
            <input type="password" name="password" class="w-full border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Rol</label>
            <select name="role" class="w-full border-gray-300 rounded" required>
                @foreach($roles as $rol)
                    <option value="{{ $rol->name }}">{{ ucfirst($rol->name) }}</option>
                @endforeach
            </select>
        </div>

        <div class="text-right">
            <button class="bg-blue-600 text-white px-4 py-2 rounded shadow">Guardar</button>
        </div>
    </form>
</div>
@endsection
