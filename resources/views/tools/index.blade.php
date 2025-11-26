<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inventario de herramientas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Mensaje de Estado (Éxito) --}}
            @if (session('status'))
                <div class="bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded-2xl relative mb-6 shadow-md" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            {{-- ---------------------------------------------------- --}}
            {{-- BLOQUE DE TARJETAS DE ESTADÍSTICAS --}}
            {{-- ---------------------------------------------------- --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                {{-- 1. Tarjeta: Total de Herramientas (Color de acento) --}}
                <div class="bg-white dark:bg-gray-700 p-6 rounded-2xl shadow-xl border-l-4 border-orange-500 dark:border-amber-400 transition hover:shadow-2xl">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Registradas</p>
                    <p class="text-4xl font-extrabold text-gray-900 dark:text-gray-50 mt-1">
                        {{ $totalTools ?? 0 }}
                    </p>
                </div>

                {{-- 2. Tarjeta: Disponibles (Éxito) --}}
                <div class="bg-white dark:bg-gray-700 p-6 rounded-2xl shadow-xl border-l-4 border-green-500 transition hover:shadow-2xl">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Disponibles</p>
                    <p class="text-4xl font-extrabold text-gray-900 dark:text-gray-50 mt-1">
                        {{ $availableTools ?? 0 }}
                    </p>
                </div>

                {{-- 3. Tarjeta: Prestadas / En Uso (Advertencia) --}}
                <div class="bg-white dark:bg-gray-700 p-6 rounded-2xl shadow-xl border-l-4 border-yellow-500 transition hover:shadow-2xl">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">En Préstamo</p>
                    <p class="text-4xl font-extrabold text-gray-900 dark:text-gray-50 mt-1">
                        {{ $loanedTools ?? 0 }}
                    </p>
                </div>

                {{-- 4. Tarjeta: Fuera de Servicio (Crítico) --}}
                <div class="bg-white dark:bg-gray-700 p-6 rounded-2xl shadow-xl border-l-4 border-red-500 transition hover:shadow-2xl">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fuera de Servicio</p>
                    <p class="text-4xl font-extrabold text-gray-900 dark:text-gray-50 mt-1">
                        {{ $brokenTools ?? 0 }}
                    </p>
                </div>

            </div>
            {{-- ---------------------------------------------------- --}}
            {{-- FIN BLOQUE DE ESTADÍSTICAS --}}
            {{-- ---------------------------------------------------- --}}

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-6 text-gray-900 dark:text-gray-200">

                    <div class="flex justify-between items-center mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                        <!-- Título con color de acento unificado -->
                        <p class="text-2xl font-extrabold text-orange-600 dark:text-amber-400">Listado de herramientas</p>
                        <!-- Botón principal con color de acento unificado -->
                        <a href="{{ route('tools.create') }}" class="bg-orange-600 hover:bg-orange-700 dark:bg-amber-500 dark:hover:bg-amber-600 text-white font-bold py-2 px-4 rounded-xl shadow-md transition duration-150 ease-in-out transform hover:scale-105">
                            Añadir nueva herramienta
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tl-xl">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ubicación</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Asignado a</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tr-xl">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                {{-- Se utiliza un mapa de colores para evitar el problema de detección dinámica de clases en Tailwind --}}
                                @php
                                    // Incluimos las clases en un span oculto para asegurar la compilación
                                    echo '<span class="hidden bg-green-100 text-green-800 bg-red-100 text-red-800 bg-yellow-100 text-yellow-800 dark:bg-green-900 dark:text-green-300 dark:bg-red-900 dark:text-red-300 dark:bg-yellow-900 dark:text-yellow-300"></span>';

                                    $statusColors = [
                                        'Operativa' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'dark_bg' => 'dark:bg-green-900', 'dark_text' => 'dark:text-green-300'],
                                        'Averiada' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'dark_bg' => 'dark:bg-red-900', 'dark_text' => 'dark:text-red-300'],
                                        'Prestada' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'dark_bg' => 'dark:bg-yellow-900', 'dark_text' => 'dark:text-yellow-300'],
                                    ];
                                @endphp

                                @forelse ($tools as $tool)
                                    @php
                                        $color = $statusColors[$tool->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'dark_bg' => 'dark:bg-gray-700', 'dark_text' => 'dark:text-gray-300'];
                                    @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">{{ $tool->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">{{ $tool->location }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- Badge unificado: px-3 py-1 --}}
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color['bg'] }} {{ $color['text'] }} {{ $color['dark_bg'] }} {{ $color['dark_text'] }}">
                                            {{ $tool->status }}
                                        </span>
                                    </td>
                                    {{-- Muestra el nombre del usuario asignado o 'N/A' --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">{{ $tool->user->name ?? 'N/A' }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-4">
                                        <!-- Botón Editar con estilo de acento -->
                                        <a href="{{ route('tools.edit', $tool->id) }}" class="text-orange-600 dark:text-amber-400 hover:text-orange-800 dark:hover:text-amber-300 font-bold transition duration-150">Editar</a>

                                        <!-- Formulario de Borrado con confirmación simple -->
                                        <form action="{{ route('tools.destroy', $tool->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-bold transition duration-150"
                                                onclick="return confirm('¿Estás seguro de que quieres eliminar la herramienta: {{ $tool->name }}? Esta acción es irreversible.');">
                                                Borrar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 italic">No hay herramientas registradas en el inventario.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
