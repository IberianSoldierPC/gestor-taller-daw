<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel del taller') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-2xl p-6 sm:p-8 lg:p-10">
                    <h3 class="text-3xl font-bold mb-8 text-orange-600 dark:text-amber-400">
                        {{ __('Resumen de herramientas') }}
                    </h3>

                    <!-- GRID DE MÉTRICAS (Ajuste de redondeo y sombra) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                        <!-- Tarjeta: Total de Herramientas -->
                        <div class="bg-blue-100 dark:bg-blue-900 p-6 rounded-2xl shadow-xl border-l-4 border-blue-500 hover:shadow-2xl transition duration-300">
                            <p class="text-sm font-semibold text-blue-700 dark:text-blue-300 uppercase tracking-wider">Total de herramientas</p>
                            <p class="text-5xl font-extrabold text-blue-800 dark:text-blue-100 mt-2">
                                {{ $totalTools ?? 'N/A' }}
                            </p>
                            <a href="{{ route('tools.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 text-sm mt-3 block font-medium">Ver Inventario &rarr;</a>
                        </div>

                        <!-- Tarjeta: Herramientas disponibles -->
                        <div class="bg-green-100 dark:bg-green-900 p-6 rounded-2xl shadow-xl border-l-4 border-green-500 hover:shadow-2xl transition duration-300">
                            <p class="text-sm font-semibold text-green-700 dark:text-green-300 uppercase tracking-wider">Disponibles</p>
                            <p class="text-5xl font-extrabold text-green-800 dark:text-green-100 mt-2">
                                {{ $availableTools ?? 'N/A' }}
                            </p>
                            <p class="text-sm mt-3 text-green-600 dark:text-green-400 font-medium">Listas para usar o asignar.</p>
                            <a href="{{ route('tools.index', ['status' => 'Disponible']) }}" class="mt-2 inline-block text-green-700 dark:text-green-300 hover:underline text-sm">Ver disponibles</a>
                        </div>

                        <!-- Tarjeta: Herramientas en uso -->
                        <div class="bg-yellow-100 dark:bg-yellow-900 p-6 rounded-2xl shadow-xl border-l-4 border-yellow-500 hover:shadow-2xl transition duration-300">
                            <p class="text-sm font-semibold text-yellow-700 dark:text-yellow-300 uppercase tracking-wider">En uso</p>
                            <p class="text-5xl font-extrabold text-yellow-800 dark:text-yellow-100 mt-2">
                                {{ $inUseTools ?? 'N/A' }}
                            </p>
                            <p class="text-sm mt-3 text-yellow-600 dark:text-yellow-400 font-medium">Requieren seguimiento.</p>
                            <a href="{{ route('tools.index', ['status' => 'En uso']) }}" class="mt-2 inline-block text-yellow-700 dark:text-yellow-300 hover:underline text-sm">Ver en uso</a>
                        </div>
                        
                        <!-- Herramientas en mantenimiento -->
                        <div class="bg-red-100 dark:bg-red-900 p-6 rounded-2xl shadow-xl border-l-4 border-red-500 hover:shadow-2xl transition duration-300">
                            <p class="text-sm font-semibold text-red-700 dark:text-red-300 uppercase tracking-wider">En mantenimiento</p>
                            <p class="text-5xl font-extrabold text-red-800 dark:text-red-100 mt-2">
                                {{ $maintenanceTools ?? 'N/A' }}
                            </p>
                            <p class="text-sm mt-3 text-red-600 dark:text-red-400 font-medium">Necesitan atención.</p>
                            <a href="{{ route('tools.index', ['status' => 'Mantenimiento']) }}" class="mt-2 inline-block text-red-700 dark:text-red-300 hover:underline text-sm">Ver en mantenimiento</a>
                        </div>
                    </div>
                    
                    <hr class="my-10 border-gray-100 dark:border-gray-700/50">
                    
                    <h3 class="text-3xl font-bold mb-8 text-orange-600 dark:text-amber-400">
                        {{ __('Resumen de Proyectos') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Total de Proyectos: Azul (como Total herramientas) -->
                        <div class="bg-blue-100 dark:bg-blue-900 p-6 rounded-2xl shadow-xl border-l-4 border-blue-500 hover:shadow-2xl transition duration-300">
                            <p class="text-sm font-semibold text-blue-700 dark:text-blue-300 uppercase tracking-wider">Total de Proyectos</p>
                            <p class="text-5xl font-extrabold text-blue-800 dark:text-blue-100 mt-2">
                                {{ $totalProjects ?? 'N/A' }}
                            </p>
                            <a href="{{ route('projects.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 text-sm mt-3 block font-medium">Ver proyectos &rarr;</a>
                        </div>
                        <!-- En Proceso: Amarillo/Amber (como herramientas en uso) -->
                        <div class="bg-yellow-100 dark:bg-yellow-900 p-6 rounded-2xl shadow-xl border-l-4 border-yellow-500 hover:shadow-2xl transition duration-300">
                            <p class="text-sm font-semibold text-yellow-700 dark:text-yellow-300 uppercase tracking-wider">En Proceso</p>
                            <p class="text-5xl font-extrabold text-yellow-800 dark:text-yellow-100 mt-2">
                                {{ $inProgressProjects ?? 'N/A' }}
                            </p>
                            <a href="{{ route('projects.index', ['status' => 'En proceso']) }}" class="text-yellow-700 dark:text-yellow-300 hover:underline text-sm mt-3 block font-medium">Ver en proceso</a>
                        </div>
                        <!-- Terminados: Verde (como Disponibles) -->
                        <div class="bg-green-100 dark:bg-green-900 p-6 rounded-2xl shadow-xl border-l-4 border-green-500 hover:shadow-2xl transition duration-300">
                            <p class="text-sm font-semibold text-green-700 dark:text-green-300 uppercase tracking-wider">Terminados</p>
                            <p class="text-5xl font-extrabold text-green-800 dark:text-green-100 mt-2">
                                {{ $completedProjects ?? 'N/A' }}
                            </p>
                            <a href="{{ route('projects.index', ['status' => 'Terminado']) }}" class="text-green-700 dark:text-green-300 hover:underline text-sm mt-3 block font-medium">Ver terminados</a>
                        </div>
                        <!-- Urgentes -->
                        <div class="bg-red-100 dark:bg-red-900 p-6 rounded-2xl shadow-xl border-l-4 border-red-500 hover:shadow-2xl transition duration-300">
                            <p class="text-sm font-semibold text-red-700 dark:text-red-300 uppercase tracking-wider">Urgentes</p>
                            <p class="text-5xl font-extrabold text-red-800 dark:text-red-100 mt-2">
                                {{ $urgentProjects ?? 'N/A' }}
                            </p>
                            <a href="{{ route('projects.index', ['status' => 'Urgente']) }}" class="text-red-700 dark:text-red-300 hover:underline text-sm mt-3 block font-medium">Ver urgentes</a>
                        </div>
                    </div>

                    <div class="mt-10">
                        <h4 class="text-2xl font-bold mb-6 text-gray-700 dark:text-gray-300">Acciones rápidas</h4>
                        <div class="flex flex-wrap gap-4">
                            
                            <!-- Botón principal -->
                            <a href="{{ route('tools.create') }}" class="flex items-center bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition duration-150 transform hover:scale-[1.02]">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Añadir herramienta
                            </a>
                            
                            <!-- Botón secundario -->
                            <a href="{{ route('tools.index') }}" class="flex items-center bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white font-bold py-3 px-6 rounded-xl shadow-lg transition duration-150 transform hover:scale-[1.02]">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                Revisar inventario
                            </a>
                            <a href="{{ route('projects.index') }}" class="flex items-center bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white font-bold py-3 px-6 rounded-xl shadow-lg transition duration-150 transform hover:scale-[1.02]">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M5 11h14M7 15h10"></path></svg>
                                Ver proyectos
                            </a>
                            <a href="{{ route('projects.index', ['status' => 'En proceso']) }}" class="flex items-center bg-amber-200 hover:bg-amber-300 text-amber-900 dark:bg-amber-700 dark:hover:bg-amber-600 dark:text-white font-bold py-3 px-6 rounded-xl shadow-lg transition duration-150 transform hover:scale-[1.02]">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m-4-4h8"></path></svg>
                                Proyectos en proceso
                            </a>
                            <a href="{{ route('projects.index', ['status' => 'Terminado']) }}" class="flex items-center bg-green-200 hover:bg-green-300 text-green-900 dark:bg-green-700 dark:hover:bg-green-600 dark:text-white font-bold py-3 px-6 rounded-xl shadow-lg transition duration-150 transform hover:scale-[1.02]">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path></svg>
                                Proyectos terminados
                            </a>
                            <a href="{{ route('projects.index', ['status' => 'Urgente']) }}" class="flex items-center bg-red-200 hover:bg-red-300 text-red-900 dark:bg-red-700 dark:hover:bg-red-600 dark:text-white font-bold py-3 px-6 rounded-xl shadow-lg transition duration-150 transform hover:scale-[1.02]">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6"></path></svg>
                                Proyectos urgentes
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
