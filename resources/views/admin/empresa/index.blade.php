@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">Información de la Empresa</h2>

    <form action="{{ route('empresa.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $empresa->nombre ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">NIT</label>
            <input type="text" name="nit" value="{{ old('nit', $empresa->nit ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Dirección</label>
            <input type="text" name="direccion" value="{{ old('direccion', $empresa->direccion ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono', $empresa->telefono ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <div class="text-right">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection
