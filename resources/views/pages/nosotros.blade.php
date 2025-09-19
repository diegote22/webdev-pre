@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <!-- Navigation Breadcrumb -->
    <nav class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center gap-2 text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Inicio</a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-900 font-medium">Nosotros</span>
            </div>
        </div>
    </nav>

    <!-- Hero Section con imagen de fondo -->
    <section class="relative h-96 md:h-[500px] bg-cover bg-center bg-no-repeat w-full"
        style="background-image: url('{{ asset('img/fondo-webdev-1.png') }}');">
        <!-- Overlay tenue para la imagen de fondo -->
        <div class="absolute inset-0 bg-white bg-opacity-60"></div>

        <!-- Contenido del Hero -->
        <div class="relative w-full h-full px-6 py-8 md:py-12 flex items-center">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center w-full">
                <div class="text-center md:text-left">
                    <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 leading-tight heading-font">
                        Conoce <span class="text-blue-600 logo-font">WebDev-Pre</span>
                    </h1>
                    <p class="mt-6 text-lg text-gray-600 text-font">
                        Somos una plataforma educativa comprometida con la excelencia académica. Nuestro equipo de
                        expertos profesores
                        trabaja día a día para ofrecerte la mejor experiencia de aprendizaje.
                    </p>
                    <div class="mt-8 flex justify-center md:justify-start gap-4">
                        <a href="#equipo"
                            class="px-8 py-3 font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition duration-300 shadow-lg text-font">Conocer
                            Equipo</a>
                        <a href="#mision"
                            class="px-8 py-3 font-semibold text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition duration-300 shadow-lg text-font">Nuestra
                            Misión</a>
                    </div>
                </div>
                <div class="bg-gray-200 rounded-lg shadow-lg h-64 md:h-96 flex items-center justify-center">
                    @php
                        $nosotrosVideoPath = @file_exists(storage_path('app/nosotros_video.txt'))
                            ? trim(file_get_contents(storage_path('app/nosotros_video.txt')))
                            : null;
                        $nosotrosImagePath = @file_exists(storage_path('app/nosotros_image.txt'))
                            ? trim(file_get_contents(storage_path('app/nosotros_image.txt')))
                            : null;
                    @endphp
                    @if ($nosotrosVideoPath && Storage::disk('public')->exists($nosotrosVideoPath))
                        <video class="w-full h-full object-cover rounded-lg shadow-md" autoplay loop muted playsinline
                            poster="{{ $nosotrosImagePath && Storage::disk('public')->exists($nosotrosImagePath) ? Storage::url($nosotrosImagePath) : '' }}">
                            <source src="{{ Storage::url($nosotrosVideoPath) }}" type="video/mp4">
                            Tu navegador no soporta el tag de video.
                        </video>
                    @elseif ($nosotrosImagePath && Storage::disk('public')->exists($nosotrosImagePath))
                        <img src="{{ Storage::url($nosotrosImagePath) }}" alt="Nosotros"
                            class="w-full h-full object-cover rounded-lg shadow-md">
                    @else
                        <div
                            class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                            <div class="text-white text-center p-6">
                                <svg class="w-24 h-24 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                                </svg>
                                <h3 class="text-2xl font-bold heading-font">Nuestro Equipo</h3>
                                <p class="text-blue-100 text-font">Video próximamente</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Misión y Visión -->
    <section id="mision" class="container mx-auto px-6 py-16 md:py-24">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 heading-font">Nuestra Misión y Visión</h2>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto text-font">
                Comprometidos con la educación de calidad y la formación integral de nuestros estudiantes.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 heading-font">Nuestra Misión</h3>
                </div>
                <p class="text-gray-600 text-font leading-relaxed">
                    Proporcionar educación de alta calidad, accesible y personalizada que empodere a estudiantes de
                    todos los niveles
                    para alcanzar sus objetivos académicos y profesionales. Creamos experiencias de aprendizaje
                    innovadoras que
                    combinan tecnología de vanguardia con metodologías pedagógicas probadas.
                </p>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 heading-font">Nuestra Visión</h3>
                </div>
                <p class="text-gray-600 text-font leading-relaxed">
                    Ser la plataforma educativa líder en América Latina, reconocida por la excelencia de nuestros
                    contenidos,
                    la innovación en nuestros métodos de enseñanza y el éxito de nuestros estudiantes. Aspiramos a
                    transformar
                    la educación mediante la tecnología y la personalización del aprendizaje.
                </p>
            </div>
        </div>
    </section>

    <!-- Sección del Equipo -->
    <section id="equipo" class="bg-gray-50 py-16 md:py-24">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 heading-font">Nuestro Equipo</h2>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto text-font">
                    Conoce a los profesionales que hacen posible WebDev-Pre, expertos comprometidos con tu éxito
                    académico.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Miembro del equipo 1 -->
                <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                    <div class="w-24 h-24 mx-auto mb-4 bg-gray-300 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2 heading-font">Director Académico</h4>
                    <p class="text-blue-600 font-medium text-font mb-3">Educación y Pedagogía</p>
                    <p class="text-gray-600 text-sm text-font">
                        Experto en metodologías educativas con más de 15 años de experiencia en formación académica.
                    </p>
                </div>

                <!-- Miembro del equipo 2 -->
                <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                    <div class="w-24 h-24 mx-auto mb-4 bg-gray-300 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2 heading-font">Coordinador Técnico</h4>
                    <p class="text-green-600 font-medium text-font mb-3">Tecnología Educativa</p>
                    <p class="text-gray-600 text-sm text-font">
                        Especialista en plataformas digitales y herramientas tecnológicas para la educación online.
                    </p>
                </div>

                <!-- Miembro del equipo 3 -->
                <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                    <div class="w-24 h-24 mx-auto mb-4 bg-gray-300 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2 heading-font">Coordinadora de Contenidos</h4>
                    <p class="text-purple-600 font-medium text-font mb-3">Desarrollo Curricular</p>
                    <p class="text-gray-600 text-sm text-font">
                        Responsable del diseño y desarrollo de contenidos educativos de alta calidad y actualizados.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Valores -->
    <section class="container mx-auto px-6 py-16 md:py-24">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 heading-font">Nuestros Valores</h2>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto text-font">
                Los principios que guían nuestro trabajo y compromiso con la educación de calidad.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-gray-900 mb-2 heading-font">Excelencia</h4>
                <p class="text-gray-600 text-sm text-font">Buscamos la calidad superior en todo lo que hacemos.</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-gray-900 mb-2 heading-font">Innovación</h4>
                <p class="text-gray-600 text-sm text-font">Implementamos las últimas tecnologías educativas.</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-gray-900 mb-2 heading-font">Compromiso</h4>
                <p class="text-gray-600 text-sm text-font">Dedicados al éxito académico de cada estudiante.</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-gray-900 mb-2 heading-font">Pasión</h4>
                <p class="text-gray-600 text-sm text-font">Amamos la educación y transmitimos ese entusiasmo.</p>
            </div>
        </div>
    </section>
</x-app-layout>
