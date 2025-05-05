<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\VentaController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EmpresaController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\Admin\MedioPagoController;
use App\Http\Controllers\Admin\ConfiguracionController;

// Ruta raíz
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Autenticación
require __DIR__.'/auth.php';

// Perfil de usuario
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Clientes y productos (requieren autenticación)
Route::middleware('auth')->group(function () {
    Route::resource('clientes', ClienteController::class);
    Route::resource('productos', ProductoController::class);
});

// Facturas
Route::middleware('auth')->group(function () {
    Route::resource('facturas', FacturaController::class);
    Route::get('/facturas/{id}/imprimir', [FacturaController::class, 'imprimir'])->name('facturas.imprimir');
    Route::get('/factura/pos/{id}', [VentaController::class, 'mostrarFacturaPos'])->name('factura.pos');
});

// Ventas
Route::middleware('auth')->group(function () {
    Route::get('/ventas/crear', [VentaController::class, 'create'])->name('ventas.create');
    Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');
});

// Usuarios del sistema (solo admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('admin/users', UserController::class)->only(['index', 'edit', 'update']);
});

// Módulo de Configuración (solo admin)
Route::prefix('configuracion')->name('configuracion.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [ConfiguracionController::class, 'index'])->name('index');
    Route::resource('empresa', EmpresaController::class)->only(['index', 'edit', 'update']);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('roles', RolController::class);
    Route::resource('medios-pago', MedioPagoController::class);
});





