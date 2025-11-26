<x-app-layout>
    <x-slot name="header">
        {{-- Título de la cabecera (Header) --}}
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar proyecto: ') }}
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 to-purple-500 font-extrabold">{{ $project->name }}</span>
        </h2>
    </x-slot>

    {{-- Contenedor de la vista --}}
    <div class="py-8 md:py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Contenedor principal con estilo de tarjeta mejorado -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl lg:shadow-2xl sm:rounded-2xl p-6 md:p-10 border border-gray-100 dark:border-gray-700 transition duration-300">

                <h3 class="text-3xl font-extrabold mb-8 border-b-2 border-gray-200 dark:border-gray-700 pb-3 text-gray-800 dark:text-gray-100">
                    Información del Proyecto
                </h3>

                {{-- Formulario de Edición --}}
                <form method="POST" action="{{ route('projects.update', $project) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        
                        {{-- Campo Nombre --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $project->name) }}" required
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Campo Asignado a (assigned_to_user_id) --}}
                        <div>
                            <label for="assigned_to_user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Asignado a</label>
                            <select name="assigned_to_user_id" id="assigned_to_user_id" required
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
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

                        {{-- Campo Estatus --}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estatus</label>
                            <select name="status" id="status" required
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                                @php
                                    $statuses = ['Pendiente', 'En Proceso', 'Terminado', 'En espera de piezas'];
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

                        {{-- Campo Prioridad --}}
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prioridad</label>
                            <select name="priority" id="priority" required
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                                @php
                                    $priorities = ['Baja', 'Media', 'Alta', 'Urgente'];
                                @endphp
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority }}"
                                        {{ old('priority', $project->priority) == $priority ? 'selected' : '' }}>
                                        {{ $priority }}
                                    </option>
                                @endforeach
                            </select>
                            @error('priority')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Campo Fecha de Vencimiento --}}
                        <div class="sm:col-span-2">
                            <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha de Vencimiento (Opcional)</label>
                            <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $project->due_date ? date('Y-m-d', strtotime($project->due_date)) : '') }}"
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                            @error('due_date')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Campo Descripción (ocupa dos columnas) --}}
                        <div class="sm:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">{{ old('description', $project->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- Separador y Herramientas --}}
                    <h3 class="text-xl font-bold mt-10 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2 text-gray-800 dark:text-gray-100">
                        Herramientas Asignadas
                    </h3>

                    {{-- Lista de Herramientas (checkboxes) --}}
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

                    {{-- Botón de Guardar --}}
                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-lg hover:shadow-xl">
                            Guardar Cambios
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
