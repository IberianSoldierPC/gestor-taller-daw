<x-app-layout>
    <x-slot name="header">
        {{-- Título de la cabecera (Header) --}}
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar proyecto: ') }}
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 to-purple-500 font-extrabold">{{ $project->name }}</span>
        </h2>
    </x-slot>

    {{-- Contenedor --}}
    <div class="py-8 md:py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Contenedor principal -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl lg:shadow-2xl sm:rounded-2xl p-6 md:p-10 border border-gray-100 dark:border-gray-700 transition duration-300">

                <h3 class="text-3xl font-extrabold mb-8 border-b-2 border-gray-200 dark:border-gray-700 pb-3 text-gray-800 dark:text-gray-100">
                    Información del proyecto
                </h3>

                {{-- Formulario --}}
                <form method="POST" action="{{ route('projects.update', $project) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        
                        {{-- Campo nombre --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $project->name) }}" required
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Campo asignado a (solo admin) --}}
                        @if(auth()->user() && auth()->user()->role === 'admin')
                        <div>
                            <label for="assigned_to_user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Asignado a</label>
                            <select name="assigned_to_user_id" id="assigned_to_user_id"
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                                <option value="" {{ old('assigned_to_user_id', $project->assigned_to_user_id) == null ? 'selected' : '' }}>Sin asignar</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('assigned_to_user_id', $project->assigned_to_user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_to_user_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif

                        {{-- Campo estado --}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estado</label>
                            <select name="status" id="status" required
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                                @php
                                    $statuses = ['Pendiente', 'En proceso', 'Terminado', 'En espera de piezas','Urgente'];
                                @endphp
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}"
                                        {{ old('status', $project->status) == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>


                        
                        {{-- Campo fecha de vencimiento --}}
                        <div class="sm:col-span-2">
                            <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha de vencimiento (opcional)</label>
                            <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $project->due_date ? date('Y-m-d', strtotime($project->due_date)) : '') }}"
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                            @error('due_date')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Campo descripción --}}
                        <div class="sm:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">{{ old('description', $project->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- Herramientas --}}
                    <h3 class="text-xl font-bold mt-10 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2 text-gray-800 dark:text-gray-100">
                        Herramientas asignadas
                    </h3>

                    {{-- Lista de herramientas --}}
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
                        @foreach ($tools as $tool)
                            <label class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer p-2 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 transition duration-150">
                                <input type="checkbox" name="tools[]" value="{{ $tool->id }}"
                                    {{ in_array($tool->id, old('tools', $selectedToolIds)) ? 'checked' : '' }}
                                    class="rounded text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-600">
                                <span>{{ $tool->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('tools')
                        <p class="mt-1 mb-4 text-sm text-red-500">{{ $message }}</p>
                    @enderror

                    {{-- Botón guardar --}}
                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-lg hover:shadow-xl">
                            Guardar cambios
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Modal de confirmación de edición de proyecto -->
<div id="confirmEditProjectModal" class="fixed inset-0 bg-gray-600 dark:bg-gray-900 bg-opacity-50 dark:bg-opacity-75 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border-2 border-gray-300 dark:border-gray-600 w-96 shadow-2xl rounded-xl bg-white dark:bg-gray-800 transform transition-all duration-300">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 dark:bg-indigo-900/30 border-2 border-indigo-300 dark:border-indigo-700 mb-4">
                <svg class="h-8 w-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h3 class="text-xl leading-6 font-extrabold text-gray-900 dark:text-white mt-2">Confirmar actualización</h3>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">¿Quieres guardar los cambios de este proyecto?</p>
            <div class="items-center px-4 py-3 flex justify-end space-x-3 mt-4">
                <button id="cancelEditProjectBtn" class="flex-1 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-base font-medium rounded-lg shadow-sm hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50 transition duration-150 border border-gray-300 dark:border-gray-600">Cancelar</button>
                <button id="confirmEditProjectBtn" class="flex-1 px-4 py-2 bg-indigo-600 dark:bg-indigo-700 text-white text-base font-medium rounded-lg shadow-sm hover:bg-indigo-700 dark:hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transition duration-150 border border-indigo-700 dark:border-indigo-600">Confirmar</button>
            </div>
        </div>
    </div>
    </div>

<script>
    // Interceptar submit para mostrar modal
    (function() {
        const form = document.querySelector('form[action*="projects/update"], form[action*="/projects/"]');
        if (!form) return;
        const methodInput = form.querySelector('input[name="_method"]');
        if (!methodInput || methodInput.value.toUpperCase() !== 'PUT') return;
        let pendingSubmitEvent = null;
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            pendingSubmitEvent = e;
            document.getElementById('confirmEditProjectModal').classList.remove('hidden');
        });
        document.getElementById('cancelEditProjectBtn').addEventListener('click', () => {
            document.getElementById('confirmEditProjectModal').classList.add('hidden');
            pendingSubmitEvent = null;
        });
        document.getElementById('confirmEditProjectBtn').addEventListener('click', () => {
            document.getElementById('confirmEditProjectModal').classList.add('hidden');
            if (pendingSubmitEvent) {
                pendingSubmitEvent.target.submit();
            }
        });
    })();
</script>
