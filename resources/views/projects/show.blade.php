<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles del Proyecto') }}: {{ $project->name }}
        </h2>
    </x-slot>

    {{-- Lógica Blade para Badges de Estado y Prioridad --}}
    @php
        // Definición de clases para el estado
        $statusClasses = [
            'Pendiente' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            'En Curso' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            'Completado' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'Cancelado' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
        ];
        $currentStatusClass = $statusClasses[$project->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';

        // Definición de clases para la prioridad
        $priorityClasses = [
            'Baja' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'Media' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            'Alta' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300',
            'Urgente' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 ring-red-500 animate-pulse',
        ];
        $currentPriorityClass = $priorityClasses[$project->priority] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
    @endphp

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100 border-b pb-2">Información principal</h3>
                
                {{-- Contenedor de detalles --}}
                <div class="space-y-4 text-gray-700 dark:text-gray-300">
                    
                    {{-- Nombre --}}
                    <div>
                        <p class="text-sm font-semibold uppercase text-indigo-600 dark:text-indigo-400">Nombre</p>
                        <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100">{{ $project->name }}</p>
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <p class="text-sm font-semibold uppercase text-indigo-600 dark:text-indigo-400">Descripción</p>
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-md text-base whitespace-pre-wrap">
                            {{ $project->description ?? 'No hay descripción disponible.' }}
                        </div>
                    </div>

                    {{-- Grid de Metadatos: Asignación, Estado, Prioridad, Vencimiento, Creador --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-4 border-t dark:border-gray-700">
                        
                        {{-- Estado --}}
                        <div>
                            <p class="text-sm font-semibold uppercase text-indigo-600 dark:text-indigo-400">Estado</p>
                            <span class="text-xs font-semibold me-2 px-2.5 py-0.5 rounded-full {{ $currentStatusClass }}">
                                {{ $project->status }}
                            </span>
                        </div>

                        {{-- Prioridad --}}
                        <div>
                            <p class="text-sm font-semibold uppercase text-indigo-600 dark:text-indigo-400">Prioridad</p>
                            <span class="text-xs font-semibold me-2 px-2.5 py-0.5 rounded-full {{ $currentPriorityClass }}">
                                {{ $project->priority }}
                            </span>
                        </div>
                        
                        {{-- Fecha de Vencimiento --}}
                        <div>
                            <p class="text-sm font-semibold uppercase text-indigo-600 dark:text-indigo-400">Fecha límite</p>
                            <p class="font-medium">
                                {{ $project->due_date ? \Carbon\Carbon::parse($project->due_date)->format('d/m/Y') : 'N/A' }}
                            </p>
                        </div>
                        
                        {{-- Asignado a --}}
                        <div>
                            <p class="text-sm font-semibold uppercase text-indigo-600 dark:text-indigo-400">Asignado a</p>
                            <p class="font-medium">{{ $project->assignedTo->name ?? 'Usuario eliminado' }}</p>
                        </div>
                        
                        {{-- Creado Por (Asumiendo que existe una relación 'user' o 'creator') --}}
                        <div>
                            <p class="text-sm font-semibold uppercase text-indigo-600 dark:text-indigo-400">Creado por</p>
                            <p class="font-medium">{{ $project->user->name ?? 'Sistema' }}</p>
                        </div>

                    </div>
                </div>

                {{-- Seccion de Herramientas (N:M) --}}
                <div class="mt-8 pt-4 border-t dark:border-gray-700">
                    <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100 border-b pb-2">Herramientas utilizadas</h3>
                    
                    @if ($project->tools->isNotEmpty())
                        <div class="flex flex-wrap gap-2">
                            @foreach ($project->tools as $tool)
                                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300 shadow-sm">
                                    {{ $tool->name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic">No se han asociado herramientas a este proyecto.</p>
                    @endif
                </div>

                {{-- Seccion de Fechas de auditoría --}}
                <div class="mt-8 pt-4 border-t dark:border-gray-700">
                    <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100 border-b pb-2">Auditoría de tiempos</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-600 dark:text-gray-400">
                        
                        {{-- Fecha de creación --}}
                        <div>
                            <p class="font-semibold uppercase text-indigo-500">Fecha de Creación</p>
                            <p>{{ $project->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>

                        {{-- Última Actualización --}}
                        <div>
                            <p class="font-semibold uppercase text-indigo-500">Última Actualización</p>
                            <p>{{ $project->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>

                    </div>
                </div>

                {{-- Botones de Accion --}}
                <div class="mt-8 flex items-center justify-end space-x-4 border-t pt-4 dark:border-gray-700">
                    <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Editar Proyecto
                    </a>
                    <a href="{{ route('projects.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Volver al Listado
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
