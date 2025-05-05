<nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo y enlaces -->
            <div class="flex">
                <div class="flex-shrink-0 flex items-center text-lg font-bold text-blue-600">
                    POS PMC
                </div>
                <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ route('dashboard') }}" class="flex-shrink-0 flex items-center text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                    <a href="{{ route('productos.index') }}" class="flex-shrink-0 flex items-center text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Productos</a>
                    <a href="{{ route('clientes.index') }}" class="flex-shrink-0 flex items-center text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Clientes</a>
                    <a href="{{ route('facturas.index') }}" class="flex-shrink-0 flex items-center text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Facturas</a>
                    <a href="{{ route('ventas.create') }}" class="flex-shrink-0 flex items-center text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Nueva Venta</a>
                    <!--
                    <a href="{{ route('configuracion.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Configuración</a>
                    -->
                    @role('admin')
                    <a href="{{ route('configuracion.empresa.index') }}" class="flex-shrink-0 flex items-center text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                    Configuración</a>
                    @endrole
                </div>

            </div>
            <div>
                @role('admin')
                <p class="flex-shrink-0 flex items-center text-gray-700 hover:text-black-600 px-3 py-2 rounded-md text-sm font-medium">
                    Bienvenido, Administrador</p>
                @endrole
            </div>

            <!-- Usuario y logout -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 relative">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 focus:outline-none">
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.584l3.71-4.353a.75.75 0 111.14.976l-4.25 5a.75.75 0 01-1.14 0l-4.25-5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <div class="px-4 py-2 text-sm text-gray-700 border-b">
                            Rol: {{ Auth::user()->roles->pluck('name')->join(', ') }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!--
            <pre>
                {{ dd(Auth::user()->getRoleNames()) }}
            </pre>
            -->        

        </div>
    </div>
</nav>

<!-- Alpine.js para dropdown -->
<script src="//unpkg.com/alpinejs" defer></script>
