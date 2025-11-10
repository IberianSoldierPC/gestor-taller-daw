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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- ENCABEZADO Y BOTÓN DE CREAR -->
                    <div class="flex justify-between items-center mb-6 border-b pb-4">
                        <p class="text-2xl font-extrabold text-indigo-800">Listado de Herramientas</p>
                        <!-- Botón con sombra y mayor contraste para asegurar visibilidad -->
                        <a href="{{ route('tools.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out transform hover:scale-105">
    Añadir Nueva Herramienta
</a>
                    </div>

                    <!-- TABLA DE HERRAMIENTAS -->
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- Aquí irá el bucle que recorra las herramientas --}}
                            @foreach ($tools as $tool)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $tool->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $tool->location }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $tool->status === 'Operativa' ? 'green' : 'red'}}-100 text-{{ $tool->status === 'Operativa' ? 'green' : 'red'}}-800">
                                        {{ $tool->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('tools.edit', $tool->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-4 font-bold trainsition duration 150">Editar</a>
                                    <form action="{{ route('tools.destroy', $tool->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-bold transition duration-150" 
                                                onclick="return confirm('¿Estás seguro de que quieres eliminar esta herramienta?');">
                                            Borrar
                                            </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            {{-- Si no hay herramientas --}}
                            @empty($tools)
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No hay herramientas registradas.</td>
                                </tr>
                            @endempty
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
