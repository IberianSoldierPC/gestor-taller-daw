<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Añadir Nueva Herramienta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Contenedor del formulario con estilo moderno -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl p-8">
                
                <form method="POST" action="{{ route('tools.store') }}">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Campo Nombre -->
                        <div>
                            <x-input-label for="name" :value="__('Nombre de la Herramienta')" />
                            <!-- x-text-input ya tiene estilos, aseguramos la coherencia con dark mode -->
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full focus:border-orange-500 focus:ring-orange-500 dark:focus:border-amber-400 dark:focus:ring-amber-400 rounded-lg" :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- Campo Ubicación -->
                        <div>
                            <x-input-label for="location" :value="__('Ubicación')" />
                            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full focus:border-orange-500 focus:ring-orange-500 dark:focus:border-amber-400 dark:focus:ring-amber-400 rounded-lg" :value="old('location')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('location')" />
                        </div>

                        <!-- Campo Estado -->
                        <div>
                            <x-input-label for="status" :value="__('Estado Actual')" />
                            <!-- Aplicamos estilos del input a Select -->
                            <select id="status" name="status" class="mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-amber-400 focus:ring-orange-500 dark:focus:ring-amber-400 rounded-lg shadow-sm block w-full" required>
                                <option value="Operativa" {{ old('status') == 'Operativa' ? 'selected' : '' }}>Operativa</option>
                                <option value="Averiada" {{ old('status') == 'Averiada' ? 'selected' : '' }}>Averiada</option>
                                <option value="Prestada" {{ old('status') == 'Prestada' ? 'selected' : '' }}>Prestada</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <!-- Campo Asignar Usuario -->
                        <div>
                            <x-input-label for="user_id" :value="__('Asignar a Usuario (Opcional)')" />
                            <select id="user_id" name="user_id" class="mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-amber-400 focus:ring-orange-500 dark:focus:ring-amber-400 rounded-lg shadow-sm block w-full">
                                <option value="" {{ old('user_id') === null ? 'selected' : '' }}>Sin Asignar</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                        </div>

                        <!-- Campo Fecha de Adquisición -->
                        <div>
                            <x-input-label for="acquisition_date" :value="__('Fecha de Adquisición')" />
                            <x-text-input id="acquisition_date" name="acquisition_date" type="date" class="mt-1 block w-full focus:border-orange-500 focus:ring-orange-500 dark:focus:border-amber-400 dark:focus:ring-amber-400 rounded-lg" :value="old('acquisition_date')" />
                            <x-input-error class="mt-2" :messages="$errors->get('acquisition_date')" />
                        </div>
                        
                        <!-- Campo Descripción -->
                        <div class="md:col-span-2">
                            <x-input-label for="description" :value="__('Descripción (opcional)')" />
                            <!-- Aplicamos estilos del input a Textarea -->
                            <textarea id="description" name="description" rows="3" class="mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-amber-400 focus:ring-orange-500 dark:focus:ring-amber-400 rounded-lg shadow-sm block w-full">{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <!-- Botón principal -->
                        <x-primary-button class="bg-orange-600 hover:bg-orange-700 active:bg-orange-800 dark:bg-amber-500 dark:hover:bg-amber-600 dark:active:bg-amber-700 rounded-xl px-6 py-3 font-semibold shadow-md transition transform hover:scale-[1.02]">
                            {{ __('Guardar Herramienta') }}
                        </x-primary-button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
