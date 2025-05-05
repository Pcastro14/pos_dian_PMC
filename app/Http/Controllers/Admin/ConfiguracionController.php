<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuracion;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $configuraciones = Configuracion::all();
        return view('admin.configuracion.index', compact('configuraciones'));
    }

    public function edit(Configuracion $configuracion)
    {
        return view('admin.configuraciones.edit', compact('configuracion'));
    }

    public function update(Request $request, Configuracion $configuracion)
    {
    // Validación básica
    $request->validate([
        'clave' => 'required|string|max:100',
        'valor' => 'required|string|max:100',
    ]);

    // Validación adicional para clave específica
    if ($request->clave === 'formato_factura' && !in_array($request->valor, ['pos', 'carta'])) {
        return back()->withErrors(['valor' => 'El valor para formato_factura debe ser "pos" o "carta".'])->withInput();
    }
    $configuracion->update($request->only('clave', 'valor'));
    return redirect()->route('configuraciones.index')->with('success', 'Configuración actualizada correctamente.');
    }

}
