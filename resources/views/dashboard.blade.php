<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel de Control del Proyecto DIY') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-6 text-indigo-600 dark:text-indigo-400">
                        {{ __('Resumen del Inventario de Herramientas') }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                        <div class="bg-blue-100 dark:bg-blue-900 p-5 rounded-lg shadow-md border-l-4 border-blue-500">
                            <p class="text-sm font-medium text-blue-700 dark:text-blue-300 uppercase">Total de Herramientas</p>
                            <p class="text-4xl font-extrabold text-blue-800 dark:text-blue-100 mt-1">
                                {{ $totalTools ?? 'N/A' }}
                            </p>
                            <a href="{{ route('tools.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 text-xs mt-2 block">Ver Inventario</a>
                        </div>

                        <div class="bg-green-100 dark:bg-green-900 p-5 rounded-lg shadow-md border-l-4 border-green-500">
                            <p class="text-sm font-medium text-green-700 dark:text-green-300 uppercase">Operativas (Disponibles)</p>
                            <p class="text-4xl font-extrabold text-green-800 dark:text-green-100 mt-1">
                                {{ $availableTools ?? 'N/A' }}
                            </p>
                            <p class="text-xs mt-2 text-green-600 dark:text-green-400">Listas para usar o asignar.</p>
                        </div>

                        <div class="bg-yellow-100 dark:bg-yellow-900 p-5 rounded-lg shadow-md border-l-4 border-yellow-500">
                            <p class="text-sm font-medium text-yellow-700 dark:text-yellow-300 uppercase">Actualmente Prestadas</p>
                            <p class="text-4xl font-extrabold text-yellow-800 dark:text-yellow-100 mt-1">
                                {{ $loanedTools ?? 'N/A' }}
                            </p>
                            <p class="text-xs mt-2 text-yellow-600 dark:text-yellow-400">Requieren seguimiento.</p>
                        </div>
                        
                        <div class="bg-red-100 dark:bg-red-900 p-5 rounded-lg shadow-md border-l-4 border-red-500">
                            <p class="text-sm font-medium text-red-700 dark:text-red-300 uppercase">Averiadas / Reparación</p>
                            <p class="text-4xl font-extrabold text-red-800 dark:text-red-100 mt-1">
                                {{ $brokenTools ?? 'N/A' }}
                            </p>
                            <p class="text-xs mt-2 text-red-600 dark:text-red-400">Necesitan atención.</p>
                        </div>
                    </div>
                    
                    <hr class="my-8 border-gray-200 dark:border-gray-700">

                    <div class="mt-6">
                        <h4 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-300">Acciones Rápidas</h4>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('tools.create') }}" class="flex items-center bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition duration-150 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Añadir Herramienta
                            </a>
                            <a href="{{ route('tools.index') }}" class="flex items-center bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white font-bold py-3 px-6 rounded-xl shadow-lg transition duration-150 transform hover:scale-105">
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
