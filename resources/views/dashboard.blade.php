<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel de Control del Proyecto DIY') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- CRÍTICO: Cambio el color del título principal al acento del proyecto (Naranja/Ámbar) -->
                    <h3 class="text-3xl font-bold mb-8 text-orange-600 dark:text-amber-400">
                        {{ __('Resumen del Inventario de Herramientas') }}
                    </h3>

                    <!-- GRID DE MÉTRICAS (Ajuste de redondeo y sombra) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                        <!-- Tarjeta: Total de Herramientas -->
                        <div class="bg-blue-100 dark:bg-blue-900 p-6 rounded-2xl shadow-xl border-l-4 border-blue-500 hover:shadow-2xl transition duration-300">
                            <p class="text-sm font-semibold text-blue-700 dark:text-blue-300 uppercase tracking-wider">Total de Herramientas</p>
                            <p class="text-5xl font-extrabold text-blue-800 dark:text-blue-100 mt-2">
                                {{ $totalTools ?? 'N/A' }}
                            </p>
                            <a href="{{ route('tools.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 text-sm mt-3 block font-medium">Ver Inventario &rarr;</a>
                        </div>

                        <!-- Tarjeta: Operativas (Disponibles) -->
                        <div class="bg-green-100 dark:bg-green-900 p-6 rounded-2xl shadow-xl border-l-4 border-green-500 hover:shadow-2xl transition duration-300">
                            <p class="text-sm font-semibold text-green-700 dark:text-green-300 uppercase tracking-wider">Operativas (Disponibles)</p>
                            <p class="text-5xl font-extrabold text-green-800 dark:text-green-100 mt-2">
                                {{ $availableTools ?? 'N/A' }}
                            </p>
                            <p class="text-sm mt-3 text-green-600 dark:text-green-400 font-medium">Listas para usar o asignar.</p>
                        </div>

                        <!-- Tarjeta: Actualmente Prestadas -->
                        <div class="bg-yellow-100 dark:bg-yellow-900 p-6 rounded-2xl shadow-xl border-l-4 border-yellow-500 hover:shadow-2xl transition duration-300">
                            <p class="text-sm font-semibold text-yellow-700 dark:text-yellow-300 uppercase tracking-wider">Actualmente Prestadas</p>
                            <p class="text-5xl font-extrabold text-yellow-800 dark:text-yellow-100 mt-2">
                                {{ $loanedTools ?? 'N/A' }}
                            </p>
                            <p class="text-sm mt-3 text-yellow-600 dark:text-yellow-400 font-medium">Requieren seguimiento.</p>
                        </div>
                        
                        <!-- Tarjeta: Averiadas / Reparación -->
                        <div class="bg-red-100 dark:bg-red-900 p-6 rounded-2xl shadow-xl border-l-4 border-red-500 hover:shadow-2xl transition duration-300">
                            <p class="text-sm font-semibold text-red-700 dark:text-red-300 uppercase tracking-wider">Averiadas / Reparación</p>
                            <p class="text-5xl font-extrabold text-red-800 dark:text-red-100 mt-2">
                                {{ $brokenTools ?? 'N/A' }}
                            </p>
                            <p class="text-sm mt-3 text-red-600 dark:text-red-400 font-medium">Necesitan atención.</p>
                        </div>
                    </div>
                    
                    <hr class="my-10 border-gray-200 dark:border-gray-700">

                    <div class="mt-6">
                        <h4 class="text-2xl font-bold mb-6 text-gray-700 dark:text-gray-300">Acciones Rápidas</h4>
                        <div class="flex flex-wrap gap-4">
                            
                            <!-- CRÍTICO: Botón principal de acción en color de acento (Naranja) -->
                            <a href="{{ route('tools.create') }}" class="flex items-center bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition duration-150 transform hover:scale-[1.02]">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Añadir Herramienta
                            </a>
                            
                            <!-- Botón secundario -->
                            <a href="{{ route('tools.index') }}" class="flex items-center bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white font-bold py-3 px-6 rounded-xl shadow-lg transition duration-150 transform hover:scale-[1.02]">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                Revisar Inventario
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
