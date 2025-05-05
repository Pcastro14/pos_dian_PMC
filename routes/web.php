<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ConfiguracionController;
use App\Http\Controllers\Admin\EmpresaController;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\Admin\MedioPagoController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
//->middleware(['auth', 'verified'])

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::middleware(['auth'])->group(function () {
    Route::resource('clientes', ClienteController::class);
});


Route::resource('productos', ProductoController::class)->middleware('auth');

// Ruta con resource
Route::resource('facturas', FacturaController::class);

// Ruta Protegida Usuarios-Roles
Route::middleware(['role:admin'])->group(function () {
    Route::resource('usuarios', UsuarioController::class);
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class)->only(['index', 'edit', 'update']);
});

Route::middleware(['auth'])->prefix('admin/configuracion')->name('configuracion.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\ConfiguracionController::class, 'index'])->name('index');

    Route::resource('empresa', App\Http\Controllers\Admin\EmpresaController::class);
    Route::resource('usuarios', App\Http\Controllers\Admin\UsuarioController::class);
    Route::resource('roles', App\Http\Controllers\Admin\RolController::class);
    Route::resource('medios-pago', App\Http\Controllers\Admin\MedioPagoController::class);
});


Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::resource('medios-pago', \App\Http\Controllers\Admin\MedioPagoController::class);
});


// Ruta ventas
Route::middleware(['auth'])->group(function () {
    Route::get('/ventas/crear', [VentaController::class, 'create'])->name('ventas.create');
    Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');
});

Route::get('/facturas/{id}/imprimir', [FacturaController::class, 'imprimir'])->name('facturas.imprimir');


Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('metodos-pago', App\Http\Controllers\Admin\MetodoPagoController::class);
});

Route::resource('admin/configuraciones', \App\Http\Controllers\Admin\ConfiguracionController::class);

Route::get('/factura/pos/{id}', [VentaController::class, 'mostrarFacturaPos'])->name('factura.pos');

// Rutas para el módulo de configuración
Route::prefix('configuracion')->name('configuracion.')->middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('empresa', EmpresaController::class)->only(['index', 'edit', 'update']);
    
    Route::resource('usuarios', UsuarioController::class);
    
    Route::resource('roles', RolController::class);
    
    Route::resource('medios-pago', MedioPagoController::class);
});




