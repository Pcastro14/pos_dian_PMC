@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Productos en Inventario</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">Registrar nuevo producto</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Precio Compra</th>
                <th>Precio Venta</th>
                <th>Stock</th>
                <th>Unidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->codigo }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>${{ number_format($producto->precio_compra, 0, ',', '.') }}</td>
                    <td>${{ number_format($producto->precio_venta, 0, ',', '.') }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>{{ $producto->unidad }}</td>
                    <td>
                        <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que desea eliminar este producto?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @if ($productos->isEmpty())
                <tr>
                    <td colspan="7" class="text-center">No hay productos registrados.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
