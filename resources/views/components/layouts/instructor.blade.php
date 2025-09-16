<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
    <style>
        [x-cloak] {
            display: none !important
        }
    </style>
    <script>
        document.documentElement.classList.add('js')
    </script>
    <script defer>
        window.__theme = 'light'
    </script>
</head>

<body class="font-sans antialiased bg-base-200 text-base-content">
    <div class="min-h-screen">
        <header class="bg-base-100 border-b border-base-300">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                {{ $header ?? '' }}
            </div>
        </header>
        <main>
            {{ $slot }}
        </main>
        @php($toastType = session('error') ? 'error' : (session('success') ? 'success' : (session('info') ? 'info' : (session('status') ? 'success' : null))))
        @if ($toastType)
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4500)" x-show="show" x-transition
                class="toast toast-end z-50">
                <div class="alert alert-{{ $toastType }}">
                    <span>{{ session('error') ?? (session('success') ?? (session('info') ?? session('status'))) }}</span>
                </div>
            </div>
        @endif
        <footer class="py-6 text-center text-sm opacity-70">Instructor</footer>
    </div>
    @stack('js')
</body>

</html>
