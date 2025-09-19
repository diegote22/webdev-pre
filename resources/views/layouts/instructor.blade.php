<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Slabo+27px&family=PT+Sans:wght@400;700&family=Roboto:wght@300;400;500;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Configuración de tipografías */
        body {
            font-family: 'Roboto', sans-serif;
        }

        /* Logo/Marca principal con Slabo 27px */
        .logo-font {
            font-family: 'Slabo 27px', serif;
        }

        /* Títulos y subtítulos con PT Sans */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .heading-font {
            font-family: 'PT Sans', sans-serif;
        }

        /* Textos generales con Roboto */
        p,
        span,
        div,
        a,
        button,
        .text-font {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                {{ $header ?? '' }}
            </div>
        </header>
        <main>
            {{ $slot }}
        </main>
        <footer class="py-6 text-center text-sm text-gray-500">Instructor</footer>
    </div>
    @stack('js')
</body>

</html>
