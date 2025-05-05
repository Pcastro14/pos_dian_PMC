@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Registrar Cliente</h2>

    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre completo</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required value="{{ old('nombre') }}">
        </div>

        <div class="mb-3">
            <label for="tipo_documento" class="form-label">Tipo de documento</label>
            <select name="tipo_documento" id="tipo_documento" class="form-control" required>
                <option value="">Seleccione</option>
                <option value="CC" {{ old('tipo_documento') == 'CC' ? 'selected' : '' }}>Cédula</option>
                <option value="NIT" {{ old('tipo_documento') == 'NIT' ? 'selected' : '' }}>NIT</option>
                <option value="CE" {{ old('tipo_documento') == 'CE' ? 'selected' : '' }}>Cédula de extranjería</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="numero_documento" class="form-label">Número de documento</label>
            <input type="text" class="form-control" id="numero_documento" name="numero_documento" required value="{{ old('numero_documento') }}">
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}">
        </div>

        <div class="mb-3">
            <label for="correo" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo" value="{{ old('correo') }}">
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion') }}">
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
