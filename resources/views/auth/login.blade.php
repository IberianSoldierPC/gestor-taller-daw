<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'Laravel') }} | Iniciar Sesión</title>

    <!-- Google Font 'Instrument Sans' -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Assets de Vite -->@vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Estilos de video de fondo y superposición -->
    <style>
        /* El video cubre todo el viewport */
        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -10;
            /* Detrás de todo */
        }

        /* Superposición para legibilidad */
        .video-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            /* Oscurecimiento general */
            z-index: -9;
        }

        .dark .video-overlay {
            background-color: rgba(0, 0, 0, 0.6);
            /* Más oscuro en modo noche */
        }

        /* Sombra con elevación al pasar el ratón */
        .card-shadow-hover:hover {
            box-shadow: 0 15px 30px -10px rgba(234, 88, 12, 0.2);
            transform: translateY(-2px);
        }
    </style>
</head>

{{-- Fuente global y padding --}}

<body class="font-['Instrument_Sans'] text-[#1b1b18] dark:text-[#EDEDEC] flex p-6 lg:p-12 items-center lg:justify-center min-h-screen flex-col">

    <!-- Video de fondo --><video playsinline autoplay muted loop class="video-background">
        <source src="https://assets.mixkit.co/videos/44862/44862-720.mp4" type="video/mp4">
        Tu navegador no soporta el tag de video.
    </video>

    <!-- Capa de superposición para legibilidad -->
    <div class="video-overlay"></div>

    {{-- Header simple --}}
    <header class="w-full lg:max-w-6xl max-w-[335px] text-base mb-6 relative z-10">
        <nav class="flex items-center justify-end gap-4">
            @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="inline-block px-5 py-2 backdrop-blur-sm bg-white/20 text-white border-white/40 hover:border-white/70 border rounded-lg font-medium leading-normal transition-all duration-300">
                Registrarse
            </a>
            @endif
            <a
                href="{{ url('/') }}"
                class="inline-block px-5 py-2 backdrop-blur-sm bg-white/20 text-white border-white/40 hover:border-white/70 border rounded-lg font-medium leading-normal transition-all duration-300">
                Volver a Inicio
            </a>
        </nav>
    </header>

    <div class="flex items-center justify-center w-full lg:grow relative z-10">
        <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row shadow-2xl rounded-lg">

            {{-- Panel de login --}}
            <div class="flex-1 p-6 pb-12 lg:p-16 bg-white/95 dark:bg-[#161615]/95 dark:text-[#EDEDEC] backdrop-blur-sm shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-bl-lg rounded-br-lg lg:rounded-tl-lg lg:rounded-br-none card-shadow-hover transition-all duration-500">

                {{-- Título principal --}}
                <h2 class="text-4xl lg:text-5xl font-extrabold text-orange-600 dark:text-amber-400 mb-8 text-center leading-tight">
                    Acceso al <br class="lg:hidden">Taller Digital
                </h2>

                <!-- Session Status --><x-auth-session-status class="mb-4 text-sm font-medium" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Correo electrónico -->
                    <div>
                        {{-- Etiqueta ligeramente más grande --}}
                        <x-input-label for="email" :value="__('Correo electrónico')" class="text-base font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-1" />
                        <x-text-input
                            id="email"
                            class="block mt-1 w-full border-gray-300 dark:border-[#3E3E3A] dark:bg-[#1f1f1e] rounded-lg shadow-sm focus:border-orange-500 dark:focus:border-amber-400 focus:ring-orange-500 dark:focus:ring-amber-400 text-base" {{-- Tamaño de texto del input --}}
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                            autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Contraseña -->
                    <div>
                        {{-- Etiqueta ligeramente más grande --}}
                        <x-input-label for="password" :value="__('Contraseña')" class="text-base font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-1" />

                        <x-text-input
                            id="password"
                            class="block mt-1 w-full border-gray-300 dark:border-[#3E3E3A] dark:bg-[#1f1f1e] rounded-lg shadow-sm focus:border-orange-500 dark:focus:border-amber-400 focus:ring-orange-500 dark:focus:ring-amber-400 text-base" {{-- Tamaño de texto del input --}}
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Recordarme -->
                    <div class="block">
                        <label for="remember_me" class="inline-flex items-center">
                            <input
                                id="remember_me"
                                type="checkbox"
                                class="rounded dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-orange-600 shadow-sm focus:ring-orange-500 dark:focus:ring-orange-600 w-4 h-4" {{-- Tamaño del checkbox --}}
                                name="remember">
                            <span class="ms-2 text-base text-gray-700 dark:text-gray-300">{{ __('Recordarme') }}</span> {{-- Tamaño de texto --}}
                        </label>
                    </div>

                    <div class="flex items-center justify-between pt-4">
                        @if (Route::has('password.request'))
                        <a class="text-base underline text-orange-600 dark:text-amber-400 hover:text-orange-700 dark:hover:text-amber-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                            {{ __('¿Olvidaste tu contraseña, manitas?') }}
                        </a>
                        @endif

                        <x-primary-button
                            class="inline-flex items-center px-6 py-3 bg-orange-600 border border-transparent rounded-lg font-semibold text-base text-white uppercase tracking-wider hover:bg-orange-700 focus:bg-orange-700 active:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-amber-600 dark:hover:bg-amber-700 dark:active:bg-amber-800 dark:focus:ring-amber-500">
                            {{ __('¡Entrar!') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            {{-- BLOQUE DE PROMOCIÓN LATERAL (Derecha) --}}
            <div class="w-full lg:w-[350px] lg:shrink-0 lg:ml-0 flex items-center justify-center aspect-[335/376] lg:aspect-auto p-6 lg:p-0 bg-stone-200/90 dark:bg-[#1D0002]/90 rounded-t-lg lg:rounded-t-none lg:rounded-r-lg backdrop-blur-sm">
                <div class="text-orange-700 dark:text-amber-300 text-center p-4">
                    {{-- Icono de Candado/Seguridad --}}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-28 h-28 mx-auto mb-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                    </svg>
                    <p class="font-bold text-2xl text-gray-800 dark:text-[#EDEDEC]"> {{-- Texto más grande y negrita --}}
                        Accede a tu proyecto
                    </p>
                    <br>
                    <p class="text-lg mt-1 text-gray-600 dark:text-[#A1A09A]"> {{-- Texto más grande --}}
                        Aquí es donde la gestión de herramientas se pone seria. ¡Tu inventario te espera!
                    </p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
