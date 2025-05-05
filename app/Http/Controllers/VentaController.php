<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;

use App\Models\DetalleVenta;
use App\Models\Factura;
use App\Models\DetalleFactura;
use App\Models\MetodoPago;
use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        $metodos_pago = MetodoPago::all(); // <- Medios de pago
        return view('ventas.create', compact('clientes', 'productos', 'metodos_pago'));
    }

    public function store(Request $request)
{
    // Validar los datos mínimos necesarios
    $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'productos' => 'required|array|min:1',
        'productos.*' => 'exists:productos,id',
        'cantidades' => 'required|array|min:1',
        'cantidades.*' => 'integer|min:1',
        'metodo_pago_id' => 'required|exists:metodos_pago,id',
    ]);

    DB::beginTransaction();

    try {
        // Crear la venta
        $venta = Venta::create([
            'cliente_id' => $request->cliente_id,
            'metodo_pago_id' => $request->metodo_pago_id,
            'total' => 0, // lo actualizamos más abajo
        ]);

        $totalVenta = 0;

        foreach ($request->productos as $index => $productoId) {
            $producto = Producto::findOrFail($productoId);
            $cantidad = $request->cantidades[$index];
            $subtotal = $producto->precio_venta * $cantidad;

            // Guardar detalle
            DetalleVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $producto->id,
                'cantidad' => $cantidad,
                'precio' => $producto->precio_venta,
                'subtotal' => $subtotal,
            ]);

            // Descontar del stock
            $producto->stock -= $cantidad;
            $producto->save();

            $totalVenta += $subtotal;
        }

        // Actualizar total en la venta
        $venta->total = $totalVenta;
        $venta->save();

        DB::commit();

        // ¿Imprimir?
        if ($request->imprimir == '1') {
            return redirect()->route('ventas.show', $venta->id)->with('success', 'Venta realizada e imprimida.');
        }

        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Error al registrar la venta: ' . $e->getMessage());
    }
}


    public function mostrarFacturaPos($id)
    {
    $factura = Venta::with(['detalles.producto', 'cliente', 'usuario', 'metodopago'])->findOrFail($id);

    $empresa = [
        'nombre'     => Configuracion::obtener('nombre_empresa'),
        'nit'        => Configuracion::obtener('nit_empresa'),
        'direccion'  => Configuracion::obtener('direccion_empresa'),
        'telefono'   => Configuracion::obtener('telefono_empresa'),
        'mensaje'    => Configuracion::obtener('mensaje_factura'),
    ];

    return view('facturas.pos', compact('factura', 'empresa'));
    }
 
}