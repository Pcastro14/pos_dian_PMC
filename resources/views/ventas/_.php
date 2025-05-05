@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nueva Venta</h2>

    <form action="{{ route('ventas.store') }}" method="POST">
        @csrf

        <!-- Cliente -->
        <div class="form-group">
            <label for="cliente_id">Cliente:</label>
            <select name="cliente_id" class="form-control" required>
                <option value="">Seleccione un cliente</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Método de pago -->
        <div class="form-group">
            <label for="metodo_pago_id">Método de Pago:</label>
            <select name="metodo_pago_id" class="form-control" required>
                <option value="">Seleccione un método</option>
                @foreach ($metodos_pago as $metodo)
                    <option value="{{ $metodo->id }}">{{ $metodo->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Agregar producto -->
        <div class="form-row align-items-end">
            <div class="form-group col-md-6">
                <label for="producto_select">Producto:</label>
                <select id="producto_select" class="form-control">
                    <option value="">Seleccione un producto</option>
                    @foreach ($productos as $producto)
                        <option value="{{ $producto->id }}"
                                data-nombre="{{ $producto->nombre }}"
                                data-precio="{{ $producto->precio_venta }}">
                            {{ $producto->nombre }} - ${{ number_format($producto->precio_venta, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="cantidad_input">Cantidad:</label>
                <input type="number" id="cantidad_input" class="form-control" min="1" value="1">
            </div>
            <div class="form-group col-md-3">
                <button type="button" class="btn btn-info btn-block" onclick="agregarProducto()">Agregar</button>
            </div>
        </div>

        <!-- Tabla de productos agregados -->
        <table class="table table-bordered" id="tabla_productos">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <!-- productos añadidos dinámicamente aquí -->
            </tbody>
        </table>

        <!-- Botones -->
        <div class="mt-3">
            <button type="submit" name="imprimir" value="1" class="btn btn-primary">Guardar e Imprimir</button>
            <button type="submit" name="imprimir" value="0" class="btn btn-success">Guardar sin Imprimir</button>
        </div>
    </form>
</div>

<!-- Script para agregar dinámicamente -->
<script>
    function agregarProducto() {
        let select = document.getElementById('producto_select');
        let productoId = select.value;
        let productoNombre = select.options[select.selectedIndex].getAttribute('data-nombre');
        let precio = parseFloat(select.options[select.selectedIndex].getAttribute('data-precio'));
        let cantidad = parseInt(document.getElementById('cantidad_input').value);

        if (!productoId || cantidad <= 0) return;

        let subtotal = precio * cantidad;

        // Agregar fila
        let tabla = document.querySelector('#tabla_productos tbody');
        let row = document.createElement('tr');
        row.innerHTML = `
            <td>${productoNombre}<input type="hidden" name="productos[]" value="${productoId}"></td>
            <td>$${precio}</td>
            <td><input type="number" name="cantidades[]" class="form-control" value="${cantidad}" min="1" required></td>
            <td>$${subtotal.toFixed(2)}</td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">Eliminar</button></td>
        `;
        tabla.appendChild(row);

        // Limpiar selección
        select.value = '';
        document.getElementById('cantidad_input').value = 1;
    }
</script>
@endsection
