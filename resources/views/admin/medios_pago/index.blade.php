@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Métodos de Pago</h1>

    <div class="mb-4 text-right">
        <a href="{{ route('metodos-pago.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
            Nuevo Método de Pago
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 text-green-600">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($metodosPago as $metodo)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $metodo->id }}</td>
                        <td class="px-4 py-2">{{ $metodo->nombre }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('metodos-pago.edit', $metodo) }}" class="text-blue-600 hover:underline">Editar</a>

                            <form action="{{ route('metodos-pago.destroy', $metodo) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('¿Estás seguro de eliminar este método?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-4 text-center text-gray-500">No hay métodos de pago registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
