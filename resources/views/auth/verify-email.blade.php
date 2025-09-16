<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        ¡Gracias por registrarte! Antes de comenzar, por favor verifica tu Email haciendo clic en el enlace que te
        enviamos. Si no recibiste el Email, podemos enviarte otro.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            Se ha enviado un nuevo enlace de verificación al Email que proporcionaste durante el registro.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    Reenviar Email de verificación
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                Cerrar sesión
            </button>
        </form>
    </div>
</x-guest-layout>
