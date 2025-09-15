@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <!-- Hero Section -->
    <div
        class="bg-gradient-to-r
        @if ($categoryName === 'Secundaria') from-blue-50 to-blue-100
        @elseif($categoryName === 'Pre-Universitario') from-green-50 to-green-100
        @else from-purple-50 to-purple-100 @endif
        py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Contenido de texto -->
                <div class="space-y-6">
                    <div>
                        <h1 class="text-5xl font-bold text-base-content mb-4">Nuestros cursos</h1>
                        <h2
                            class="text-3xl font-semibold
                            @if ($categoryName === 'Secundaria') text-blue-600
                            @elseif($categoryName === 'Pre-Universitario') text-green-600
                            @else text-purple-600 @endif
                            mb-4">
                            {{ $categoryName }}</h2>
                    </div>

                    <p class="text-lg text-base-content/80 leading-relaxed">
                        {{ $categoryDescription }} Descubre nuestra amplia selección de cursos diseñados por expertos
                        para potenciar tu aprendizaje y alcanzar tus objetivos académicos.
                    </p>

                    <div class="pt-4">
                        <button
                            class="btn
                            @if ($categoryName === 'Secundaria') btn-primary
                            @elseif($categoryName === 'Pre-Universitario') btn-success
                            @else btn-secondary @endif
                            btn-lg">
                            Explorar Cursos
                        </button>
                    </div>
                </div>

                <!-- Imagen -->
                <div class="flex justify-center lg:justify-end">
                    <div class="relative">
                        <div
                            class="w-80 h-96
                            @if ($categoryName === 'Secundaria') bg-gradient-to-br from-blue-400 to-blue-600
                            @elseif($categoryName === 'Pre-Universitario') bg-gradient-to-br from-green-400 to-green-600
                            @else bg-gradient-to-br from-purple-400 to-purple-600 @endif
                            rounded-2xl shadow-2xl flex items-center justify-center overflow-hidden">

                            <!-- Imagen placeholder o imagen real -->
                            @if ($categoryName === 'Secundaria')
                                <div class="text-white text-center p-6">
                                    <svg class="w-24 h-24 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="text-2xl font-bold">Secundaria</h3>
                                    <p class="text-blue-100">Preparación académica</p>
                                </div>
                            @elseif($categoryName === 'Pre-Universitario')
                                <div class="text-white text-center p-6">
                                    <svg class="w-24 h-24 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.75 2.524z" />
                                    </svg>
                                    <h3 class="text-2xl font-bold">Pre-Universitario</h3>
                                    <p class="text-green-100">Ingreso universitario</p>
                                </div>
                            @else
                                <div class="text-white text-center p-6">
                                    <svg class="w-24 h-24 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <h3 class="text-2xl font-bold">Universitario</h3>
                                    <p class="text-purple-100">Formación profesional</p>
                                </div>
                            @endif
                        </div>

                        <!-- Decoración -->
                        <div
                            class="absolute -top-4 -right-4 w-20 h-20
                            @if ($categoryName === 'Secundaria') bg-blue-200
                            @elseif($categoryName === 'Pre-Universitario') bg-green-200
                            @else bg-purple-200 @endif
                            rounded-full opacity-50">
                        </div>
                        <div
                            class="absolute -bottom-4 -left-4 w-16 h-16
                            @if ($categoryName === 'Secundaria') bg-blue-300
                            @elseif($categoryName === 'Pre-Universitario') bg-green-300
                            @else bg-purple-300 @endif
                            rounded-full opacity-30">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($courses->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($courses as $course)
                        <div
                            class="card bg-base-100 shadow-lg hover:shadow-2xl transform transition-all duration-300 hover:scale-105 hover:-translate-y-2 cursor-pointer group">
                            <figure>
                                @if ($course->image_path && Storage::exists($course->image_path))
                                    <img src="{{ Storage::url($course->image_path) }}" alt="{{ $course->title }}"
                                        class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div
                                        class="w-full h-48 bg-gradient-to-r
                                        @if ($categoryName === 'Secundaria') from-blue-400 to-blue-600 group-hover:from-blue-500 group-hover:to-blue-700
                                        @elseif($categoryName === 'Pre-Universitario') from-green-400 to-green-600 group-hover:from-green-500 group-hover:to-green-700
                                        @else from-purple-400 to-purple-600 group-hover:from-purple-500 group-hover:to-purple-700 @endif
                                        flex items-center justify-center transition-all duration-300">
                                        <span
                                            class="text-white font-bold text-lg text-center px-4 group-hover:scale-105 transition-transform duration-300">{{ $course->title }}</span>
                                    </div>
                                @endif
                            </figure>

                            <div class="card-body">
                                <h2
                                    class="card-title text-lg
                                    @if ($categoryName === 'Secundaria') group-hover:text-blue-600
                                    @elseif($categoryName === 'Pre-Universitario') group-hover:text-green-600
                                    @else group-hover:text-purple-600 @endif
                                    transition-colors duration-300">
                                    {{ $course->title }}
                                    <div class="badge badge-secondary">NEW</div>
                                </h2>

                                <p class="text-sm text-base-content/80 mb-2">
                                    {{ Str::limit($course->description ?? ($course->summary ?? 'Sin descripción'), 100) }}
                                </p>

                                <div class="flex items-center justify-between mb-4">
                                    <div class="text-sm text-base-content/70">
                                        <span class="font-medium">Prof.</span>
                                        {{ $course->professor->name ?? 'Profesor' }}
                                    </div>
                                    @if ($course->level)
                                        <div class="badge badge-outline">{{ $course->level }}</div>
                                    @endif
                                </div>

                                <div class="card-actions justify-between items-center">
                                    <div class="flex flex-col">
                                        @if ($course->category)
                                            <span
                                                class="text-xs text-base-content/60">{{ $course->category->name }}</span>
                                        @endif
                                        @if ($course->subCategory)
                                            <span
                                                class="text-xs text-base-content/60">{{ $course->subCategory->name }}</span>
                                        @endif
                                    </div>

                                    <div class="text-right">
                                        <div
                                            class="text-2xl font-bold
                                            @if ($categoryName === 'Secundaria') text-blue-600 group-hover:text-blue-700
                                            @elseif($categoryName === 'Pre-Universitario') text-green-600 group-hover:text-green-700
                                            @else text-purple-600 group-hover:text-purple-700 @endif
                                            transition-colors duration-300">
                                            ${{ number_format($course->price ?? 0, 2) }}
                                        </div>
                                        <span class="text-sm text-base-content/60">ARS</span>
                                    </div>
                                </div>

                                <div class="card-actions justify-end mt-4">
                                    <a href="{{ route('courses.show', $course) }}"
                                        class="btn
                                        @if ($categoryName === 'Secundaria') btn-primary
                                        @elseif($categoryName === 'Pre-Universitario') btn-success
                                        @else btn-secondary @endif
                                        btn-sm">
                                        Ver Curso
                                    </a>
                                </div>
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
                    <div class="max-w-md mx-auto bg-base-100 rounded-lg shadow-lg p-8">
                        <svg class="mx-auto h-20 w-20 text-base-content/40" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h3 class="mt-6 text-xl font-semibold text-base-content">Por el momento no hay cursos
                            disponibles</h3>
                        <p class="mt-2 text-base-content/70">Los cursos de {{ $categoryName }} estarán disponibles
                            próximamente.</p>
                        <div class="mt-6">
                            <a href="/" class="btn btn-primary">Volver al Inicio</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
