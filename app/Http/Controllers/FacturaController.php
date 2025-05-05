<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Configuracion;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('facturas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    protected function generarFacturaCarta($factura)
    {
    $pdf = Pdf::loadView('facturas.carta', compact('factura'));
    return $pdf->stream('factura_carta.pdf');
    }

    protected function generarFacturaPos($factura)
    {
    $pdf = Pdf::loadView('facturas.pos', compact('factura'));
    return $pdf->stream('factura_pos.pdf');
    }

    public function imprimir($id)
    {
    $factura = Factura::with('cliente', 'detalles.producto')->findOrFail($id);

    $formato = Configuracion::where('clave', 'formato_factura')->value('valor');

    if ($formato === 'pos') {
        return $this->generarFacturaPos($factura);
    } else {
        return $this->generarFacturaCarta($factura);
    }
    }
}
