<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold text-gray-800">Bienvenido de Nuevo</h2>
        <p class="text-gray-500 mt-1">Inicia sesión para continuar</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Correo Electrónico" class="sr-only" />
            <x-text-input id="email"
                class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 p-3"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="Correo Electrónico" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Contraseña" class="sr-only" />
            <x-text-input id="password"
                class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 p-3"
                type="password" name="password" required autocomplete="current-password" placeholder="Contraseña" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Recuérdame') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-indigo-600 hover:text-indigo-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>

        <div>
            <x-primary-button class="w-full flex justify-center py-3 text-base">
                {{ __('Iniciar Sesión') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                ¿No tienes una cuenta?
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Regístrate aquí
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
