@extends('layouts.app')


@section('content')
    <!--- Tarjetas de resumen --->
    <div class="py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="overflow-x-auto">
            <div class="grid grid-flow-col auto-cols-[minmax(200px,_1fr)] md:grid-cols-4 gap-6">

                <!-- Productos -->
                <a href="{{ route('productos.index') }}" class="bg-white shadow-sm rounded-lg p-6 min-w-[200px] flex items-center gap-4 hover:bg-blue-50 transition">
                    <div class="text-blue-500">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M3 3h18v18H3V3z" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-gray-500">Productos</div>
                        <div class="text-2xl font-bold">{{ $productos }}</div>
                    </div>
                </a>

                <!-- Clientes -->
                <a href="{{ route('clientes.index') }}" class="bg-white shadow-sm rounded-lg p-6 min-w-[200px] flex items-center gap-4 hover:bg-green-50 transition">
                    <div class="text-green-500">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M17 20h5v-1a4 4 0 0 0-4-4h-1m-6 0h-1a4 4 0 0 0-4 4v1h5m-3-6a4 4 0 1 1 8 0 4 4 0 0 1-8 0z" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-gray-500">Clientes</div>
                        <div class="text-2xl font-bold">{{ $clientes }}</div>
                    </div>
                </a>

                <!-- Facturas -->
                <a href="{{ route('facturas.index') }}" class="bg-white shadow-sm rounded-lg p-6 min-w-[200px] flex items-center gap-4 hover:bg-yellow-50 transition">
                    <div class="text-yellow-500">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M9 12h6m2 9H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h6l5 5v13a2 2 0 0 1-2 2z" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-gray-500">Facturas</div>
                        <div class="text-2xl font-bold">{{ $facturas }}</div>
                    </div>
                </a>

                <!-- Ventas -->
                <a href="{{ route('ventas.create') }}" class="bg-white shadow-sm rounded-lg p-6 min-w-[200px] flex items-center gap-4 hover:bg-purple-50 transition">
                    <div class="text-purple-500">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-gray-500">Ventas</div>
                        <div class="text-2xl font-bold">${{ number_format($ventas, 0, ',', '.') }}</div>
                    </div>
                </a>

            </div>
        </div>
    </div>
</div>



    <!--- Botones --->
    <div class="grid grid-cols-3 gap-4">
        <a href="{{ route('productos.index') }}" class="bg-blue-500 text-black p-4 rounded shadow hover:bg-blue-600 transition">
            🛒 Gestionar Productos
        </a>
        <a href="{{ route('clientes.index') }}" class="bg-green-500 text-black p-4 rounded shadow hover:bg-green-600 transition">
            👥 Gestionar Clientes
        </a>
        <a href="{{ route('facturas.index') }}" class="bg-yellow-500 text-black p-4 rounded shadow hover:bg-yellow-600 transition">
            📄 Ver Facturas
        </a>
    </div>

    <!--- Grafica ventas mensuales --->
    <div class="bg-white mt-10 p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-4">Ventas mensuales</h3>
        <canvas id="ventasChart" height="100"></canvas>
    </div>

    <!--
    <script type="module">
        import Chart from 'chart.js/auto';

        const ctx = document.getElementById('ventasChart').getContext('2d');
        const ventasChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_values(['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'])) !!},
                datasets: [{
                    label: 'Ventas $',
                    data: {!! json_encode(array_values($ventasMensuales->toArray())) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    </script>
    -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ventasData = @json(array_values($ventasMensuales->toArray()));
            if (typeof renderVentasChart === 'function') {
                renderVentasChart(ventasData);
            }
        });
    </script>
    
    

    <div class="bg-white mt-10 p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-4">Últimas facturas</h3>
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2">#</th>
                    <th class="p-2">Cliente</th>
                    <th class="p-2">Total</th>
                    <th class="p-2">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ultimasFacturas as $factura)
                    <tr class="border-t">
                        <td class="p-2">{{ $factura->id }}</td>
                        <td class="p-2">{{ $factura->cliente->nombre }}</td>
                        <td class="p-2">${{ number_format($factura->total, 0, ',', '.') }}</td>
                        <td class="p-2">{{ $factura->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-2 text-center text-gray-500">No hay facturas registradas aún.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($productosBajoStock->count())
        <div class="bg-red-100 mt-10 p-6 rounded-lg shadow-md border border-red-300">
            <h3 class="text-xl font-semibold text-red-700 mb-4">⚠️ Productos con bajo stock</h3>
            <ul class="list-disc pl-5 text-red-800">
                @foreach($productosBajoStock as $producto)
                    <li>
                        {{ $producto->nombre }} — Stock actual: <strong>{{ $producto->stock }}</strong>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
