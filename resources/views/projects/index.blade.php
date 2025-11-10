<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Proyectos de Taller') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- BLOQUE DE MENSAJES (Status) --}}
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6 border-b pb-4">
                        <p class="text-2xl font-extrabold text-indigo-800">Listado de Proyectos</p>
                        <a href="{{ route('projects.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out transform hover:scale-105">
                            Crear Nuevo Proyecto
                        </a>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proyecto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asignado a</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioridad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($projects as $project)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold">
                                    <a href="{{ route('projects.show', $project) }}" class="text-indigo-700 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200 underline">
                                    {{ $project->name }}</a>
                                </td>
                                
                                {{-- Usamos la relación assignedTo() para obtener el nombre del usuario --}}
                                <td class="px-6 py-4 whitespace-nowrap">{{ $project->assignedTo->name }}</td>
                                
                                {{-- Columna de ESTADO con colores --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $color = match($project->status) {
                                            'Terminado' => 'green',
                                            'En Proceso' => 'blue',
                                            'En Espera de Piezas' => 'yellow',
                                            default => 'red', // Pendiente
                                        };
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $color }}-100 text-{{ $color }}-800">
                                        {{ $project->status }}
                                    </span>
                                </td>
                                
                                {{-- Columna de PRIORIDAD --}}
                                <td class="px-6 py-4 whitespace-nowrap">{{ $project->priority }}</td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    {{-- El CRUD para proyectos irá aquí --}}
                                    <a href="{{ route('projects.edit', $project->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-4 font-bold">Editar</a>
                                    {{-- El formulario de borrar (DELETE) también irá aquí --}}
                                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline-block" 
                                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar el proyecto \'{{ $project->name }}\'? Esta acción es irreversible.');">
                                        @csrf
                                        @method('DELETE')
                                        
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold ml-2">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @empty($projects)
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay proyectos registrados para ti.</td>
                                </tr>
                            @endempty
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>