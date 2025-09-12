<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold text-gray-800">Crea tu Cuenta</h2>
        <p class="text-gray-500 mt-1">Únete a nuestra comunidad</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nombre Completo" class="sr-only" />
            <x-text-input id="name"
                class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 p-3"
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                placeholder="Nombre Completo" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Correo Electrónico" class="sr-only" />
            <x-text-input id="email"
                class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 p-3"
                type="email" name="email" :value="old('email')" required autocomplete="username"
                placeholder="Correo Electrónico" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Contraseña" class="sr-only" />
            <x-text-input id="password"
                class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 p-3"
                type="password" name="password" required autocomplete="new-password" placeholder="Contraseña" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" value="Confirmar Contraseña" class="sr-only" />
            <x-text-input id="password_confirmation"
                class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 p-3"
                type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="Confirmar Contraseña" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <x-primary-button class="w-full flex justify-center py-3 text-base">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Inicia sesión aquí
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
