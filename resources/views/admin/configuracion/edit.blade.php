@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Editar Configuración</h1>

    <form action="{{ route('configuraciones.update', $configuracion) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium">Clave</label>
            <input type="text" value="{{ $configuracion->clave }}" disabled class="w-full border-gray-300 rounded shadow-sm bg-gray-100">
        </div>

        <div class="mb-4">
        <label class="block font-medium">Valor</label>
           @if ($configuracion->clave === 'formato_factura')
           <select name="valor" class="w-full border-gray-300 rounded shadow-sm" required>
            <option value="pos" {{ $configuracion->valor === 'pos' ? 'selected' : '' }}>80 mm (POS)</option>
            <option value="carta" {{ $configuracion->valor === 'carta' ? 'selected' : '' }}>Carta</option>
           </select>
           @else
           <input type="text" name="valor" value="{{ $configuracion->valor }}" class="w-full border-gray-300 rounded shadow-sm" required>
           @endif
        </div>


        <div class="text-right">
            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">Guardar</button>
        </div>
    </form>
</div>
@endsection
