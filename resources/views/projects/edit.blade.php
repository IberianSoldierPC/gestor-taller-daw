@extends('layouts.app')

@section('content')
{{-- 1. Reemplaza 'container' por el contenedor típico de Tailwind/Breeze --}}
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Añade un fondo blanco y sombra para que se vea como una tarjeta --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            
            <h1 class="text-2xl font-bold mb-6 dark:text-gray-100">
                Editar Proyecto: {{ $project->name }}
            </h1>

            <form action="{{ route('projects.update', $project) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Campo Nombre --}}
                <div class="mb-4">
                    {{-- form-label -> block font-medium text-sm text-gray-700 --}}
                    <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                        Nombre del Proyecto
                    </label>
                    {{-- form-control -> utiliza las clases de input de Breeze/Jetstream --}}
                    <input type="text" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full @error('name') border-red-500 @enderror" id="name" name="name" value="{{ old('name', $project->name) }}" required>
                    @error('name')
                        {{-- invalid-feedback -> text-sm text-red-600 --}}
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Descripción --}}
                <div class="mb-4">
                    <label for="description" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                        Descripción
                    </label>
                    <textarea class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full @error('description') border-red-500 @enderror" id="description" name="description" rows="3">{{ old('description', $project->description) }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Herramientas (Checkboxes) --}}
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">Herramientas Utilizadas</label>
                    {{-- Reemplazamos 'border p-3' por 'space-y-2' --}}
                    <div class="space-y-2 p-3 border border-gray-300 dark:border-gray-700 rounded-md"> 
                        @foreach ($tools as $tool)
                            {{-- form-check form-check-inline -> flex items-center --}}
                            <div class="flex items-center"> 
                                <input type="checkbox" id="tool_{{ $tool->id }}" name="tools[]" value="{{ $tool->id }}"
                                        {{-- Clases de checkbox de Tailwind --}}
                                        class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                                        @checked(in_array($tool->id, old('tools', $selectedToolIds ?? [])))
                                >
                                {{-- form-check-label -> ms-2 text-sm text-gray-600 --}}
                                <label class="ms-2 text-sm text-gray-600 dark:text-gray-300" for="tool_{{ $tool->id }}">
                                    {{ $tool->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('tools')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones (Adaptando btn-primary y btn-secondary a las clases de Tailwind de Breeze) --}}
                <div class="flex items-center justify-start mt-4">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        Guardar Cambios
                    </button>
                    <a href="{{ route('projects.index') }}" class="ms-4 text-sm text-gray-600 dark:text-gray-400 leading-tight hover:text-gray-900 dark:hover:text-gray-100">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection