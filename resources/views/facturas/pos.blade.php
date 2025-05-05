<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura POS</title>
    <style>
        body {
            font-family: monospace;
            font-size: 12px;
            width: 72mm;
            margin: 0 auto;
        }
        .centrado {
            text-align: center;
        }
        .separador {
            border-top: 1px dashed black;
            margin: 5px 0;
        }
        table {
            width: 100%;
        }
        .totales td {
            padding-top: 4px;
        }
        @media print {
        .btn {
            display: none !important;
        }
        }
    </style>
</head>
<body>

    {{-- Información del Comercio --}}
    <div class="centrado">
        <strong>{{ $empresa->nombre ?? 'Nombre del Comercio' }}</strong><br>
        NIT: {{ $empresa->nit ?? '123456789' }}<br>
        {{ $empresa->direccion ?? 'Dirección del comercio' }}<br>
        {{ $empresa->telefono ?? 'Teléfono' }}<br>
        <div class="separador"></div>
    </div>

    {{-- Datos de la Factura --}}
    <div>
        Factura: {{ $factura->id ?? '0001' }}<br>
        Fecha: {{ \Carbon\Carbon::parse($factura->fecha)->format('Y-m-d H:i') ?? now() }}<br>
        Usuario: {{ $factura->usuario->name ?? 'Cajero' }}<br>
        Rango: {{ $factura->rango ?? 'Prefijo - Rango' }}<br>
        <div class="separador"></div>
    </div>

    {{-- Cliente --}}
    <div>
        Cliente: {{ $factura->cliente->nombre ?? 'Consumidor final' }}<br>
        CC/NIT: {{ $factura->cliente->identificacion ?? '0000000000' }}<br>
        <div class="separador"></div>
    </div>

    {{-- Detalle de productos --}}
    <table>
        @foreach($factura->detalles as $detalle)
            <tr>
                <td colspan="2">{{ $detalle->producto->nombre }}</td>
            </tr>
            <tr>
                <td>{{ $detalle->cantidad }} x ${{ number_format($detalle->precio_unitario, 0, ',', '.') }}</td>
                <td style="text-align: right">${{ number_format($detalle->subtotal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>

    <div class="separador"></div>

    {{-- Impuestos --}}
    <table class="totales">
        @foreach($factura->impuestos ?? [] as $nombre => $valor)
            <tr>
                <td>{{ strtoupper($nombre) }}</td>
                <td style="text-align: right">${{ number_format($valor, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr>
            <td><strong>Total:</strong></td>
            <td style="text-align: right"><strong>${{ number_format($factura->total, 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    <div class="separador"></div>

    {{-- Método y Medio de pago --}}
    <div>
        Medio de pago: {{ $factura->medioPago->nombre ?? 'Efectivo' }}<br>
        Método: {{ $factura->metodoPago->nombre ?? 'Contado' }}<br>
    </div>

    <div class="separador"></div>

    {{-- Mensaje final --}}
    <div class="centrado">
        {{ $empresa->mensaje ?? 'Gracias por su compra' }}
    </div>

    <div class="separador"></div>

    {{-- CUFE (solo si es factura electrónica) --}}
    @if(!empty($factura->cufe))
    <div style="word-wrap: break-word;">
        <strong>CUFE:</strong><br>
        {{ $factura->cufe }}
    </div>
    @endif

    <!-- Imprimir o salir -->
    <div class="text-center mt-3">
    <button onclick="window.print();" class="btn btn-primary">Imprimir</button>
    <a href="{{ route('ventas.create') }}" class="btn btn-secondary">Nueva Venta</a>
    </div>


</body>
</html>
