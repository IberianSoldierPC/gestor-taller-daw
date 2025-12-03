<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200" required>
                                @error('name')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200" required>
                                @error('email')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rol</label>
                                <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200" required>
                                    <option value="employee" @selected(old('role', $user->role)==='employee')>Empleado</option>
                                    <option value="admin" @selected(old('role', $user->role)==='admin')>Admin</option>
                                </select>
                                @error('role')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-md border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300">Cancelar</a>
                            <button type="submit" class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
