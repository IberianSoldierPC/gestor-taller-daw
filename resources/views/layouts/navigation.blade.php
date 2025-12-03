<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

    <!-- Menú principal de navegación -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative flex justify-between h-16">
            <!-- Logo centrado -->
            <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-none">
                <a href="{{ route('dashboard') }}" class="pointer-events-auto">
                    <!-- Logo con color de acento -->
                    <x-application-logo class="block h-9 w-auto fill-current text-orange-600 dark:text-amber-400" />
                </a>
            </div>

            <div class="flex items-center">

                <!-- Enlaces de navegación -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-8 sm:flex">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="font-semibold text-base hover:text-orange-600 dark:hover:text-amber-400 transition duration-150 ease-in-out">
                        🏠 {{ __('Panel') }}
                    </x-nav-link>

                    <x-nav-link :href="route('tools.index')" :active="request()->routeIs('tools.*')"
                        class="font-semibold text-base hover:text-orange-600 dark:hover:text-amber-400 transition duration-150 ease-in-out">
                        🔧 {{ __('Herramientas') }}
                    </x-nav-link>

                    <!-- Enlace a proyectos -->
                    <x-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.*')"
                        class="font-semibold text-base hover:text-orange-600 dark:hover:text-amber-400 transition duration-150 ease-in-out">
                        📁 {{ __('Proyectos') }}
                    </x-nav-link>

                    @if(auth()->user() && auth()->user()->role === 'admin')
                    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')"
                        class="font-semibold text-base hover:text-orange-600 dark:hover:text-amber-400 transition duration-150 ease-in-out">
                        👥 {{ __('Gestión usuarios') }}
                    </x-nav-link>
                    @endif

                    {{-- Enlace a colaboradores (pendiente de ruta) --}}
                    {{-- <x-nav-link :href="route('collaborators.index')" :active="request()->routeIs('collaborators.*')"
                        class="font-semibold text-base hover:text-orange-600 dark:hover:text-amber-400 transition duration-150 ease-in-out">
                        {{ __('Colaboradores') }}
                    </x-nav-link> --}}

                </div>
            </div>

            <!-- Menú de ajustes -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="me-4">
                    <x-theme-toggle />
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <!-- Botón de perfil -->
                        <button class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-4 font-semibold rounded-xl text-gray-700 dark:text-gray-300 bg-gray-100/70 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none transition ease-in-out duration-150 shadow-md">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onkeydown="if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); this.closest('form').submit(); }"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                class="text-red-500 hover:bg-red-100 dark:text-red-400 dark:hover:bg-red-900/40">
                                {{ __('Cerrar sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Botón móvil -->
            <div class="-me-2 flex items-center sm:hidden">
                <x-theme-toggle />
                
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-orange-500 dark:hover:text-amber-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700/50 focus:text-orange-500 dark:focus:text-amber-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Navegación responsive -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <!-- Enlaces responsive -->
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="hover:text-orange-600 dark:hover:text-amber-400">
                🏠 {{ __('Panel') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tools.index')" :active="request()->routeIs('tools.*')" class="hover:text-orange-600 dark:hover:text-amber-400">
                🔧 {{ __('Herramientas') }}
            </x-responsive-nav-link>
            <!-- Enlace móvil a proyectos -->
            <x-responsive-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.*')" class="hover:text-orange-600 dark:hover:text-amber-400">
                📁 {{ __('Proyectos') }}
            </x-responsive-nav-link>
                @if(auth()->user() && auth()->user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="hover:text-orange-600 dark:hover:text-amber-400">
                    👥 {{ __('Gestión usuarios') }}
                </x-responsive-nav-link>
                @endif
            {{-- Temporalmente comentado hasta que se defina la ruta 'collaborators.index' --}}
            {{-- <x-responsive-nav-link :href="route('collaborators.index')" :active="request()->routeIs('collaborators.*')" class="hover:text-orange-600 dark:hover:text-amber-400">
                {{ __('Colaboradores') }}
            </x-responsive-nav-link> --}}
        </div>

        <!-- Opciones de ajustes responsive -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-semibold text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="hover:text-orange-600 dark:hover:text-amber-400">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onkeydown="if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); this.closest('form').submit(); }"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();"
                        class="text-red-500 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/50">
                        {{ __('Cerrar sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
