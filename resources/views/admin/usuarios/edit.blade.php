@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">Editar Usuario</h2>

    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium">Nombre</label>
            <input type="text" name="name" value="{{ $usuario->name }}" class="w-full border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Correo Electrónico</label>
            <input type="email" name="email" value="{{ $usuario->email }}" class="w-full border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Rol</label>
            <select name="role" class="w-full border-gray-300 rounded" required>
                @foreach($roles as $rol)
                    <option value="{{ $rol->name }}" {{ $usuario->roles->first()->name == $rol->name ? 'selected' : '' }}>
                        {{ ucfirst($rol->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="text-right">
            <button class="bg-blue-600 text-white px-4 py-2 rounded shadow">Actualizar</button>
        </div>
    </form>
</div>
@endsection

