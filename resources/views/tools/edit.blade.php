<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Herramienta: ') . $tool->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <form method="POST" action="{{ route('tools.update', $tool->id) }}">
                    @csrf
                    {{-- ESTO ES ESENCIAL: Indica que la solicitud es PUT para la actualización --}}
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- 1. Campo Nombre --}}
                        <div>
                            <x-input-label for="name" :value="__('Nombre de la Herramienta')" />
                            <x-text-input
                                id="name"
                                name="name"
                                type="text"
                                class="mt-1 block w-full"
                                {{-- Precargamos el valor actual o el valor anterior (old) --}}
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
                                class="mt-1 block w-full"
                                :value="old('location', $tool->location)"
                                required
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('location')" />
                        </div>

                        {{-- 3. Campo Estado (Enum) --}}
                        <div>
                            <x-input-label for="status" :value="__('Estado Actual')" />
                            <select id="status" name="status" class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full" required>
                                @php $currentStatus = old('status', $tool->status); @endphp
                                <option value="Operativa" {{ $currentStatus == 'Operativa' ? 'selected' : '' }}>Operativa</option>
                                <option value="Averiada" {{ $currentStatus == 'Averiada' ? 'selected' : '' }}>Averiada</option>
                                <option value="Prestada" {{ $currentStatus == 'Prestada' ? 'selected' : '' }}>Prestada</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        {{-- 4. Campo Usuario Asignado (Relación user_id) --}}
                        <div>
                            <x-input-label for="user_id" :value="__('Asignar a Usuario')" />
                            {{-- Necesitas tener la variable $users disponible en la vista, igual que en create --}}
                            <select id="user_id" name="user_id" class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full" required>
                                @php $currentUserId = old('user_id', $tool->user_id); @endphp
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
                                class="mt-1 block w-full"
                                {{-- Debes formatear la fecha a un string compatible con el input type="date" --}}
                                :value="old('acquisition_date', $tool->acquisition_date ? $tool->acquisition_date->format('Y-m-d') : null)"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('acquisition_date')" />
                        </div>

                        {{-- 6. Campo Descripción (ocupa toda la fila) --}}
                        <div class="md:col-span-2">
                            <x-input-label for="description" :value="__('Descripción (opcional)')" />
                            <textarea id="description" name="description" rows="3" class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">{{ old('description', $tool->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('tools.index') }}" class="text-gray-600 hover:text-gray-900 me-4">
                            {{ __('Cancelar') }}
                        </a>
                        <x-primary-button>
                            {{ __('Actualizar Herramienta') }}
                        </x-primary-button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>