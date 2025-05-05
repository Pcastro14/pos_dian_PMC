@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Configuración</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <a href="{{ route('configuracion.empresa.index') }}" class="bg-white border shadow rounded-lg p-6 hover:bg-gray-100 transition">
            <h2 class="text-lg font-semibold mb-2">Información de la Empresa</h2>
            <p class="text-sm text-gray-600">Datos básicos de la empresa.</p>
        </a>

        <a href="{{ route('configuracion.usuarios.index') }}" class="bg-white border shadow rounded-lg p-6 hover:bg-gray-100 transition">
            <h2 class="text-lg font-semibold mb-2">Usuarios</h2>
            <p class="text-sm text-gray-600">Gestión de usuarios del sistema.</p>
        </a>

        <a href="{{ route('configuracion.roles.index') }}" class="bg-white border shadow rounded-lg p-6 hover:bg-gray-100 transition">
            <h2 class="text-lg font-semibold mb-2">Roles</h2>
            <p class="text-sm text-gray-600">Permisos y roles de acceso.</p>
        </a>

        <a href="{{ route('configuracion.medios-pago.index') }}" class="bg-white border shadow rounded-lg p-6 hover:bg-gray-100 transition">
            <h2 class="text-lg font-semibold mb-2">Medios de Pago</h2>
            <p class="text-sm text-gray-600">Configuración de métodos de pago.</p>
        </a>

    </div>
</div>
@endsection

