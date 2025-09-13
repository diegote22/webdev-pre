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
    <script>
        (function(){
            try {
                const stored = localStorage.getItem('theme');
                const def = stored ? stored : (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
                const root = document.documentElement;
                root.setAttribute('data-theme', def);
                // Activar variantes dark: de Tailwind (por clase)
                if(def === 'dark') root.classList.add('dark'); else root.classList.remove('dark');
            } catch (e) {}
        })();
    </script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-gray-100 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-black dark:text-white">
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

        <!-- Toast para cambios de tema (cliente) -->
        <div x-data="{ show:false, msg:'', type:'info', notify(theme){ this.msg = theme==='dark' ? 'Tema: oscuro' : 'Tema: claro'; this.type='info'; this.show = true; setTimeout(()=> this.show=false, 2000) } }"
             x-on:theme-changed.window="notify($event.detail)"
             x-show="show" x-transition
             class="toast toast-end z-50">
            <div class="alert alert-info">
                <span x-text="msg"></span>
            </div>
        </div>
    </div>
</body>

</html>
