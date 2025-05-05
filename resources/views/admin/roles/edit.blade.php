@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">Editar Rol</h2>

    <form action="{{ route('roles.update', $rol->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium">Nombre del Rol</label>
            <input type="text" name="name" value="{{ $rol->name }}" class="w-full border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Permisos</label>
            @foreach($permisos as $permiso)
                <div class="flex items-center">
                    <input type="checkbox" name="permisos[]" value="{{ $permiso->id }}"
                           {{ $rol->permissions->contains($permiso->id) ? 'checked' : '' }} class="mr-2">
                    <label>{{ ucfirst($permiso->name) }}</label>
                </div>
            @endforeach
        </div>

        <div class="text-right">
            <button class="bg-blue-600 text-white px-4 py-2 rounded shadow">Actualizar</button>
        </div>
    </form>
</div>
@endsection
