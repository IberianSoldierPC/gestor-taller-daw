<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Herramienta: ') }}
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 to-purple-500 font-extrabold">{{ $tool->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Contenedor del formulario-->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl p-8">

                @php
                    // Pre-calculamos los valores para limpiar el HTML
                    $currentStatus = old('status', $tool->status);
                    $currentUserId = old('user_id', $tool->user_id);
                    // Formatea la fecha para el input type="date"
                    $currentAcquisitionDate = old('acquisition_date', $tool->acquisition_date ? (is_string($tool->acquisition_date) ? $tool->acquisition_date : $tool->acquisition_date->format('Y-m-d')) : null);
                @endphp

                <form method="POST" action="{{ route('tools.update', $tool->id) }}">
                    @csrf
                    {{-- Indica que la solicitud es PUT para la actualización --}}
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- 1. Campo Nombre --}}
                        <div>
                            <x-input-label for="name" :value="__('Nombre de la Herramienta')" />
                            <x-text-input
                                id="name"
                                name="name"
                                type="text"
                                class="mt-1 block w-full focus:border-orange-500 focus:ring-orange-500 dark:focus:border-amber-400 dark:focus:ring-amber-400 rounded-lg"
                                :value="old('name', $tool->name)"
                                required
                                autofocus
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        {{-- 2. Campo Ubicación --}}
                        <div>
                            <x-input-label for="location" :value="__('Ubicación')" />
                            <x-text-input
                                id="location"
                                name="location"
                                type="text"
                                class="mt-1 block w-full focus:border-orange-500 focus:ring-orange-500 dark:focus:border-amber-400 dark:focus:ring-amber-400 rounded-lg"
                                :value="old('location', $tool->location)"
                                required
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('location')" />
                        </div>

                        {{-- 3. Campo Estado (Enum) --}}
                        <div>
                            <x-input-label for="status" :value="__('Estado Actual')" />
                            <select id="status" name="status" class="mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-amber-400 focus:ring-orange-500 dark:focus:ring-amber-400 rounded-lg shadow-sm block w-full" required>
                                <option value="Operativa"    {{ $currentStatus == 'Operativa' ? 'selected' : '' }}>Operativa</option>
                                <option value="Disponible"   {{ $currentStatus == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                                <option value="Prestada"     {{ $currentStatus == 'Prestada' ? 'selected' : '' }}>Prestada</option>
                                <option value="En Uso"       {{ $currentStatus == 'En Uso' ? 'selected' : '' }}>En Uso</option>
                                <option value="Averiada"     {{ $currentStatus == 'Averiada' ? 'selected' : '' }}>Averiada</option>
                                <option value="Mantenimiento"{{ $currentStatus == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                <option value="Rota"         {{ $currentStatus == 'Rota' ? 'selected' : '' }}>Rota</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        {{-- 4. Campo Usuario Asignado (Relación user_id - Ahora opcional) --}}
                        <div>
                            <x-input-label for="user_id" :value="__('Asignar a Usuario')" />
                            <select id="user_id" name="user_id" required class="mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-amber-400 focus:ring-orange-500 dark:focus:ring-amber-400 rounded-lg shadow-sm block w-full">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $currentUserId == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                        </div>

                        {{-- 5. Campo Fecha de Adquisición --}}
                        <div>
                            <x-input-label for="acquisition_date" :value="__('Fecha de Adquisición')" />
                            <x-text-input
                                id="acquisition_date"
                                name="acquisition_date"
                                type="date"
                                class="mt-1 block w-full focus:border-orange-500 focus:ring-orange-500 dark:focus:border-amber-400 dark:focus:ring-amber-400 rounded-lg"
                                :value="$currentAcquisitionDate"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('acquisition_date')" />
                        </div>

                        {{-- 6. Campo Descripción (ocupa toda la fila) --}}
                        <div class="md:col-span-2">
                            <x-input-label for="description" :value="__('Descripción (opcional)')" />
                            <textarea id="description" name="description" rows="3" class="mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-amber-400 focus:ring-orange-500 dark:focus:ring-amber-400 rounded-lg shadow-sm block w-full">{{ old('description', $tool->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <a href="{{ route('tools.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 font-medium me-4 py-3 px-6 transition duration-150 rounded-xl">
                            {{ __('Cancelar') }}
                        </a>
                        <x-primary-button class="bg-orange-600 hover:bg-orange-700 active:bg-orange-800 dark:bg-amber-500 dark:hover:bg-amber-600 dark:active:bg-amber-700 rounded-xl px-6 py-3 font-semibold shadow-md transition transform hover:scale-[1.02]">
                            {{ __('Actualizar Herramienta') }}
                        </x-primary-button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
