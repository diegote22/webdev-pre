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

    <!-- Scripts -->
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

<body class="font-sans antialiased">
    <div class="min-h-screen bg-base-200">
        @if (!empty($publicNav))
            @include('layouts.public-nav')
        @else
            @include('layouts.navigation')
        @endif

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-base-100 border-b border-base-300">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-base-content">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="{{ !empty($fullBleed) ? 'px-0' : 'container mx-auto px-4' }}">
            @hasSection('content')
                @yield('content')
            @else
                {{ $slot ?? '' }}
            @endif
        </main>
        <!-- Toasts globales -->
        @php($toastType = session('error') ? 'error' : (session('success') ? 'success' : (session('info') ? 'info' : (session('status') ? 'success' : null))))
        @if ($toastType)
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4500)" x-show="show" x-transition
                class="toast toast-end z-50">
                <div class="alert alert-{{ $toastType }}">
                    <span>{{ session('error') ?? (session('success') ?? (session('info') ?? session('status'))) }}</span>
                </div>
            </div>
        @endif


    </div>
</body>

</html>
