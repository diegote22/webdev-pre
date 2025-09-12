<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WebDev-Pre - Tu Futuro Empieza Hoy</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Animación para la marquesina de logos */
        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .animate-scroll {
            animation: scroll 40s linear infinite;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- =========== Header =========== -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <!-- El logo se cargaría desde la carpeta public de Laravel -->
                <a href="/" class="text-2xl font-bold text-blue-600">WebDev-Pre</a>
                <!-- <img src="{{ asset('logo.svg') }}" alt="Logo WebDev-Pre" class="h-10"> -->
            </div>
            <div class="hidden md:flex items-center space-x-6">
                <a href="#secundaria" class="text-gray-600 hover:text-blue-600 transition duration-300">Secundaria</a>
                <a href="#pre-universitario"
                    class="text-gray-600 hover:text-blue-600 transition duration-300">Pre-Universitario</a>
                <a href="#universitario"
                    class="text-gray-600 hover:text-blue-600 transition duration-300">Universitario</a>
                <a href="#nosotros" class="text-gray-600 hover:text-blue-600 transition duration-300">Nosotros</a>
                <a href="#preguntas" class="text-gray-600 hover:text-blue-600 transition duration-300">Preguntas</a>
            </div>
            <div class="flex items-center space-x-3">
                <a href="/login"
                    class="px-5 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition duration-300">Iniciar
                    Sesión</a>
                <a href="/register"
                    class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-300">Registrarse</a>
            </div>
        </nav>
    </header>

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
                    <!-- El administrador podrá cambiar este video desde el dashboard -->
                    <video class="w-full h-full object-cover rounded-lg" controls
                        poster="https://placehold.co/600x400/e2e8f0/334155?text=Video+Promocional">
                        <!-- <source src="{{ asset('videos/promo.mp4') }}" type="video/mp4"> -->
                        Tu navegador no soporta el tag de video.
                    </video>
                </div>
            </div>
        </section>

        <!-- =========== 2. Logo Marquee =========== -->
        <section class="bg-white py-8 md:py-12">
            <div class="relative w-full overflow-hidden">
                <div class="flex animate-scroll">
                    <div class="flex w-max items-center">
                        <span class="mx-8 text-lg font-semibold text-gray-500">Biología</span>
                        <span class="mx-8 text-lg font-semibold text-gray-500">Matemáticas</span>
                        <span class="mx-8 text-lg font-semibold text-gray-500">Física</span>
                        <span class="mx-8 text-lg font-semibold text-gray-500">Anatomía</span>
                        <span class="mx-8 text-lg font-semibold text-gray-500">Fisiología</span>
                        <span class="mx-8 text-lg font-semibold text-gray-500">Química</span>
                        <span class="mx-8 text-lg font-semibold text-gray-500">Álgebra</span>
                        <span class="mx-8 text-lg font-semibold text-gray-500">Histología</span>
                        <!-- Repetir para efecto infinito -->
                        <span class="mx-8 text-lg font-semibold text-gray-500">Biología</span>
                        <span class="mx-8 text-lg font-semibold text-gray-500">Matemáticas</span>
                        <span class="mx-8 text-lg font-semibold text-gray-500">Física</span>
                        <span class="mx-8 text-lg font-semibold text-gray-500">Anatomía</span>
                        <span class="mx-8 text-lg font-semibold text-gray-500">Fisiología</span>
                        <span class="mx-8 text-lg font-semibold text-gray-500">Química</span>
                        <span class="mx-8 text-lg font-semibold text-gray-500">Álgebra</span>
                        <span class="mx-8 text-lg font-semibold text-gray-500">Histología</span>
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
                    <div class="hidden md:flex items-center gap-2">
                        <button @click="prev()"
                            class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-md hover:bg-gray-100 transition">‹</button>
                        <button @click="next()"
                            class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-md hover:bg-gray-100 transition">›</button>
                    </div>
                </div>
                <div class="relative">
                    <div x-ref="slider" class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth"
                        style="-ms-overflow-style: none; scrollbar-width: none;">
                        <!-- Ejemplo de 5 Cursos -->
                        <div class="flex-shrink-0 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-3 snap-start">
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                                <img src="https://placehold.co/400x250/3b82f6/ffffff?text=Matemática+3er+Año"
                                    alt="Curso" class="w-full h-48 object-cover">
                                <div class="p-5">
                                    <h3 class="font-bold text-lg">Matemática 3er Año</h3>
                                    <p class="text-gray-600 text-sm mt-1">Prof. Juan Pérez</p>
                                    <div class="mt-4 font-bold text-xl text-blue-600">$2500 ARS</div>
                                </div>
                            </div>
                        </div>
                        <!-- Repite la tarjeta del curso 4 veces más -->
                        <div class="flex-shrink-0 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-3 snap-start">
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                                <img src="https://placehold.co/400x250/10b981/ffffff?text=Biología+Celular"
                                    alt="Curso" class="w-full h-48 object-cover">
                                <div class="p-5">
                                    <h3 class="font-bold text-lg">Biología Celular</h3>
                                    <p class="text-gray-600 text-sm mt-1">Prof. Ana Gómez</p>
                                    <div class="mt-4 font-bold text-xl text-blue-600">$3000 ARS</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-3 snap-start">
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                                <img src="https://placehold.co/400x250/f97316/ffffff?text=Física+General"
                                    alt="Curso" class="w-full h-48 object-cover">
                                <div class="p-5">
                                    <h3 class="font-bold text-lg">Física General</h3>
                                    <p class="text-gray-600 text-sm mt-1">Prof. Carlos Ruiz</p>
                                    <div class="mt-4 font-bold text-xl text-blue-600">$2800 ARS</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-3 snap-start">
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                                <img src="https://placehold.co/400x250/8b5cf6/ffffff?text=Química+Orgánica"
                                    alt="Curso" class="w-full h-48 object-cover">
                                <div class="p-5">
                                    <h3 class="font-bold text-lg">Química Orgánica</h3>
                                    <p class="text-gray-600 text-sm mt-1">Prof. Laura Méndez</p>
                                    <div class="mt-4 font-bold text-xl text-blue-600">$3200 ARS</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-3 snap-start">
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                                <img src="https://placehold.co/400x250/ec4899/ffffff?text=Historia+Argentina"
                                    alt="Curso" class="w-full h-48 object-cover">
                                <div class="p-5">
                                    <h3 class="font-bold text-lg">Historia Argentina</h3>
                                    <p class="text-gray-600 text-sm mt-1">Prof. Sofía Castro</p>
                                    <div class="mt-4 font-bold text-xl text-blue-600">$2200 ARS</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-10">
                    <a href="/cursos/secundaria"
                        class="px-8 py-3 font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-300">Ver
                        los cursos Secundarios</a>
                </div>
            </div>

            <!-- Aquí irían los otros dos carruseles para Pre-Universitario y Universitario, con la misma estructura -->

        </section>

        <!-- =========== 4. Image Section =========== -->
        <section id="nosotros" class="container mx-auto px-6 py-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Nuestra Metodología</h2>
                <p class="text-gray-600 mt-2 max-w-2xl mx-auto">Combinamos tecnología, pedagogía y la experiencia de
                    los mejores profesores para ofrecerte una experiencia de aprendizaje única.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="grid gap-4">
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md"
                            src="https://placehold.co/500x700/a5b4fc/312e81?text=Estudiante+Concentrado"
                            alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md"
                            src="https://placehold.co/500x500/818cf8/1e1b4b?text=Clase+Virtual" alt="">
                    </div>
                </div>
                <div class="grid gap-4">
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md"
                            src="https://placehold.co/500x500/6366f1/eef2ff?text=Material+de+Estudio" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md"
                            src="https://placehold.co/500x700/4f46e5/e0e7ff?text=Profesor+Explicando" alt="">
                    </div>
                </div>
                <div class="grid gap-4">
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md"
                            src="https://placehold.co/500x700/6d28d9/f5f3ff?text=Trabajo+en+Equipo" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md"
                            src="https://placehold.co/500x500/7c3aed/f5f3ff?text=Éxito+Académico" alt="">
                    </div>
                </div>
                <div class="grid gap-4">
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md"
                            src="https://placehold.co/500x500/9333ea/faf5ff?text=Plataforma+Intuitiva" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md"
                            src="https://placehold.co/500x700/a855f7/faf5ff?text=Graduación" alt="">
                    </div>
                </div>
            </div>
        </section>
    </main>

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
