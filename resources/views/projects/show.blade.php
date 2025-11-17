<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles del Proyecto') }}: {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100 border-b pb-2">Información Principal</h3>
                
                {{-- Contenedor de Detalles --}}
                <div class="space-y-4 text-gray-700 dark:text-gray-300">
                    
                    {{-- Nombre --}}
                    <div>
                        <p class="text-sm font-semibold uppercase text-indigo-600 dark:text-indigo-400">Nombre</p>
                        <p class="text-lg font-extrabold">{{ $project->name }}</p>
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <p class="text-sm font-semibold uppercase text-indigo-600 dark:text-indigo-400">Descripción</p>
                        <p class="whitespace-pre-wrap">{{ $project->description ?? 'No hay descripción disponible.' }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-2 border-t dark:border-gray-700">
                        {{-- Asignado a --}}
                        <div>
                            <p class="text-sm font-semibold uppercase text-indigo-600 dark:text-indigo-400">Asignado a</p>
                            <p>{{ $project->assignedTo->name ?? 'Usuario Eliminado' }}</p>
                        </div>
                        
                        {{-- Estado --}}
                        <div>
                            <p class="text-sm font-semibold uppercase text-indigo-600 dark:text-indigo-400">Estado</p>
                            <p>{{ $project->status }}</p>
                        </div>

                        {{-- Prioridad --}}
                        <div>
                            <p class="text-sm font-semibold uppercase text-indigo-600 dark:text-indigo-400">Prioridad</p>
                            <p>{{ $project->priority }}</p>
                        </div>
                        
                        {{-- Fecha de Vencimiento --}}
                        <div>
                            <p class="text-sm font-semibold uppercase text-indigo-600 dark:text-indigo-400">Fecha Límite</p>
                            <p>{{ $project->due_date ? \Carbon\Carbon::parse($project->due_date)->format('d/m/Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Seccion de Herramientas (N:M) --}}
                <div class="mt-8 pt-4 border-t dark:border-gray-700">
                    <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100 border-b pb-2">Herramientas Utilizadas</h3>
                    
                    @if ($project->tools->isNotEmpty())
                        <div class="flex flex-wrap gap-2">
                            @foreach ($project->tools as $tool)
                                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                    {{ $tool->name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic">No se han asociado herramientas a este proyecto.</p>
                    @endif
                </div>

                {{-- Botones de Accion --}}
                <div class="mt-8 flex items-center justify-end space-x-4 border-t pt-4 dark:border-gray-700">
                    <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Editar Proyecto
                    </a>
                    <a href="{{ route('projects.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                        Volver al Listado
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
