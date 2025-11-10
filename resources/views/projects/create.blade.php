<!--<script src="https://cdn.tailwindcss.com"></script> <!-- INCLUIDO TEMPORALMENTE: Asegura que los estilos de Tailwind se carguen para visualizar correctamente el formulario. -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Proyecto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                
                <h3 class="text-2xl font-bold text-indigo-700 mb-6 border-b pb-3">Detalles del Proyecto</h3>
                
                {{-- Manejo de errores de validación --}}
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <strong class="font-bold">¡Atención!</strong>
                        <span class="block sm:inline">Hay problemas con los datos proporcionados.</span>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('projects.store') }}">
                    @csrf
                    
                    {{-- 1. Nombre del Proyecto --}}
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre/Título del Proyecto (*)</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    {{-- 2. Descripción --}}
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Descripción (Opcional)</label>
                        <textarea name="description" id="description" rows="3" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                        {{-- 3. Estado (ENUM) --}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Estado (*)</label>
                            <select name="status" id="status" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Pendiente" {{ old('status') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="En Proceso" {{ old('status') == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                                <option value="Terminado" {{ old('status') == 'Terminado' ? 'selected' : '' }}>Terminado</option>
                                <option value="En Espera de Piezas" {{ old('status') == 'En Espera de Piezas' ? 'selected' : '' }}>En Espera de Piezas</option>
                            </select>
                        </div>

                        {{-- 4. Prioridad (ENUM) --}}
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700">Prioridad (*)</label>
                            <select name="priority" id="priority" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Baja" {{ old('priority') == 'Baja' ? 'selected' : '' }}>Baja</option>
                                <option value="Media" {{ old('priority') == 'Media' ? 'selected' : '' }}>Media</option>
                                <option value="Alta" {{ old('priority') == 'Alta' ? 'selected' : '' }}>Alta</option>
                                <option value="Urgente" {{ old('priority') == 'Urgente' ? 'selected' : '' }}>Urgente</option>
                            </select>
                        </div>
                        
                        {{-- 5. Fecha Límite --}}
                        <div>
                            <label for="due_date" class="block text-sm font-medium text-gray-700">Fecha Límite (Opcional)</label>
                            <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    {{-- 6. Asignado a (Usuario) --}}
                    <div class="mb-6">
                        <label for="assigned_to_user_id" class="block text-sm font-medium text-gray-700">Asignado a Empleado (*)</label>
                        <select name="assigned_to_user_id" id="assigned_to_user_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Selecciona un Empleado --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('assigned_to_user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">Herramientas Requeridas (Relación N:M)</h3>
                    
                    {{-- 7. Herramientas Requeridas (Select Múltiple) --}}
                    <div class="mb-6">
                        <label for="tools" class="block text-sm font-medium text-gray-700">Selecciona las Herramientas que se usarán (CTRL + click para múltiple)</label>
                        <select name="tools[]" id="tools" multiple size="8"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach ($tools as $tool)
                                <option value="{{ $tool->id }}" 
                                    {{ in_array($tool->id, old('tools', [])) ? 'selected' : '' }}>
                                    {{ $tool->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Mantén pulsado **CTRL/CMD** para seleccionar varias herramientas.</p>
                    </div>

                    {{-- Botón de Guardar --}}
                    <div class="flex justify-end">
                        <a href="{{ route('projects.index') }}" class="mr-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out transform hover:scale-105">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-150 ease-in-out transform hover:scale-105">
                            Crear Proyecto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
