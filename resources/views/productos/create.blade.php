@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Registrar nuevo producto</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="text" class="form-control" id="codigo" name="codigo" required value="{{ old('codigo') }}">
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del producto</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required value="{{ old('nombre') }}">
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion">{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="precio_compra" class="form-label">Precio de compra</label>
            <input type="number" class="form-control" id="precio_compra" name="precio_compra" required step="0.01" value="{{ old('precio_compra') }}">
        </div>

        <div class="mb-3">
            <label for="precio_venta" class="form-label">Precio de venta</label>
            <input type="number" class="form-control" id="precio_venta" name="precio_venta" required step="0.01" value="{{ old('precio_venta') }}">
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" required value="{{ old('stock', 0) }}">
        </div>

        <div class="mb-3">
            <label for="unidad" class="form-label">Unidad de medida</label>
            <input type="text" class="form-control" id="unidad" name="unidad" value="{{ old('unidad', 'unidad') }}">
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
