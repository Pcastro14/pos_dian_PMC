@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Cliente</h2>

    <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre completo</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required value="{{ old('nombre', $cliente->nombre) }}">
        </div>

        <div class="mb-3">
            <label for="tipo_documento" class="form-label">Tipo de documento</label>
            <select name="tipo_documento" id="tipo_documento" class="form-control" required>
                <option value="CC" {{ $cliente->tipo_documento == 'CC' ? 'selected' : '' }}>Cédula</option>
                <option value="NIT" {{ $cliente->tipo_documento == 'NIT' ? 'selected' : '' }}>NIT</option>
                <option value="CE" {{ $cliente->tipo_documento == 'CE' ? 'selected' : '' }}>Cédula de extranjería</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="numero_documento" class="form-label">Número de documento</label>
            <input type="text" class="form-control" id="numero_documento" name="numero_documento" required value="{{ old('numero_documento', $cliente->numero_documento) }}">
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', $cliente->telefono) }}">
        </div>

        <div class="mb-3">
            <label for="correo" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo" value="{{ old('correo', $cliente->correo) }}">
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion', $cliente->direccion) }}">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
