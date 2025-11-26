<x-guest-layout>
    <!-- Texto Descriptivo -->
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('¿Olvidaste tu contraseña? No hay problema. Simplemente indícanos tu dirección de correo electrónico y te enviaremos por email un enlace para restablecer la contraseña que te permitirá elegir una nueva.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <!-- Etiqueta: Correo electrónico -->
            <x-input-label for="email" :value="__('Correo electrónico')" /> 
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                <!-- Texto del botón: Enviar Enlace para Restablecer Contraseña -->
                {{ __('Enviar enlace para restablecer contraseña') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
