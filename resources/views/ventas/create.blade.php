@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Nueva Venta</h1>

    <form action="{{ route('ventas.store') }}" method="POST" id="ventaForm">
        @csrf

        {{-- Cliente --}}
        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700">Cliente</label>
            <select name="cliente_id" class="w-full border-gray-300 rounded-md shadow-sm">
                <option value="">Seleccione un cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>

        {{-- Buscar Producto --}}
        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700">Buscar producto</label>
            <input type="text" id="buscarProducto" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Nombre o código del producto">
        </div>

        {{-- Tabla de productos seleccionados --}}
        <div class="mb-4">
            <table class="w-full text-left border border-gray-300" id="tablaProductos">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2">Producto</th>
                        <th class="p-2">Precio</th>
                        <th class="p-2">Cantidad</th>
                        <th class="p-2">Subtotal</th>
                        <th class="p-2">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Productos agregados dinámicamente -->
                </tbody>
            </table>
        </div>
        
        <!-- Tipo de pago - select -->
        <div class="mb-4">
            <!--<label class="block font-medium text-sm text-gray-700">Medio de Pago</label>
            <select name="tipo_pago" class="w-full border-gray-300 rounded-md shadow-sm">
                    @foreach($metodos_pago as $metodo)
                    <option value="{{ $metodo->id }}">{{ $metodo->nombre }}</option>
                    @endforeach
            </select> -->
            {{-- Este select ahora está oculto y se llenará desde el modal --}}
            <input type="hidden" name="metodo_pago_id" id="inputMetodoPago">

        </div>


        {{-- Total --}}
        <div class="mb-4 text-right text-xl font-semibold">
            Total: $<span id="totalVenta">0</span>
        </div>

        {{-- Botón de Guardar --}}
        <div class="text-right">
            <button type="button" onclick="abrirModal()" class="bg-blue-500 hover:bg-blue-600 text-black px-6 py-2 rounded shadow">
                Realizar Venta
            </button>
        </div>

        <input type="hidden" name="imprimir" id="imprimir" value="1">

    </form>
</div>

{{-- Scripts --}}
<script>
    
    let productos = @json($productos);
    let total = 0;

    const inputBuscar = document.getElementById('buscarProducto');

    inputBuscar.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            buscarYAgregarProducto(this.value.trim().toLowerCase());
        }
    });

    function buscarYAgregarProducto(query) {
        const producto = productos.find(p => 
            p.nombre.toLowerCase().includes(query) || 
            (p.codigo && p.codigo.toLowerCase() === query)
        );
        if (producto) {
            agregarProducto(producto);
            inputBuscar.value = '';         // Limpiar campo
            inputBuscar.focus();            // Devolver foco al input
        } else {
            alert('Producto no encontrado');
            inputBuscar.select();           // Seleccionar contenido para reescribir fácil
        }
    }

    function agregarProducto(producto) {
        const filaExistente = document.getElementById(`producto-${producto.id}`);

        if (filaExistente) {
            const cantidadInput = filaExistente.querySelector('.cantidad');
            cantidadInput.value = parseInt(cantidadInput.value) + 1;
            actualizarTotales();
            return;
        }

        const tbody = document.querySelector('#tablaProductos tbody');
        const fila = document.createElement('tr');
        fila.id = `producto-${producto.id}`;

        fila.innerHTML = `
            <td class="p-2">${producto.nombre}<input type="hidden" name="productos[]" value="${producto.id}"></td>
            <td class="p-2">$${producto.precio_venta}</td>
            <td class="p-2"><input type="number" name="cantidades[]" value="1" min="1" class="w-16 cantidad" data-precio="${producto.precio_venta}"></td>
            <td class="p-2 subtotal">$${producto.precio_venta}</td>
            <td class="p-2"><button type="button" onclick="eliminarProducto(${producto.id})" class="text-red-500">✖</button></td>
        `;

        tbody.appendChild(fila);
        actualizarTotales();
    }

    function eliminarProducto(id) {
        const fila = document.getElementById(`producto-${id}`);
        fila.remove();
        actualizarTotales();
    }

    function actualizarTotales() {
        let total = 0;
        document.querySelectorAll('.cantidad').forEach(input => {
            const cantidad = parseInt(input.value);
            const precio = parseFloat(input.dataset.precio);
            const subtotal = cantidad * precio;
            input.closest('tr').querySelector('.subtotal').textContent = '$' + subtotal.toLocaleString();
            total += subtotal;
        });
        document.getElementById('totalVenta').textContent = total.toLocaleString();
    }

    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('cantidad')) actualizarTotales();
    });


