@php
    use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WebDev-Pre - Tu Futuro Empieza Hoy</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Animación para la marquesina de textos */
        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .animate-scroll {
            animation: scroll 30s linear infinite;
            will-change: transform;
        }

        /* Invertir sentido al hacer hover sobre el contenedor */
        .marquee:hover .animate-scroll {
            animation-direction: reverse;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- =========== Header =========== -->
    <div class="navbar bg-base-100 shadow-sm sticky top-0 z-50">
        <!-- Logo/Brand -->
        <div class="navbar-start">
            <a href="/" class="btn btn-ghost text-xl font-bold text-primary gap-2 items-center">
                <img src="{{ asset('img/webdev.png') }}" alt="WebDev-Pre" class="h-8 w-auto" loading="lazy" />
                <span class="hidden sm:inline">WebDev-Pre</span>
            </a>
        </div>

        <!-- Navigation Menu (Desktop) -->
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1 gap-2">
                <li><a href="#secundaria" class="btn btn-ghost">Secundaria</a></li>
                <li><a href="#pre-universitario" class="btn btn-ghost">Pre-Universitario</a></li>
                <li><a href="#universitario" class="btn btn-ghost">Universitario</a></li>
                <li><a href="#nosotros" class="btn btn-ghost">Nosotros</a></li>
                <li><a href="#preguntas" class="btn btn-ghost">Preguntas</a></li>
            </ul>
        </div>

        <!-- Right Side - Auth buttons + Avatar P -->
        <div class="navbar-end">
            <div class="flex gap-2 items-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Ir a mi Panel</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="btn btn-ghost"
                            onclick="event.preventDefault(); this.closest('form').submit();">Cerrar sesión</a>
                    </form>
                    <div class="relative">
                        <div
                            class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-semibold">
                            P</div>
                        @php
                            $user = Auth::user();
                            $roleName = optional($user?->role)->name;
                            $roleNorm = $roleName ? strtolower(trim($roleName)) : null;
                            $isProfessor = in_array($roleNorm, ['profesor', 'docente'], true);
                            $badgeText =
                                $roleNorm === 'administrador'
                                    ? 'Admin'
                                    : ($isProfessor
                                        ? 'Profe'
                                        : ($roleNorm === 'estudiante'
                                            ? 'Estu'
                                            : ''));
                            $badgeClass =
                                $roleNorm === 'administrador'
                                    ? 'badge-accent'
                                    : ($isProfessor
                                        ? 'badge-secondary'
                                        : ($roleNorm === 'estudiante'
                                            ? 'badge-primary'
                                            : 'badge-ghost'));
                        @endphp
                        @if ($badgeText)
                            <span
                                class="badge badge-xs {{ $badgeClass }} absolute -bottom-1 -right-1">{{ $badgeText }}</span>
                        @endif
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-ghost">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Registrarse</a>
                @endauth
            </div>
        </div>

        <!-- Mobile Menu Button -->
        <div class="dropdown dropdown-end lg:hidden ml-2">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                <li><a href="#secundaria">Secundaria</a></li>
                <li><a href="#pre-universitario">Pre-Universitario</a></li>
                <li><a href="#universitario">Universitario</a></li>
                <li><a href="#nosotros">Nosotros</a></li>
                <li><a href="#preguntas">Preguntas</a></li>
                <div class="divider"></div>
                @auth
                    <li><a href="{{ route('dashboard') }}">Ir a mi Panel</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">Cerrar sesión</a>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Iniciar Sesión</a></li>
                    <li><a href="{{ route('register') }}">Registrarse</a></li>
                @endauth
            </ul>
        </div>
    </div>
    </div>

    <main>
        <!-- =========== 1. Hero Section =========== -->
        <section class="container mx-auto px-6 py-16 md:py-24">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="text-center md:text-left">
                    <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 leading-tight">
                        Alcanza tus metas académicas con <span class="text-blue-600">WebDev-Pre</span>.
                    </h1>
                    <p class="mt-6 text-lg text-gray-600">
                        Cursos diseñados por expertos para potenciar tu aprendizaje en cada etapa de tu formación.
                        Prepárate para el éxito.
                    </p>
                    <div class="mt-8 flex justify-center md:justify-start gap-4">
                        <a href="#cursos"
                            class="px-8 py-3 font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-300">Explorar
                            Cursos</a>
                        <a href="#nosotros"
                            class="px-8 py-3 font-semibold text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition duration-300">Saber
                            Más</a>
                    </div>
                </div>
                <div class="bg-gray-200 rounded-lg shadow-lg h-64 md:h-96 flex items-center justify-center">
                    @php
                        $heroImagePath = @file_exists(storage_path('app/branding_hero_image.txt'))
                            ? trim(file_get_contents(storage_path('app/branding_hero_image.txt')))
                            : null;
                        $heroVideoPath = @file_exists(storage_path('app/branding_hero_video.txt'))
                            ? trim(file_get_contents(storage_path('app/branding_hero_video.txt')))
                            : null;
                    @endphp
                    @if ($heroVideoPath && Storage::disk('public')->exists($heroVideoPath))
                        <video class="w-full h-full object-cover rounded-lg" autoplay loop muted playsinline
                            poster="{{ $heroImagePath && Storage::disk('public')->exists($heroImagePath) ? Storage::url($heroImagePath) : '' }}">
                            <source src="{{ Storage::url($heroVideoPath) }}" type="video/mp4">
                            Tu navegador no soporta el tag de video.
                        </video>
                    @elseif ($heroImagePath && Storage::disk('public')->exists($heroImagePath))
                        <img src="{{ Storage::url($heroImagePath) }}" alt="Hero"
                            class="w-full h-full object-cover rounded-lg">
                    @else
                        <video class="w-full h-full object-cover rounded-lg" autoplay loop muted playsinline
                            poster="https://placehold.co/600x400/e2e8f0/334155?text=Video+Promocional">
                            <source src="https://videos.pexels.com/video-files/856193/856193-hd_1280_720_30fps.mp4"
                                type="video/mp4">
                            Tu navegador no soporta el tag de video.
                        </video>
                    @endif
                </div>
            </div>
        </section>

        <!-- =========== 2. Logo Marquee =========== -->
        <section class="bg-white py-8 md:py-12">
            @php $marqueeItems = \App\Models\MarqueeItem::where('active',true)->orderBy('order')->pluck('text'); @endphp
            <div class="relative w-full overflow-hidden marquee">
                <div class="flex" aria-hidden="true">
                    <div class="flex w-max items-center whitespace-nowrap animate-scroll">
                        @php
                            $list = $marqueeItems;
                            if ($list->count() < 6) {
                                $list = $list->merge($list)->merge($list);
                            }
                        @endphp
                        @foreach ($list as $txt)
                            <span class="mx-8 text-lg font-semibold text-gray-500">{{ $txt }}</span>
                        @endforeach
                        @if ($marqueeItems->isEmpty())
                            @foreach (['Biología', 'Matemáticas', 'Física', 'Anatomía', 'Fisiología', 'Química', 'Álgebra', 'Histología'] as $txt)
                                <span class="mx-8 text-lg font-semibold text-gray-400">{{ $txt }}</span>
                            @endforeach
                        @endif
                        <!-- duplicado para scroll infinito -->
                        @foreach ($list as $txt)
                            <span class="mx-8 text-lg font-semibold text-gray-500">{{ $txt }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- =========== 3. Course Carousels =========== -->
        <section id="cursos" class="container mx-auto px-6 py-16 md:py-24 space-y-16">

            <!-- Carrusel: Secundaria -->
            <div x-data="carousel()">
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">Cursos de Secundaria</h2>
                        <p class="text-gray-600 mt-2">Refuerza tus conocimientos y prepárate para los exámenes.</p>
                    </div>
                    @if ($secundariaCourses->count() > 0)
                        <div class="hidden md:flex items-center gap-2">
                            <button @click="prev()"
                                class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-md hover:bg-gray-100 transition">‹</button>
                            <button @click="next()"
                                class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-md hover:bg-gray-100 transition">›</button>
                        </div>
                    @endif
                </div>

                @if ($secundariaCourses->count() > 0)
                    <div class="relative">
                        <div x-ref="slider" class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth"
                            style="-ms-overflow-style: none; scrollbar-width: none;">
                            @foreach ($secundariaCourses as $course)
                                <div class="flex-shrink-0 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-3 snap-start">
                                    <a href="{{ route('courses.show', $course->id) }}" class="block">
                                        <div
                                            class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:scale-105 hover:-translate-y-2 cursor-pointer group">
                                            @if ($course->has_image)
                                                <img src="{{ $course->image_url }}" alt="{{ $course->title }}"
                                                    class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                                            @else
                                                <div
                                                    class="w-full h-48 bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center group-hover:from-blue-500 group-hover:to-blue-700 transition-all duration-300">
                                                    <span
                                                        class="text-white font-bold text-lg group-hover:scale-105 transition-transform duration-300">{{ $course->title }}</span>
                                                </div>
                                            @endif
                                            <div class="p-5">
                                                <h3
                                                    class="font-bold text-lg group-hover:text-blue-600 transition-colors duration-300">
                                                    {{ $course->title }}</h3>
                                                <p class="text-gray-600 text-sm mt-1">
                                                    {{ $course->professor->name ?? 'Profesor' }}</p>
                                                <div
                                                    class="mt-4 font-bold text-xl text-blue-600 group-hover:text-blue-700 transition-colors duration-300">
                                                    ${{ number_format($course->price, 2) }} ARS</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="text-center mt-10">
                        <a href="/cursos/secundaria"
                            class="px-8 py-3 font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-300">Ver
                            los cursos Secundarios</a>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="bg-gray-100 rounded-lg p-8">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Por el momento no hay cursos disponibles
                            </h3>
                            <p class="mt-2 text-gray-500">Los cursos de Secundaria estarán disponibles próximamente.
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Carrusel: Pre-Universitario -->
            <div x-data="carousel()">
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">Cursos Pre-Universitarios</h2>
                        <p class="text-gray-600 mt-2">Prepárate para el ingreso universitario con los mejores
                            profesores.</p>
                    </div>
                    @if ($preUniversitarioCourses->count() > 0)
                        <div class="hidden md:flex items-center gap-2">
                            <button @click="prev()"
                                class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-md hover:bg-gray-100 transition">‹</button>
                            <button @click="next()"
                                class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-md hover:bg-gray-100 transition">›</button>
                        </div>
                    @endif
                </div>

                @if ($preUniversitarioCourses->count() > 0)
                    <div class="relative">
                        <div x-ref="slider" class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth"
                            style="-ms-overflow-style: none; scrollbar-width: none;">
                            @foreach ($preUniversitarioCourses as $course)
                                <div class="flex-shrink-0 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-3 snap-start">
                                    <a href="{{ route('courses.show', $course->id) }}" class="block">
                                        <div
                                            class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:scale-105 hover:-translate-y-2 cursor-pointer group">
                                            @if ($course->has_image)
                                                <img src="{{ $course->image_url }}" alt="{{ $course->title }}"
                                                    class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                                            @else
                                                <div
                                                    class="w-full h-48 bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center group-hover:from-green-500 group-hover:to-green-700 transition-all duration-300">
                                                    <span
                                                        class="text-white font-bold text-lg group-hover:scale-105 transition-transform duration-300">{{ $course->title }}</span>
                                                </div>
                                            @endif
                                            <div class="p-5">
                                                <h3
                                                    class="font-bold text-lg group-hover:text-green-600 transition-colors duration-300">
                                                    {{ $course->title }}</h3>
                                                <p class="text-gray-600 text-sm mt-1">
                                                    {{ $course->professor->name ?? 'Profesor' }}</p>
                                                <div
                                                    class="mt-4 font-bold text-xl text-blue-600 group-hover:text-green-600 transition-colors duration-300">
                                                    ${{ number_format($course->price, 2) }} ARS</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="text-center mt-10">
                        <a href="/cursos/pre-universitario"
                            class="px-8 py-3 font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-300">Ver
                            los cursos Pre-Universitarios</a>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="bg-gray-100 rounded-lg p-8">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Por el momento no hay cursos disponibles
                            </h3>
                            <p class="mt-2 text-gray-500">Los cursos Pre-Universitarios estarán disponibles
                                próximamente.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Carrusel: Universitario -->
            <div x-data="carousel()">
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">Cursos Universitarios</h2>
                        <p class="text-gray-600 mt-2">Complementa tu formación universitaria con cursos especializados.
                        </p>
                    </div>
                    @if ($universitarioCourses->count() > 0)
                        <div class="hidden md:flex items-center gap-2">
                            <button @click="prev()"
                                class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-md hover:bg-gray-100 transition">‹</button>
                            <button @click="next()"
                                class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-md hover:bg-gray-100 transition">›</button>
                        </div>
                    @endif
                </div>

                @if ($universitarioCourses->count() > 0)
                    <div class="relative">
                        <div x-ref="slider" class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth"
                            style="-ms-overflow-style: none; scrollbar-width: none;">
                            @foreach ($universitarioCourses as $course)
                                <div class="flex-shrink-0 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-3 snap-start">
                                    <a href="{{ route('courses.show', $course->id) }}" class="block">
                                        <div
                                            class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:scale-105 hover:-translate-y-2 cursor-pointer group">
                                            @if ($course->has_image)
                                                <img src="{{ $course->image_url }}" alt="{{ $course->title }}"
                                                    class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                                            @else
                                                <div
                                                    class="w-full h-48 bg-gradient-to-r from-purple-400 to-purple-600 flex items-center justify-center group-hover:from-purple-500 group-hover:to-purple-700 transition-all duration-300">
                                                    <span
                                                        class="text-white font-bold text-lg group-hover:scale-105 transition-transform duration-300">{{ $course->title }}</span>
                                                </div>
                                            @endif
                                            <div class="p-5">
                                                <h3
                                                    class="font-bold text-lg group-hover:text-purple-600 transition-colors duration-300">
                                                    {{ $course->title }}</h3>
                                                <p class="text-gray-600 text-sm mt-1">
                                                    {{ $course->professor->name ?? 'Profesor' }}</p>
                                                <div
                                                    class="mt-4 font-bold text-xl text-blue-600 group-hover:text-purple-600 transition-colors duration-300">
                                                    ${{ number_format($course->price, 2) }} ARS</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="text-center mt-10">
                        <a href="/cursos/universitario"
                            class="px-8 py-3 font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-300">Ver
                            los cursos Universitarios</a>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="bg-gray-100 rounded-lg p-8">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Por el momento no hay cursos disponibles
                            </h3>
                            <p class="mt-2 text-gray-500">Los cursos Universitarios estarán disponibles próximamente.
                            </p>
                        </div>
                    </div>
                @endif
            </div>

        </section>

        <!-- =========== 4. Image Section =========== -->
        <section id="nosotros" class="container mx-auto px-6 py-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Nuestra Metodología</h2>
                <p class="text-gray-600 mt-2 max-w-2xl mx-auto">Combinamos tecnología, pedagogía y la experiencia de
                    los mejores profesores para ofrecerte una experiencia de aprendizaje única.</p>
            </div>
            @php
                $grid = \App\Models\HomeGridItem::orderBy('order')->get()->keyBy('order');
                $placeholders = [
                    1 => ['Foco', '6366f1'],
                    2 => ['Resumen', '818cf8'],
                    3 => ['Estudio', '4f46e5'],
                    4 => ['Docencia', '4338ca'],
                    5 => ['Trabajo', '6d28d9'],
                    6 => ['Práctica', '7c3aed'],
                    7 => ['Colaboración', '9333ea'],
                    8 => ['Innovación', 'a855f7'],
                    9 => ['Meta', 'b779ff'],
                    10 => ['Logro', 'c084fc'],
                ];
                function cell($slot, $grid, $placeholders)
                {
                    $item = $grid->get($slot);
                    if ($item) {
                        $media =
                            $item->media_type === 'image'
                                ? '<img class="w-full h-full object-cover rounded-lg" src="' .
                                    $item->url .
                                    '" alt="' .
                                    e($item->title) .
                                    '" />'
                                : '<video class="w-full h-full object-cover rounded-lg" autoplay loop muted playsinline><source src="' .
                                    $item->url .
                                    '" type="video/mp4" /></video>';
                        $overlay = $item->title
                            ? '<div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center p-2 text-white text-sm font-medium text-center">' .
                                e($item->title) .
                                '</div>'
                            : '';
                        return '<div class="relative group w-full h-full">' . $media . $overlay . '</div>';
                    }
                    [$t, $bg] = $placeholders[$slot];
                    return '<div class="w-full h-full rounded-lg flex items-center justify-center text-white text-xs font-semibold" style="background:#' .
                        $bg .
                        '">' .
                        $t .
                        '</div>';
                }
            @endphp
            <div class="parent grid gap-2 md:gap-2"
                style="grid-template-columns:repeat(5,minmax(0,1fr));grid-template-rows:repeat(6,120px);">
                <div class="div1 row-span-4 col-span-1">{!! cell(1, $grid, $placeholders) !!}</div>
                <div class="div2 row-span-2 col-span-1 row-start-5">{!! cell(2, $grid, $placeholders) !!}</div>
                <div class="div3 row-span-2 col-span-1 col-start-2 row-start-1">{!! cell(3, $grid, $placeholders) !!}</div>
                <div class="div4 row-span-4 col-span-1 col-start-2 row-start-3">{!! cell(4, $grid, $placeholders) !!}</div>
                <div class="div5 row-span-2 col-span-1 col-start-3 row-start-1">{!! cell(5, $grid, $placeholders) !!}</div>
                <div class="div6 row-span-2 col-span-1 col-start-3 row-start-3">{!! cell(6, $grid, $placeholders) !!}</div>
                <div class="div7 row-span-2 col-span-2 col-start-3 row-start-5">{!! cell(7, $grid, $placeholders) !!}</div>
                <div class="div8 row-span-4 col-span-1 col-start-4 row-start-1">{!! cell(8, $grid, $placeholders) !!}</div>
                <div class="div9 row-span-2 col-span-1 col-start-5 row-start-1">{!! cell(9, $grid, $placeholders) !!}</div>
                <div class="div10 row-span-4 col-span-1 col-start-5 row-start-3">{!! cell(10, $grid, $placeholders) !!}</div>
            </div>
        </section>
    </main>

    <style>
        @media (max-width: 1024px) {
            .parent {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                grid-template-rows: repeat(10, 120px) !important;
            }

            .parent>div {
                grid-column: auto !important;
                grid-row: span 2 / span 2 !important;
            }
        }

        @media (max-width: 640px) {
            .parent {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                grid-template-rows: repeat(15, 110px) !important;
            }

            .parent>div {
                grid-column: auto !important;
                grid-row: span 2 / span 2 !important;
            }
        }
    </style>

    <!-- =========== Footer =========== -->
    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold">WebDev-Pre</h3>
                    <p class="mt-2 text-gray-400">Potenciando tu futuro académico.</p>
                </div>
                <div>
                    <h4 class="font-semibold">Cursos</h4>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Secundaria</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Pre-Universitario</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Universitario</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold">Información</h4>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Nosotros</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Preguntas Frecuentes</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold">Síguenos</h4>
                    <!-- Aquí irían los iconos de redes sociales -->
                </div>
            </div>
            <div class="mt-12 border-t border-gray-700 pt-8 text-center text-gray-500">
                <p>&copy; 2024 WebDev-Pre. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        function carousel() {
            return {
                init() {
                    // Lógica de inicialización si es necesaria
                },
                next() {
                    const slider = this.$refs.slider;
                    const scrollAmount = slider.offsetWidth;
                    slider.scrollBy({
                        left: scrollAmount,
                        behavior: 'smooth'
                    });
                },
                prev() {
                    const slider = this.$refs.slider;
                    const scrollAmount = slider.offsetWidth;
                    slider.scrollBy({
                        left: -scrollAmount,
                        behavior: 'smooth'
                    });
                }
            }
        }
    </script>
</body>

</html>
