<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Proyectos DIY') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Mensaje de estado (éxito/error) --}}
            @if (session('status'))
            <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg relative mb-4 shadow-md" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
            @endif


            {{-- ---------------------------------------------------- --}}
            {{-- BLOQUE DE TARJETAS DE ESTADÍSTICAS (PROYECTOS) --}}
            {{-- ---------------------------------------------------- --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                {{-- 1. Tarjeta: Total de Proyectos (COLOR NARANJA PRINCIPAL) --}}
                <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-lg border-l-4 border-orange-500 dark:border-orange-400 transition duration-300 hover:shadow-xl">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Registrados</p>
                    <p class="text-4xl font-extrabold text-gray-900 dark:text-white mt-1">
                        {{ $totalProjects ?? 0 }}
                    </p>
                </div>

                {{-- 2. Tarjeta: Proyectos En Progreso (COLOR ÁMBAR/AMARILLO CÁLIDO) --}}
                <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-lg border-l-4 border-amber-500 dark:border-amber-400 transition duration-300 hover:shadow-xl">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">En Progreso</p>
                    <p class="text-4xl font-extrabold text-gray-900 dark:text-white mt-1">
                        {{ $inProgressProjects ?? 0 }}
                    </p>
                </div>

                {{-- 3. Tarjeta: Proyectos Completados (COLOR VERDE - ÉXITO) --}}
                <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-lg border-l-4 border-green-500 dark:border-green-400 transition duration-300 hover:shadow-xl">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Completados</p>
                    <p class="text-4xl font-extrabold text-gray-900 dark:text-white mt-1">
                        {{ $completedProjects ?? 0 }}
                    </p>
                </div>

                {{-- 4. Tarjeta: Proyectos Bloqueados/Riesgo (COLOR ROJO - ALERTA) --}}
                <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-lg border-l-4 border-red-500 dark:border-red-400 transition duration-300 hover:shadow-xl">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bloqueados / Riesgo</p>
                    <p class="text-4xl font-extrabold text-gray-900 dark:text-white mt-1">
                        {{ $blockedProjects ?? 0 }}
                    </p>
                </div>

            </div>
            {{-- ---------------------------------------------------- --}}
            {{-- FIN BLOQUE DE ESTADÍSTICAS --}}
            {{-- ---------------------------------------------------- --}}

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between items-center mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                        {{-- Título principal con el color de la marca naranja --}}
                        <p class="text-2xl font-extrabold text-orange-600 dark:text-amber-400">Listado de Proyectos</p>
                        {{-- Botón de acción principal con color naranja --}}
                        <a href="{{ route('projects.create') }}" class="bg-orange-600 hover:bg-orange-700 dark:bg-orange-500 dark:hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out transform hover:scale-105">
                            <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Añadir Nuevo Proyecto
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700 border-b-2 border-gray-200 dark:border-gray-600">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre del Proyecto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha Límite</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Responsable</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @php
                                // Clases ocultas para forzar la compilación de Tailwind de todos los colores posibles
                                // Las mantengo ya que son un buen intento para forzar el Purge/JIT de Tailwind
                                echo '<span class="hidden bg-green-100 text-green-800 bg-red-100 text-red-800 bg-yellow-100 text-yellow-800 bg-amber-100 text-amber-800 bg-gray-100 text-gray-800 dark:bg-green-900/20 dark:text-green-400 dark:bg-red-900/20 dark:text-red-400 dark:bg-yellow-900/20 dark:text-yellow-400 dark:bg-amber-900/20 dark:text-amber-400 dark:bg-gray-900/20 dark:text-gray-400"></span>';

                                // Mapeo de colores para estados de proyecto
                                $statusColors = [
                                'Terminado' => ['bg' => 'bg-green-100 dark:bg-green-900/20', 'text' => 'text-green-800 dark:text-green-400'],
                                'En proceso' => ['bg' => 'bg-amber-100 dark:bg-amber-900/20', 'text' => 'text-amber-800 dark:text-amber-400'],
                                'Pendiente' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/20', 'text' => 'text-yellow-800 dark:text-yellow-400'],
                                'En espera de piezas' => ['bg' => 'bg-blue-100 dark:bg-blue-900/20', 'text' => 'text-blue-800 dark:text-blue-400'],
                                'Bloqueado' => ['bg' => 'bg-red-100 dark:bg-red-900/20', 'text' => 'text-red-800 dark:text-red-400'],
                                'Cancelado' => ['bg' => 'bg-gray-100 dark:bg-gray-900/20', 'text' => 'text-gray-800 dark:text-gray-400'],
                                ];
                                @endphp

                                @forelse ($projects as $project)
                                @php
                                // Obtiene las clases de color, usando gris por defecto si el estado no coincide con las claves
                                $color = $statusColors[$project->status] ?? ['bg' => 'bg-gray-100 dark:bg-gray-900/20', 'text' => 'text-gray-800 dark:text-gray-400'];
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-100 border-b border-gray-200 dark:border-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $project->name }}</td>
                                    
                                    {{-- Formateo de fecha más amigable (dd/mm/yyyy) --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        @if ($project->due_date)
                                            {{ date('d/m/Y', strtotime($project->due_date)) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border border-opacity-30 {{ $color['bg'] }} {{ $color['text'] }}">
                                            {{ $project->status }}
                                        </span>
                                    </td>
                                    {{-- Asumiendo una relación 'owner' (líder del proyecto) --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $project->owner->name ?? 'N/A' }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-2">
                                        {{-- Enlace Editar con color naranja --}}
                                        <a href="{{ route('projects.edit', $project->id) }}" class="text-orange-600 dark:text-orange-400 hover:text-orange-900 dark:hover:text-orange-300 font-bold transition duration-150">Editar</a>

                                        {{-- Botón para mostrar el modal de confirmación --}}
                                        <button
                                            type="button"
                                            class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 font-bold transition duration-150 delete-project-btn"
                                            data-project-id="{{ $project->id }}"
                                            data-project-name="{{ $project->name }}"
                                        >
                                            Borrar
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-6 text-center text-lg text-gray-500 dark:text-gray-400">
                                        <p>✨ ¡Genial! No hay proyectos registrados aún.</p>
                                        {{-- Enlace de acción con color naranja --}}
                                        <a href="{{ route('projects.create') }}" class="text-orange-600 dark:text-orange-400 hover:text-orange-900 dark:hover:text-orange-300 underline mt-2 inline-block">Añadir el primer proyecto</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- ---------------------------------------------------- --}}
                    {{-- BLOQUE DE PAGINACIÓN --}}
                    {{-- ---------------------------------------------------- --}}
                    {{-- Solo mostramos la paginación si hay más de una página. --}}
                    @if (isset($projects) && method_exists($projects, 'hasPages') && $projects->hasPages())
                    <div class="mt-6 p-4 border-t-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-b-lg">
                        {{ $projects->links() }}
                    </div>
                    @endif
                    {{-- ---------------------------------------------------- --}}
                    {{-- FIN BLOQUE DE PAGINACIÓN --}}
                    {{-- ---------------------------------------------------- --}}

                </div>
            </div>
        </div>
    </div>

    {{-- ---------------------------------------------------- --}}
    {{-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN --}}
    {{-- ---------------------------------------------------- --}}
    <div id="deleteConfirmationModal" class="fixed inset-0 bg-gray-600 dark:bg-gray-900 bg-opacity-50 dark:bg-opacity-75 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border-2 border-gray-300 dark:border-gray-600 w-96 shadow-2xl rounded-xl bg-white dark:bg-gray-800 transform transition-all duration-300">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 dark:bg-red-900/30 border-2 border-red-300 dark:border-red-700 mb-4">
                    <svg class="h-8 w-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.503-1.65 1.777-3.094L13.79 4.383c-.727-1.444-2.827-1.444-3.554 0L3.58 17.906c-.726 1.444.247 3.094 1.777 3.094z"></path>
                    </svg>
                </div>
                <h3 class="text-xl leading-6 font-extrabold text-gray-900 dark:text-white mt-2">Eliminar Proyecto</h3>
                <div class="mt-4 px-2 py-3 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-700/30">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        ¿Estás seguro de que deseas eliminar permanentemente el proyecto "<strong id="projectNameDisplay" class="font-semibold text-gray-700 dark:text-gray-300"></strong>"? Esta acción no se puede deshacer.
                    </p>
                </div>
                <div class="items-center px-4 py-3 flex justify-end space-x-3 border-t border-gray-200 dark:border-gray-700 mt-4">
                    <button id="cancelDeleteBtn" class="flex-1 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-base font-medium rounded-lg shadow-sm hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50 transition duration-150 border border-gray-300 dark:border-gray-600">
                        Cancelar
                    </button>
                    {{-- Formulario que se enviará al confirmar --}}
                    <form id="deleteProjectForm" method="POST" class="inline flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 dark:bg-red-700 text-white text-base font-medium rounded-lg shadow-sm hover:bg-red-700 dark:hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-150 border border-red-700 dark:border-red-600">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- ---------------------------------------------------- --}}
    {{-- LÓGICA DE JAVASCRIPT PARA EL MODAL --}}
    {{-- ---------------------------------------------------- --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('deleteConfirmationModal');
            const deleteButtons = document.querySelectorAll('.delete-project-btn');
            const form = document.getElementById('deleteProjectForm');
            const projectNameDisplay = document.getElementById('projectNameDisplay');
            const cancelButton = document.getElementById('cancelDeleteBtn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const projectId = this.getAttribute('data-project-id');
                    const projectName = this.getAttribute('data-project-name');

                    // 1. Configurar el formulario con la ruta correcta
                    // Se usa un placeholder que Blade reemplaza en la carga de la página
                    const deleteRoute = `{{ route('projects.destroy', 'PLACEHOLDER') }}`.replace('PLACEHOLDER', projectId);
                    form.action = deleteRoute;

                    // 2. Mostrar el nombre del proyecto en el modal
                    projectNameDisplay.textContent = projectName;

                    // 3. Mostrar el modal
                    modal.classList.remove('hidden');
                });
            });

            // 4. Lógica para cerrar el modal
            cancelButton.addEventListener('click', function() {
                modal.classList.add('hidden');
            });

            // Cierra el modal si se hace clic fuera de él
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>