</script>


<!-- Modal para dinero recibido y vuelto -->
<div id="modalPago" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="bg-white rounded shadow-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Pago</h2>
        
        <!-- Medio de pago -->
        <div class="mb-4">
          <label for="metodo_pago_id" class="block font-medium text-sm text-gray-700">Método de Pago</label>
          <select name="metodo_pago_id" id="metodo_pago_id" required class="w-full border-gray-300 rounded-md shadow-sm">
                 <option value="">Seleccione</option>
                  @foreach($metodos_pago as $metodo)
                 <option value="{{ $metodo->id }}">{{ $metodo->nombre }}</option>
                  @endforeach
          </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Total a pagar:</label>
            <div id="modalTotal" class="text-lg font-semibold">$0</div>
        </div>
        <div class="mb-4">
            <label for="dineroRecibido" class="block text-sm font-medium">Dinero recibido:</label>
            <input type="number" id="dineroRecibido" class="w-full border-gray-300 rounded shadow-sm" min="0">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium">Vuelto:</label>
            <div id="vuelto" class="text-lg font-semibold">$0</div>
        </div>
        <div class="flex justify-end gap-4 mt-6">
            <button type="button" onclick="guardarSinImprimir()" class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded shadow">
                 Solo Guardar
            </button>
            <button type="button" onclick="confirmarVenta()" class="bg-green-600 hover:bg-green-700 text-black px-4 py-2 rounded shadow">
                Guardar e Imprimir
            </button>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('modalPago');
    const totalVentaSpan = document.getElementById('totalVenta');
    const modalTotal = document.getElementById('modalTotal');
    const inputDinero = document.getElementById('dineroRecibido');
    const vueltoDiv = document.getElementById('vuelto');
    const formulario = document.getElementById('ventaForm');

    // Abrir modal con F12
    document.addEventListener('keydown', function(e) {
        if (e.key === 'F12') {
            e.preventDefault();
            abrirModal();
        }
    });

    function abrirModal() {
        const total = obtenerTotalVenta();
        modalTotal.textContent = '$' + total.toLocaleString();
        inputDinero.value = '';
        vueltoDiv.textContent = '$0';
        modal.classList.remove('hidden');
        inputDinero.focus();
    }

    function cerrarModal() {
        modal.classList.add('hidden');
    }

    function confirmarVenta() {
        const total = obtenerTotalVenta();
        const recibido = parseFloat(inputDinero.value || 0);

        if (recibido < total) {
            alert('El dinero recibido no cubre el total.');
            return;
        }

        const vuelto = recibido - total;
        vueltoDiv.textContent = '$' + vuelto.toLocaleString();
        cerrarModal();
        document.getElementById('inputMetodoPago').value = document.getElementById('metodo_pago_id').value;
        formulario.submit(); // Enviar la venta
        document.getElementById('imprimir').value = '1'; // Sí imprimir

    }

    function obtenerTotalVenta() {
        return parseFloat(totalVentaSpan.textContent.replace(/\./g, '').replace(',', '.')) || 0;
    }

    inputDinero.addEventListener('input', function() {
        const total = obtenerTotalVenta();
        const recibido = parseFloat(this.value || 0);
        const vuelto = recibido - total;
        vueltoDiv.textContent = '$' + (vuelto >= 0 ? vuelto.toLocaleString() : '0');
    });

    function guardarSinImprimir() {
    const total = obtenerTotalVenta();
    const recibido = parseFloat(inputDinero.value || 0);

    if (recibido < total) {
        alert('El dinero recibido no cubre el total.');
        return;
    }

    document.getElementById('imprimir').value = '0'; // No imprimir
    cerrarModal();
    formulario.submit();
    }

</script>


@endsection
