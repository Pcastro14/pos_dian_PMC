@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">Usuarios</h2>

    <a href="{{ route('usuarios.create') }}" class="bg-green-600 text-white px-4 py-2 rounded shadow mb-4 inline-block">
        Nuevo Usuario
    </a>

    <table class="w-full border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Nombre</th>
                <th class="p-2 text-left">Correo</th>
                <th class="p-2 text-left">Rol</th>
                <th class="p-2 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td class="p-2">{{ $usuario->name }}</td>
                    <td class="p-2">{{ $usuario->email }}</td>
                    <td class="p-2">{{ $usuario->roles->pluck('name')->first() }}</td>
                    <td class="p-2 space-x-2">
                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="text-blue-500">Editar</a>
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

