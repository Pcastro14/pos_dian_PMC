@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Listado de Facturas</h1>
    <!-- <p>Aquí se mostrará la lista de facturas.</p> -->
    <td>{{ $factura->metodoPago->nombre ?? 'N/A' }}</td>

</div>
@endsection
