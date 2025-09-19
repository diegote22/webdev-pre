@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout :public-nav="true" :full-bleed="true">
    <!-- Navigation Breadcrumb -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-6 py-3">
            <div class="flex items-center gap-2 text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Inicio</a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-900 font-medium">{{ $categoryName }}</span>
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center w-full max-w-7xl mx-auto">
                <div class="text-center md:text-left">
                    <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 leading-tight heading-font">
                        Cursos de <span
                            class="
                            @if ($categoryName === 'Secundaria') text-blue-600
                            @elseif($categoryName === 'Pre-Universitario') text-green-600
                            @else text-purple-600 @endif
                        ">{{ $categoryName }}</span>
                    </h1>
                    <p class="mt-6 text-lg text-gray-600 text-font">
                        {{ $categoryDescription }} Descubre nuestra amplia selección de cursos diseñados por expertos
                        para potenciar tu aprendizaje y alcanzar tus objetivos académicos.
                    </p>
                    <div class="mt-8 flex justify-center md:justify-start gap-4">
                        <a href="#cursos"
                            class="px-8 py-3 font-semibold text-white
                            @if ($categoryName === 'Secundaria') bg-blue-600 hover:bg-blue-700
                            @elseif($categoryName === 'Pre-Universitario') bg-green-600 hover:bg-green-700
                            @else bg-purple-600 hover:bg-purple-700 @endif
                            rounded-lg transition duration-300 shadow-lg text-font">Ver
                            Cursos</a>
                        <a href="/"
                            class="px-8 py-3 font-semibold text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition duration-300 shadow-lg text-font">Volver
                            al Inicio</a>
                    </div>
                </div>
                <div class="bg-gray-200 rounded-lg shadow-lg h-64 md:h-96 flex items-center justify-center">
                    @php
                        // Videos específicos por categoría
                        $categorySlug = strtolower(str_replace('-', '_', $categoryName));
                        $categoryVideoPath = @file_exists(storage_path("app/category_{$categorySlug}_video.txt"))
                            ? trim(file_get_contents(storage_path("app/category_{$categorySlug}_video.txt")))
                            : null;
                        $categoryImagePath = @file_exists(storage_path("app/category_{$categorySlug}_image.txt"))
                            ? trim(file_get_contents(storage_path("app/category_{$categorySlug}_image.txt")))
                            : null;
                    @endphp
                    @if ($categoryVideoPath && Storage::disk('public')->exists($categoryVideoPath))
                        <video class="w-full h-full object-cover rounded-lg shadow-md" autoplay loop muted playsinline
                            poster="{{ $categoryImagePath && Storage::disk('public')->exists($categoryImagePath) ? Storage::url($categoryImagePath) : '' }}">
                            <source src="{{ Storage::url($categoryVideoPath) }}" type="video/mp4">
                            Tu navegador no soporta el tag de video.
                        </video>
                    @elseif ($categoryImagePath && Storage::disk('public')->exists($categoryImagePath))
                        <img src="{{ Storage::url($categoryImagePath) }}" alt="{{ $categoryName }}"
                            class="w-full h-full object-cover rounded-lg shadow-md">
                    @else
                        <div
                            class="w-full h-full
                            @if ($categoryName === 'Secundaria') bg-gradient-to-br from-blue-400 to-blue-600
                            @elseif($categoryName === 'Pre-Universitario') bg-gradient-to-br from-green-400 to-green-600
                            @else bg-gradient-to-br from-purple-400 to-purple-600 @endif
                            rounded-lg flex items-center justify-center">
                            <div class="text-white text-center p-6">
                                @if ($categoryName === 'Secundaria')
                                    <svg class="w-24 h-24 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @elseif($categoryName === 'Pre-Universitario')
                                    <svg class="w-24 h-24 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z" />
                                    </svg>
                                @else
                                    <svg class="w-24 h-24 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                                <h3 class="text-2xl font-bold heading-font">{{ $categoryName }}</h3>
                                <p class="text-white/90 text-font">Video próximamente</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Cursos -->
    <section id="cursos" class="max-w-7xl mx-auto px-6 py-16 md:py-24">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 heading-font">Todos los cursos de {{ $categoryName }}</h2>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto text-font">
                Explora nuestra colección completa de cursos diseñados especialmente para tu nivel académico.
            </p>
        </div>

        @if ($courses->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($courses as $course)
                    <div
                        class="bg-white rounded-lg shadow-lg hover:shadow-2xl transform transition-all duration-300 hover:scale-105 hover:-translate-y-2 cursor-pointer group">
                        <div class="relative">
                            @if ($course->has_image)
                                <img src="{{ $course->image_url }}" alt="{{ $course->title }}"
                                    class="w-full h-48 object-cover rounded-t-lg group-hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="w-full h-48 bg-cover bg-center rounded-t-lg"
                                    style="background-image: url('{{ asset('img/fondo-webdev-1.png') }}');">
                                    <div
                                        class="w-full h-full bg-gradient-to-r
                                        @if ($categoryName === 'Secundaria') from-blue-600/80 to-blue-800/80
                                        @elseif($categoryName === 'Pre-Universitario') from-green-600/80 to-green-800/80
                                        @else from-purple-600/80 to-purple-800/80 @endif
                                        rounded-t-lg flex items-center justify-center transition-all duration-300">
                                        <span
                                            class="text-white font-bold text-lg text-center px-4 group-hover:scale-105 transition-transform duration-300 heading-font">{{ $course->title }}</span>
                                    </div>
                                </div>
                            @endif

                            <!-- Foto del profesor -->
                            <div class="absolute top-4 left-4">
                                <div class="w-10 h-10 rounded-full overflow-hidden bg-white shadow-lg">
                                    @if ($course->professor && $course->professor->avatar_path)
                                        <img src="{{ Storage::url($course->professor->avatar_path) }}"
                                            alt="{{ $course->professor->name }}" class="w-full h-full object-cover">
                                    @elseif ($course->professor && $course->professor->profile_photo_path)
                                        <img src="{{ Storage::url($course->professor->profile_photo_path) }}"
                                            alt="{{ $course->professor->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3
                                class="text-xl font-bold text-gray-900 mb-2 heading-font
                                @if ($categoryName === 'Secundaria') group-hover:text-blue-600
                                @elseif($categoryName === 'Pre-Universitario') group-hover:text-green-600
                                @else group-hover:text-purple-600 @endif
                                transition-colors duration-300">
                                {{ $course->title }}
                            </h3>

                            <p class="text-sm text-gray-600 mb-4 text-font line-clamp-2">
                                {{ $course->description ?? ($course->summary ?? 'Curso diseñado para potenciar tu aprendizaje con contenido de alta calidad.') }}
                            </p>

                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="text-sm text-gray-500 text-font">
                                        <span class="font-medium">Prof.</span>
                                        {{ $course->professor->name ?? 'Profesor' }}
                                    </div>
                                </div>
                                @if ($course->level)
                                    <span
                                        class="px-2 py-1 text-xs font-semibold
                                        @if ($categoryName === 'Secundaria') bg-blue-100 text-blue-800
                                        @elseif($categoryName === 'Pre-Universitario') bg-green-100 text-green-800
                                        @else bg-purple-100 text-purple-800 @endif
                                        rounded-full text-font">{{ $course->level }}</span>
                                @endif
                            </div>

                            <div class="flex items-center justify-between mb-6">
                                <div class="flex flex-col">
                                    @if ($course->category)
                                        <span
                                            class="text-xs text-gray-500 text-font">{{ $course->category->name }}</span>
                                    @endif
                                    @if ($course->subCategory)
                                        <span
                                            class="text-xs text-gray-400 text-font">{{ $course->subCategory->name }}</span>
                                    @endif
                                </div>

                                <div class="text-right">
                                    <div
                                        class="text-2xl font-bold
                                        @if ($categoryName === 'Secundaria') text-blue-600
                                        @elseif($categoryName === 'Pre-Universitario') text-green-600
                                        @else text-purple-600 @endif
                                        heading-font">
                                        ${{ number_format($course->price ?? 0, 2) }}
                                    </div>
                                    <span class="text-sm text-gray-500 text-font">ARS</span>
                                </div>
                            </div>

                            <a href="{{ route('courses.show', $course) }}"
                                class="w-full py-3 px-4 text-center font-semibold text-white
                                @if ($categoryName === 'Secundaria') bg-blue-600 hover:bg-blue-700
                                @elseif($categoryName === 'Pre-Universitario') bg-green-600 hover:bg-green-700
                                @else bg-purple-600 hover:bg-purple-700 @endif
                                rounded-lg transition duration-300 shadow-lg text-font block">
                                Ver Curso Completo
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-12 flex justify-center">
                {{ $courses->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
                    <svg class="mx-auto h-20 w-20 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <h3 class="mt-6 text-xl font-semibold text-gray-900 heading-font">Por el momento no hay cursos
                        disponibles</h3>
                    <p class="mt-2 text-gray-600 text-font">Los cursos de {{ $categoryName }} estarán disponibles
                        próximamente.</p>
                    <div class="mt-6">
                        <a href="/"
                            class="px-6 py-3 font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-300 shadow-lg text-font">Volver
                            al Inicio</a>
                    </div>
                </div>
            </div>
        @endif
    </section>
</x-app-layout>
