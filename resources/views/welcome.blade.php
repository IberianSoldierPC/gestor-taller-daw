<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'Gestor Taller') }} | Plataforma del Taller</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800&display=swap" rel="stylesheet" />


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Estilos para video de fondo y superposición -->
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
        }

        /* Superposición para mejorar la legibilidad */
        .video-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: -9;
        }
        .dark .video-overlay {
            background-color: rgba(0, 0, 0, 0.6);
        }
        
        /* Sombra para las tarjetas */
        .card-shadow-hover:hover {
            box-shadow: 0 15px 30px -10px rgba(234, 88, 12, 0.2);
            transform: translateY(-2px);
        }
    </style>
</head>

{{-- Nota: el video hace de fondo --}}
<body class="font-['Instrument_Sans'] text-[#1b1b18] dark:text-[#EDEDEC] flex p-6 lg:p-12 items-center lg:justify-center min-h-screen flex-col">
    
    <!-- Video de fondo -->
    <video playsinline autoplay muted loop class="video-background">
        <source src="https://assets.mixkit.co/videos/44862/44862-720.mp4" type="video/mp4">
        Tu navegador no soporta el tag de video.
    </video>
    
    <!-- Capa de superposición para legibilidad -->
    <div class="video-overlay"></div>

    <header class="w-full lg:max-w-6xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden relative z-10">
        @if (Route::has('login'))
        <nav class="flex items-center justify-end gap-4">
            @auth
            <a
                href="{{ url('/dashboard') }}"
                class="inline-block px-5 py-1.5 backdrop-blur-sm bg-white/20 text-white border-white/40 hover:border-white/70 border rounded-lg text-sm leading-normal transition-all duration-300">
                Dashboard
            </a>
            @else
            <a
                href="{{ route('login') }}"
                class="inline-block px-5 py-1.5 font-semibold text-white bg-orange-600 rounded-lg text-sm leading-normal hover:bg-orange-700 transition-all duration-300 shadow-md">
                Acceder
            </a>

            @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="inline-block px-5 py-1.5 backdrop-blur-sm bg-white/20 text-white border-white/40 hover:border-white/70 border rounded-lg text-sm leading-normal transition-all duration-300">
                Registrarse
            </a>
            @endif
            @endauth
        </nav>
        @endif
    </header>

    <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0 relative z-10">
        <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-6xl lg:flex-row shadow-2xl rounded-lg">

            {{-- Contenido principal --}}
            <div class="text-[13px] leading-[20px] flex-1 p-6 pb-12 lg:p-24 bg-white/95 dark:bg-[#161615]/95 dark:text-[#EDEDEC] backdrop-blur-sm shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-bl-lg rounded-br-lg lg:rounded-tl-lg lg:rounded-br-none card-shadow-hover transition-all duration-500">

                <div class="mb-8 text-center">
                    <div class="flex items-center mb-2 space-x-3 justify-center">
                        <span class="text-3xl text-orange-600 dark:text-amber-400">
                            {{-- Icono de herramienta --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                            </svg>
                        </span>
                        <h1 class="text-3xl lg:text-4xl font-extrabold text-[#1b1b18] dark:text-[#EDEDEC]">
                            Gestor de Taller e Inventario
                        </h1>
                    </div>
                    <p class="text-lg text-[#706f6c] dark:text-[#A1A09A] mt-2">
                        Controla tu inventario y proyectos del taller.
                    </p>
                </div>

                <!-- Separador -->
                <hr class="border-t border-gray-200 dark:border-[#3E3E3A] mb-8">

                <!-- Sección de valor -->
                <div class="mb-10 space-y-4">
                    <h2 class="text-xl font-bold text-orange-700 dark:text-amber-400">
                        Centraliza y optimiza tu trabajo
                    </h2>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <span class="text-orange-500 dark:text-amber-300 mr-2 mt-0.5 pt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>
                            </span>
                            <p class="text-base text-[#1b1b18] dark:text-[#EDEDEC]">
                                <strong class="font-semibold">Inventario Digital:</strong> Registra cada herramienta con sus detalles y ubicación.
                            </p>
                        </li>
                        <li class="flex items-start">
                            <span class="text-orange-500 dark:text-amber-300 mr-2 mt-0.5 pt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <p class="text-base text-[#1b1b18] dark:text-[#EDEDEC]">
                                <strong class="font-semibold">Control de Estado:</strong> Sigue si está 'Operativa', 'Prestada' o en 'Mantenimiento'.
                            </p>
                        </li>
                        <li class="flex items-start">
                            <span class="text-orange-500 dark:text-amber-300 mr-2 mt-0.5 pt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                            </span>
                            <p class="text-base text-[#1b1b18] dark:text-[#EDEDEC]">
                                <strong class="font-semibold">Asignación de Usuarios:</strong> Asigna recursos a responsables y proyectos.
                            </p>
                        </li>
                    </ul>
                </div>

                <!-- CTA principal -->
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-[#3E3E3A]">
                    <h3 class="text-xl font-bold mb-6 text-gray-800 dark:text-[#EDEDEC] text-center">
                        ¿Listo para empezar?
                    </h3>
                    <a
                        href="{{ Route::has('login') ? route('login') : url('/') }}"
                        class="inline-flex items-center text-center justify-center w-full px-6 py-3 text-base font-bold text-white bg-orange-600 rounded-lg shadow-lg hover:bg-orange-700 dark:bg-amber-600 dark:hover:bg-amber-700 transition transform hover:scale-[1.01] duration-300">
                        ACCEDER Y GESTIONAR MI INVENTARIO
                    </a>
                </div>
            </div>

            {{-- Bloque de imagen lateral --}}
            <div class="w-full lg:w-[438px] lg:shrink-0 lg:ml-0 lg:p-8 flex items-center justify-center aspect-[335/376] lg:aspect-auto p-6 lg:p-0 bg-stone-200/90 dark:bg-[#1D0002]/90 rounded-t-lg lg:rounded-t-none lg:rounded-r-lg backdrop-blur-sm">
                <div class="text-orange-700 dark:text-amber-300 text-center p-4">
                    {{-- Icono de inventario --}}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-24 h-24 mx-auto mb-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                    </svg>
                    <p class="font-bold text-xl">Visión general del inventario</p>
                    <br>
                    <p class="text-base mt-1">Herramientas en un vistazo, listas para tu proyecto.</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
