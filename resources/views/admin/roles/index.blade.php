@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">Roles</h2>

    <a href="{{ route('roles.create') }}" class="bg-green-600 text-white px-4 py-2 rounded shadow mb-4 inline-block">
        Nuevo Rol
    </a>

    <table class="w-full border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Nombre</th>
                <th class="p-2 text-left">Permisos</th>
                <th class="p-2 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $rol)
                <tr>
                    <td class="p-2">{{ $rol->name }}</td>
                    <td class="p-2">
                        {{ implode(', ', $rol->permissions->pluck('name')->toArray()) }}
                    </td>
                    <td class="p-2 space-x-2">
                        <a href="{{ route('roles.edit', $rol->id) }}" class="text-blue-500">Editar</a>
                        <form action="{{ route('roles.destroy', $rol->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600" onclick="return confirm('¿Eliminar este rol?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
