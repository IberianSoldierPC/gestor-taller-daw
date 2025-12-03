<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                        <p class="text-2xl font-extrabold text-orange-600 dark:text-amber-400">Usuarios</p>
                        <form method="GET" class="flex gap-2">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar por nombre o email" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                            <button class="bg-orange-600 hover:bg-orange-700 dark:bg-amber-500 dark:hover:bg-amber-600 text-white font-bold py-2 px-4 rounded-xl shadow-md">Buscar</button>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rol</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($users as $user)
                                <tr>
                                    <td class="px-6 py-4">{{ $user->name }}</td>
                                    <td class="px-6 py-4">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $roleLabel = $user->role === 'admin' ? 'Admin' : 'Empleado';
                                        @endphp
                                        {{ $roleLabel }}
                                    </td>
                                    <td class="px-6 py-4 flex items-center gap-4">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-orange-600 dark:text-amber-400 hover:underline">Editar</a>
                                        <button
                                            type="button"
                                            class="text-red-600 dark:text-red-400 hover:underline delete-user-btn"
                                            data-delete-url="{{ route('admin.users.destroy', $user) }}"
                                            data-user-name="{{ $user->name }}"
                                        >Borrar</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-6 text-center text-gray-500">Sin usuarios.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($users->hasPages())
                    <div class="mt-6">{{ $users->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<!-- Modal de confirmación de eliminación de usuario -->
<div id="deleteUserModal" class="fixed inset-0 bg-gray-600 dark:bg-gray-900 bg-opacity-50 dark:bg-opacity-75 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border-2 border-gray-300 dark:border-gray-600 w-96 shadow-2xl rounded-xl bg-white dark:bg-gray-800 transform transition-all duration-300">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 dark:bg-red-900/30 border-2 border-red-300 dark:border-red-700 mb-4">
                <svg class="h-8 w-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.503-1.65 1.777-3.094L13.79 4.383c-.727-1.444-2.827-1.444-3.554 0L3.58 17.906c-.726 1.444.247 3.094 1.777 3.094z"></path>
                </svg>
            </div>
            <h3 class="text-xl leading-6 font-extrabold text-gray-900 dark:text-white mt-2">Eliminar usuario</h3>
            <div class="mt-4 px-2 py-3 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-700/30">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    ¿Eliminar el usuario "<strong id="userNameDisplay" class="font-semibold text-gray-700 dark:text-gray-300"></strong>"? Esta acción no se puede deshacer.
                </p>
            </div>
            <div class="items-center px-4 py-3 flex justify-end space-x-3 border-t border-gray-200 dark:border-gray-700 mt-4">
                <button id="cancelDeleteUserBtn" class="flex-1 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-base font-medium rounded-lg shadow-sm hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50 transition duration-150 border border-gray-300 dark:border-gray-600">
                    Cancelar
                </button>
                <form id="deleteUserForm" method="POST" class="inline flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 dark:bg-red-700 text-white text-base font-medium rounded-lg shadow-sm hover:bg-red-700 dark:hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-150 border border-red-700 dark:border-red-600">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('deleteUserModal');
        const deleteButtons = document.querySelectorAll('.delete-user-btn');
        const form = document.getElementById('deleteUserForm');
        const userNameDisplay = document.getElementById('userNameDisplay');
        const cancelButton = document.getElementById('cancelDeleteUserBtn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const userName = this.getAttribute('data-user-name');
                const deleteUrl = this.getAttribute('data-delete-url');
                form.action = deleteUrl;
                userNameDisplay.textContent = userName;
                modal.classList.remove('hidden');
            });
        });

        cancelButton.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
</script>
