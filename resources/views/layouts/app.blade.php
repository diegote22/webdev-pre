<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-base-200">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-base-100 border-b border-base-300">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-base-content">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="container mx-auto px-4">
            {{ $slot }}
        </main>
        <!-- Toasts globales -->
        @php($toastType = session('error') ? 'error' : (session('success') ? 'success' : (session('info') ? 'info' : (session('status') ? 'success' : null))))
        @if($toastType)
            <div x-data="{ show: true }" x-init="setTimeout(()=>show=false, 4500)" x-show="show" x-transition
                 class="toast toast-end z-50">
                <div class="alert alert-{{ $toastType }}">
                    <span>{{ session('error') ?? session('success') ?? session('info') ?? session('status') }}</span>
                </div>
            </div>
        @endif


    </div>
</body>

</html>
