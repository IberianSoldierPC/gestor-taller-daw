<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inventario de herramientas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Mensaje de Estado (Éxito) --}}
            @if (session('status'))
                <div id="flash-status" class="bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded-2xl relative mb-6 shadow-md transition-opacity duration-700" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                        <button type="button" id="flash-close" aria-label="Cerrar aviso" class="absolute top-2 right-2 text-green-700 dark:text-green-400 hover:text-green-900 dark:hover:text-green-200 font-bold">×</button>
                    </div>
                <script>
                    // Auto-ocultar aviso de estado en herramientas
                    setTimeout(() => {
                        const el = document.getElementById('flash-status');
                        if (el) {
                            el.style.opacity = '0';
                            setTimeout(() => el.remove(), 800);
                        }
                    }, 3000);
                        // Cierre manual del aviso
                        document.getElementById('flash-close')?.addEventListener('click', () => {
                            const el = document.getElementById('flash-status');
                            if (el) el.remove();
                        });
                </script>
            @endif

            {{-- Tarjetas de estadísticas --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                {{-- Total de herramientas --}}
                <div class="bg-white dark:bg-gray-700 p-6 rounded-2xl shadow-xl border-l-4 border-orange-500 dark:border-amber-400 transition hover:shadow-2xl">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total registradas</p>
                    <p class="text-4xl font-extrabold text-gray-900 dark:text-gray-50 mt-1">
                        {{ $totalTools ?? 0 }}
                    </p>
                </div>

                {{-- Disponibles --}}
                <div class="bg-white dark:bg-gray-700 p-6 rounded-2xl shadow-xl border-l-4 border-green-500 transition hover:shadow-2xl">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Disponibles</p>
                    <p class="text-4xl font-extrabold text-gray-900 dark:text-gray-50 mt-1">
                        {{ $availableTools ?? 0 }}
                    </p>
                </div>

                {{-- En uso --}}
                <div class="bg-white dark:bg-gray-700 p-6 rounded-2xl shadow-xl border-l-4 border-yellow-500 transition hover:shadow-2xl">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">En uso</p>
                    <p class="text-4xl font-extrabold text-gray-900 dark:text-gray-50 mt-1">
                        {{ $inUseTools ?? 0 }}
                    </p>
                </div>

                {{-- En mantenimiento --}}
                <div class="bg-white dark:bg-gray-700 p-6 rounded-2xl shadow-xl border-l-4 border-red-500 transition hover:shadow-2xl">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">En mantenimiento</p>
                    <p class="text-4xl font-extrabold text-gray-900 dark:text-gray-50 mt-1">
                        {{ $maintenanceTools ?? 0 }}
                    </p>
                </div>

            </div>
            {{-- Fin estadísticas --}}

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-6 text-gray-900 dark:text-gray-200">

                    <div class="flex justify-between items-center mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                        <!-- Título -->
                        <p class="text-2xl font-extrabold text-orange-600 dark:text-amber-400">Listado de herramientas</p>
                        <!-- Botón principal -->
                        <a href="{{ route('tools.create') }}" class="bg-orange-600 hover:bg-orange-700 dark:bg-amber-500 dark:hover:bg-amber-600 text-white font-bold py-2 px-4 rounded-xl shadow-md transition duration-150 ease-in-out transform hover:scale-105">
                            Añadir nueva herramienta
                        </a>
                    </div>

                    <form method="GET" action="{{ route('tools.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label for="q" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Buscar por nombre</label>
                            <input id="q" type="text" name="q" value="{{ request('q') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200" placeholder="ej. Taladro, Llave...">
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                                <option value="">Todos</option>
                                @foreach(($statuses ?? []) as $st)
                                    <option value="{{ $st }}" @selected(request('status')===$st)>{{ $st }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Orden</label>
                            <select id="sort" name="sort" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                                <option value="created" @selected(request('sort')==='created' || !request()->has('sort'))>Más recientes primero</option>
                                <option value="alpha" @selected(request('sort')==='alpha')>Alfabético (A→Z)</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="bg-orange-600 hover:bg-orange-700 dark:bg-amber-500 dark:hover:bg-amber-600 text-white font-bold py-2 px-4 rounded-xl shadow-md">Filtrar</button>
                            <a href="{{ route('tools.index') }}" class="ml-3 text-gray-600 dark:text-gray-300 hover:underline">Limpiar</a>
                        </div>
                        @if(($users ?? collect())->isNotEmpty())
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Asignado a (solo admin)</label>
                            <select id="user_id" name="user_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                                <option value="">Todos</option>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}" @selected(request('user_id')==$u->id)>{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tl-xl">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ubicación</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Asignado a</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tr-xl">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                {{-- Mapa de colores para estados --}}
                                @php
                                    // Span oculto para asegurar la compilación
                                    echo '<span class="hidden bg-green-100 text-green-800 bg-red-100 text-red-800 bg-yellow-100 text-yellow-800 dark:bg-green-900 dark:text-green-300 dark:bg-red-900 dark:text-red-300 dark:bg-yellow-900 dark:text-yellow-300"></span>';

                                    $statusColors = [
                                        'Disponible'    => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'dark_bg' => 'dark:bg-green-900', 'dark_text' => 'dark:text-green-300'],
                                        'En uso'        => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'dark_bg' => 'dark:bg-yellow-900', 'dark_text' => 'dark:text-yellow-300'],
                                        'Mantenimiento' => ['bg' => 'bg-red-100',   'text' => 'text-red-800',   'dark_bg' => 'dark:bg-red-900',   'dark_text' => 'dark:text-red-300'],
                                    ];
                                @endphp

                                @forelse ($tools as $tool)
                                    @php
                                        $color = $statusColors[$tool->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'dark_bg' => 'dark:bg-gray-700', 'dark_text' => 'dark:text-gray-300'];
                                    @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200 relative group">
                                        <span>{{ $tool->name }}</span>
                                        @php $desc = trim((string)($tool->description ?? '')); @endphp
                                        @if ($desc !== '')
                                        <!-- Tooltip descripción -->
                                        <span class="pointer-events-none absolute left-0 top-full mt-2 w-64 max-w-xs px-3 py-2 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-xs text-gray-700 dark:text-gray-200 opacity-0 group-hover:opacity-100 transition duration-150 z-30 whitespace-normal break-words max-h-40 overflow-y-auto">
                                            {{ $desc }}
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">{{ $tool->location }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- Badge: px-3 py-1 --}}
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color['bg'] }} {{ $color['text'] }} {{ $color['dark_bg'] }} {{ $color['dark_text'] }}">
                                            {{ $tool->status }}
                                        </span>
                                    </td>
                                    {{-- Usuario asignado --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">
                                        @if(!empty($tool->user_id) && isset($tool->user))
                                            {{ $tool->user->name }}
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-700/40 text-gray-700 dark:text-gray-300">No asignado</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                        <span class="inline-flex justify-center space-x-4">
                                            <!-- Botón Editar -->
                                            <a href="{{ route('tools.edit', $tool->id) }}" class="text-orange-600 dark:text-amber-400 hover:text-orange-800 dark:hover:text-amber-300 font-bold transition duration-150">Editar</a>

                                            <!-- Botón eliminar -->
                                            <button
                                                type="button"
                                                class="text-red-600 hover:text-red-800 font-bold transition duration-150 delete-tool-btn"
                                                title="Borrar herramienta"
                                                data-delete-url="{{ route('tools.destroy', $tool->id) }}"
                                                data-tool-name="{{ $tool->name }}"
                                            >
                                                Borrar
                                            </button>
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 italic">No hay herramientas registradas en el inventario.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginación --}}
                    @if (isset($tools) && method_exists($tools, 'hasPages') && $tools->hasPages())
                        <div class="mt-6 p-4 border-t-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-b-lg">
                            {{ $tools->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación de eliminación de herramienta -->
    <div id="deleteToolModal" class="fixed inset-0 bg-gray-600 dark:bg-gray-900 bg-opacity-50 dark:bg-opacity-75 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border-2 border-gray-300 dark:border-gray-600 w-96 shadow-2xl rounded-xl bg-white dark:bg-gray-800 transform transition-all duration-300">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 dark:bg-red-900/30 border-2 border-red-300 dark:border-red-700 mb-4">
                    <svg class="h-8 w-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.503-1.65 1.777-3.094L13.79 4.383c-.727-1.444-2.827-1.444-3.554 0L3.58 17.906c-.726 1.444.247 3.094 1.777 3.094z"></path>
                    </svg>
                </div>
                <h3 class="text-xl leading-6 font-extrabold text-gray-900 dark:text-white mt-2">Eliminar herramienta</h3>
                <div class="mt-4 px-2 py-3 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-700/30">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        ¿Eliminar la herramienta "<strong id="toolNameDisplay" class="font-semibold text-gray-700 dark:text-gray-300"></strong>"? Esta acción no se puede deshacer.
                    </p>
                </div>
                <div class="items-center px-4 py-3 flex justify-end space-x-3 border-t border-gray-200 dark:border-gray-700 mt-4">
                    <button id="cancelDeleteToolBtn" class="flex-1 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-base font-medium rounded-lg shadow-sm hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50 transition duration-150 border border-gray-300 dark:border-gray-600">
                        Cancelar
                    </button>
                    <form id="deleteToolForm" method="POST" class="inline flex-1">
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
        // Abrir modal de eliminación
        document.querySelectorAll('.delete-tool-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const url = btn.getAttribute('data-delete-url');
                const name = btn.getAttribute('data-tool-name');
                document.getElementById('toolNameDisplay').textContent = name;
                document.getElementById('deleteToolForm').setAttribute('action', url);
                document.getElementById('deleteToolModal').classList.remove('hidden');
            });
        });
        // Cerrar modal
        document.getElementById('cancelDeleteToolBtn').addEventListener('click', () => {
            document.getElementById('deleteToolModal').classList.add('hidden');
        });

        // Confirmación de edición en herramientas
        document.querySelectorAll('form[action*="tools/"]').forEach(form => {
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput && methodInput.value.toUpperCase() === 'PUT') {
                form.addEventListener('submit', (e) => {
                    const ok = window.confirm('¿Confirmas la actualización de la herramienta?');
                    if (!ok) e.preventDefault();
                });
            }
        });
    </script>
</x-app-layout>
