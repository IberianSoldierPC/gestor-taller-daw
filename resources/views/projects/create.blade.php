<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Nuevo Proyecto') }}
        </h2>
    </x-slot>

    {{-- Contenedor de la vista --}}
    <div class="py-8 md:py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Contenedor principal con estilo de tarjeta mejorado -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl lg:shadow-2xl sm:rounded-2xl p-6 md:p-10 border border-gray-100 dark:border-gray-700 transition duration-300">
                
                {{-- Título con gradiente vibrante --}}
                <h3 class="text-3xl font-extrabold mb-6 border-b-2 border-gray-200 dark:border-gray-700 pb-3
                           bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                    Detalles del Proyecto
                </h3>
                
                {{-- Manejo de errores de validación estilizado --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-300 dark:border-red-700 text-red-800 dark:text-red-300 shadow-inner">
                        <div class="flex items-start">
                            <svg class="h-6 w-6 mr-3 mt-0.5 text-red-500 dark:text-red-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.332 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <strong class="font-bold text-lg block">¡Validación Requerida!</strong>
                                <span class="block text-sm">Por favor, corrige los siguientes problemas:</span>
                                <ul class="mt-2 list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('projects.store') }}">
                    @csrf
                    
                    {{-- 1. Nombre del Proyecto --}}
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Nombre/Título del Proyecto <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm transition duration-150 ease-in-out
                                focus:border-indigo-500 focus:ring-indigo-500 hover:border-indigo-400 p-3">
                    </div>

                    {{-- 2. Descripción --}}
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Descripción (Opcional)</label>
                        <textarea name="description" id="description" rows="3"
                                  class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm transition duration-150 ease-in-out
                                  focus:border-indigo-500 focus:ring-indigo-500 hover:border-indigo-400 p-3">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        {{-- 3. Estado (ENUM) --}}
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Estado <span class="text-red-500">*</span></label>
                            <select name="status" id="status" required
                                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm appearance-none cursor-pointer transition duration-150 ease-in-out
                                    focus:border-indigo-500 focus:ring-indigo-500 hover:border-indigo-400 p-3">
                                <option value="Pendiente" {{ old('status') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="En Proceso" {{ old('status') == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                                <option value="Terminado" {{ old('status') == 'Terminado' ? 'selected' : '' }}>Terminado</option>
                                <option value="En Espera de Piezas" {{ old('status') == 'En Espera de Piezas' ? 'selected' : '' }}>En Espera de Piezas</option>
                            </select>
                        </div>

                        {{-- 4. Prioridad (ENUM) --}}
                        <div>
                            <label for="priority" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Prioridad <span class="text-red-500">*</span></label>
                            <select name="priority" id="priority" required
                                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm appearance-none cursor-pointer transition duration-150 ease-in-out
                                    focus:border-indigo-500 focus:ring-indigo-500 hover:border-indigo-400 p-3">
                                <option value="Baja" {{ old('priority') == 'Baja' ? 'selected' : '' }}>Baja</option>
                                <option value="Media" {{ old('priority') == 'Media' ? 'selected' : '' }}>Media</option>
                                <option value="Alta" {{ old('priority') == 'Alta' ? 'selected' : '' }}>Alta</option>
                                <option value="Urgente" {{ old('priority') == 'Urgente' ? 'selected' : '' }}>Urgente</option>
                            </select>
                        </div>
                        
                        {{-- 5. Fecha Límite --}}
                        <div>
                            <label for="due_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Fecha Límite (Opcional)</label>
                            <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}"
                                   class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm transition duration-150 ease-in-out
                                   focus:border-indigo-500 focus:ring-indigo-500 hover:border-indigo-400 p-3">
                        </div>
                    </div>

                    {{-- 6. Asignado a (Usuario) --}}
                    <div class="mb-8">
                        <label for="assigned_to_user_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Asignado a Empleado <span class="text-red-500">*</span></label>
                        <select name="assigned_to_user_id" id="assigned_to_user_id" required
                                class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm appearance-none cursor-pointer transition duration-150 ease-in-out
                                focus:border-indigo-500 focus:ring-indigo-500 hover:border-indigo-400 p-3">
                            <option value="">-- Selecciona un Empleado --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('assigned_to_user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <h3 class="text-2xl font-extrabold text-gray-700 dark:text-gray-300 mb-4 border-b border-gray-300 dark:border-gray-700 pb-2">Herramientas Requeridas (Relación N:M)</h3>
                    
                    {{-- 7. Herramientas Requeridas (Select Múltiple) --}}
                    <div class="mb-8">
                        <label for="tools" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Selecciona las Herramientas que se usarán</label>
                        <select name="tools[]" id="tools" multiple size="8"
                                class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-inner focus:border-indigo-500 focus:ring-indigo-500 p-3">
                            @foreach ($tools as $tool)
                                <option value="{{ $tool->id }}"
                                    {{ in_array($tool->id, old('tools', [])) ? 'selected' : '' }}
                                    class="py-2 px-3 hover:bg-indigo-100 dark:hover:bg-indigo-900 transition duration-100 ease-in-out">
                                    {{ $tool->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Mantén pulsado **CTRL/CMD** o arrastra el ratón para seleccionar varias herramientas.</p>
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                        {{-- Botón Cancelar (Secundario) --}}
                        <a href="{{ route('projects.index') }}" class="mr-4 bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600 font-semibold py-2 px-5 rounded-xl transition duration-150 ease-in-out transform hover:scale-[1.02] shadow-sm">
                            Cancelar
                        </a>
                        
                        {{-- Botón Principal (Con Gradiente) --}}
                        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-2 px-6 rounded-xl transition duration-300 ease-in-out transform hover:scale-[1.02] shadow-xl shadow-indigo-500/50 flex items-center justify-center">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Crear Proyecto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
