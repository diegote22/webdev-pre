<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WebDev-Pre') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, 'Helvetica Neue', Arial, 'Noto Sans', 'Apple Color Emoji', 'Segoe UI Emoji';
        }

        .glass {
            backdrop-filter: saturate(180%) blur(10px);
            background: rgba(255, 255, 255, 0.7);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <!-- Header -->
    <header class="sticky top-0 z-50 glass border-b border-gray-200">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="text-xl font-extrabold text-purple-700">WebDev-Pre</a>
            <div class="hidden md:flex items-center gap-6">
                <a href="#" class="text-gray-700 hover:text-purple-700">Salud</a>
                <a href="#" class="text-gray-700 hover:text-purple-700">Cursos</a>
                <a href="#" class="text-gray-700 hover:text-purple-700">Contacto</a>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2 text-sm font-medium text-white bg-purple-700 rounded-lg hover:bg-purple-800">Ir a
                        mi Panel</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cerrar
                            sesión</button>
                    </form>
                    <div
                        class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-semibold">
                        P</div>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Iniciar
                        Sesión</a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 text-sm font-medium text-white bg-purple-700 rounded-lg hover:bg-purple-800">Registrarse</a>
                @endauth
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="mt-16 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-lg font-bold text-gray-900">WebDev-Pre</h3>
                <p class="mt-2 text-gray-600">Potenciando tu futuro académico.</p>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Enlaces</h4>
                <ul class="mt-3 space-y-2 text-gray-600">
                    <li><a class="hover:text-gray-900" href="#">Salud</a></li>
                    <li><a class="hover:text-gray-900" href="#">Cursos</a></li>
                    <li><a class="hover:text-gray-900" href="#">Contacto</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Legal</h4>
                <ul class="mt-3 space-y-2 text-gray-600">
                    <li><a class="hover:text-gray-900" href="#">Privacidad</a></li>
                    <li><a class="hover:text-gray-900" href="#">Términos</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-200 py-6 text-center text-sm text-gray-500">
            © {{ date('Y') }} WebDev-Pre. Todos los derechos reservados.
        </div>
    </footer>
</body>

</html>
