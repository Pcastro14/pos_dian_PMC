<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    
    public function index()
    {
        
        $productos = Producto::count();
        $clientes = Cliente::count();
        $facturas = Factura::count();
        $ventas = Factura::sum('total');
    
        // Ventas mensuales
        $ventasMensuales = Factura::selectRaw('MONTH(created_at) as mes, SUM(total) as total')
        ->groupBy('mes')
        ->orderBy('mes')
        ->pluck('total', 'mes');

        // Ultimas facturas
        $ultimasFacturas = Factura::with('cliente')->latest()->take(5)->get();

        // Stock bajo
        $productosBajoStock = Producto::where('stock', '<=', 5)->get();
    
        return view('dashboard', compact('productos', 'clientes', 'facturas', 'ventas', 'ventasMensuales', 'ultimasFacturas',
        'productosBajoStock'));
        
 
    }
}