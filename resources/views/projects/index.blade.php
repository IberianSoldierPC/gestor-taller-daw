<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventario de Herramientas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            {{-- ---------------------------------------------------- --}}
            {{-- BLOQUE DE TARJETAS DE ESTADÍSTICAS --}}
            {{-- Muestra los totales calculados en el DashboardController --}}
            {{-- ---------------------------------------------------- --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                {{-- 1. Tarjeta: Total de Herramientas --}}
                <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-indigo-500">
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Registradas</p>
                    <p class="text-4xl font-extrabold text-gray-900 mt-1">
                        {{ $totalTools ?? 0 }}
                    </p>
                </div>

                {{-- 2. Tarjeta: Disponibles (Operativa) --}}
                <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500">
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Disponibles</p>
                    <p class="text-4xl font-extrabold text-gray-900 mt-1">
                        {{ $availableTools ?? 0 }}
                    </p>
                </div>

                {{-- 3. Tarjeta: Prestadas (En Uso) --}}
                <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-yellow-500">
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">En Préstamo</p>
                    <p class="text-4xl font-extrabold text-gray-900 mt-1">
                        {{ $loanedTools ?? 0 }}
                    </p>
                </div>

                {{-- 4. Tarjeta: Fuera de Servicio (Averiada, Mantenimiento) --}}
                <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-red-500">
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Fuera de Servicio</p>
                    <p class="text-4xl font-extrabold text-gray-900 mt-1">
                        {{ $brokenTools ?? 0 }}
                    </p>
                </div>

            </div>
            {{-- ---------------------------------------------------- --}}
            {{-- FIN BLOQUE DE ESTADÍSTICAS --}}
            {{-- ---------------------------------------------------- --}}
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6 border-b pb-4">
                        <p class="text-2xl font-extrabold text-indigo-800">Listado de Herramientas</p>
                        <a href="{{ route('tools.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out transform hover:scale-105">
                            Añadir Nueva Herramienta
                        </a>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asignado a</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- Se utiliza un mapa de colores para evitar el problema de detección dinámica de clases en Tailwind --}}
                            @php
                                // Se incluyen clases para asegurar su compilación en Tailwind
                                echo '<span class="hidden bg-green-100 text-green-800 bg-red-100 text-red-800 bg-yellow-100 text-yellow-800"></span>';
                                
                                // ACTUALIZADO para coincidir con los estados: 'Operativa', 'Prestada', 'Averiada'
                                $statusColors = [
                                    'Operativa' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
                                    'Prestada' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                                    'Averiada' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
                                    'Mantenimiento' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
                                    'Rota' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
                                ];
                            @endphp

                            @forelse ($tools as $tool)
                                @php
                                    $color = $statusColors[$tool->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'];
                                @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $tool->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $tool->location }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color['bg'] }} {{ $color['text'] }}">
                                        {{ $tool->status }}
                                    </span>
                                </td>
                                {{-- Muestra el nombre del usuario asignado o 'N/A' --}}
                                <td class="px-6 py-4 whitespace-nowrap">{{ $tool->user->name ?? 'N/A' }}</td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('tools.edit', $tool->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-4 font-bold trainsition duration-150">Editar</a>
                                    
                                    <form action="{{ route('tools.destroy', $tool->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold transition duration-150"
                                            onclick="return confirm('¿Estás seguro de que quieres eliminar la herramienta: {{ $tool->name }}?');">
                                            Borrar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay herramientas registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
