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
                            <x-input-label for="name" :value="__('Nombre de la herramienta')" />
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
                            <x-input-label for="status" :value="__('Estado actual')" />
                            @php
                                $statusOptions = $statuses ?? [];
                            @endphp
                            <select id="status" name="status" class="mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-amber-400 focus:ring-orange-500 dark:focus:ring-amber-400 rounded-lg shadow-sm block w-full" required>
                                @foreach ($statusOptions as $status)
                                    <option value="{{ $status }}" @selected($currentStatus === $status)>{{ $status }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        {{-- 4. Campo Usuario Asignado (solo admin) --}}
                        @if(auth()->user() && auth()->user()->role === 'admin')
                        <div>
                            <x-input-label for="user_id" :value="__('Asignar a usuario')" />
                            <select id="user_id" name="user_id" class="mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-amber-400 focus:ring-orange-500 dark:focus:ring-amber-400 rounded-lg shadow-sm block w-full">
                                <option value="" {{ $currentUserId == null ? 'selected' : '' }}>Sin asignar</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $currentUserId == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                        </div>
                        @endif

                        {{-- 5. Campo Fecha de Adquisición --}}
                        <div>
                            <x-input-label for="acquisition_date" :value="__('Fecha de adquisición')" />
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

<!-- Modal de confirmación de edición de herramienta -->
<div id="confirmEditToolModal" class="fixed inset-0 bg-gray-600 dark:bg-gray-900 bg-opacity-50 dark:bg-opacity-75 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border-2 border-gray-300 dark:border-gray-600 w-96 shadow-2xl rounded-xl bg-white dark:bg-gray-800 transform transition-all duration-300">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 dark:bg-indigo-900/30 border-2 border-indigo-300 dark:border-indigo-700 mb-4">
                <svg class="h-8 w-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h3 class="text-xl leading-6 font-extrabold text-gray-900 dark:text-white mt-2">Confirmar actualización</h3>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">¿Quieres guardar los cambios de esta herramienta?</p>
            <div class="items-center px-4 py-3 flex justify-end space-x-3 mt-4">
                <button id="cancelEditToolBtn" class="flex-1 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-base font-medium rounded-lg shadow-sm hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50 transition duration-150 border border-gray-300 dark:border-gray-600">Cancelar</button>
                <button id="confirmEditToolBtn" class="flex-1 px-4 py-2 bg-indigo-600 dark:bg-indigo-700 text-white text-base font-medium rounded-lg shadow-sm hover:bg-indigo-700 dark:hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transition duration-150 border border-indigo-700 dark:border-indigo-600">Confirmar</button>
            </div>
        </div>
    </div>
    </div>

<script>
    // Interceptar submit para mostrar modal
    (function() {
        const form = document.querySelector('form[action*="tools/update"], form[action*="/tools/"]');
        if (!form) return;
        const methodInput = form.querySelector('input[name="_method"]');
        if (!methodInput || methodInput.value.toUpperCase() !== 'PUT') return;
        let pendingSubmitEvent = null;
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            pendingSubmitEvent = e;
            document.getElementById('confirmEditToolModal').classList.remove('hidden');
        });
        document.getElementById('cancelEditToolBtn').addEventListener('click', () => {
            document.getElementById('confirmEditToolModal').classList.add('hidden');
            pendingSubmitEvent = null;
        });
        document.getElementById('confirmEditToolBtn').addEventListener('click', () => {
            document.getElementById('confirmEditToolModal').classList.add('hidden');
            if (pendingSubmitEvent) {
                pendingSubmitEvent.target.submit();
            }
        });
    })();
</script>
