@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <div class="min-h-screen bg-base-200">
        <!-- Header -->
        <div class="bg-base-100 border-b border-base-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-base-content">Mis Cursos</h1>
                        <p class="text-base-content/70 mt-2">Gestiona y continúa con tus cursos matriculados</p>
                    </div>
                    <div class="stats stats-horizontal shadow">
                        <div class="stat">
                            <div class="stat-title">Total</div>
                            <div class="stat-value text-primary">{{ $enrolledCourses->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Filtros y Búsqueda -->
            <div class="card bg-base-100 shadow-lg mb-8">
                <div class="card-body">
                    <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between">
                        <div class="flex flex-wrap gap-2">
                            <form action="{{ route('student.my-courses') }}" method="GET" class="w-full">
                                <div
                                    class="join w-full max-w-md focus-within:outline-none focus-within:ring-0 focus-within:ring-offset-0">
                                    <input type="search" name="q" value="{{ request('q') }}"
                                        placeholder="Que curso estas buscando..."
                                        class="input input-bordered join-item w-full outline-none ring-0 focus:outline-none focus:ring-0 focus:ring-offset-0 focus:shadow-none focus:border-primary focus-visible:outline-none focus-visible:ring-0 focus:outline-offset-0" />
                                    <button type="submit" class="btn btn-primary join-item">Buscar</button>
                                </div>
                            </form>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <div class="dropdown dropdown-end">
                                <div tabindex="0" role="button" class="btn btn-outline">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Filtrar
                                </div>
                                <ul tabindex="0"
                                    class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                    <li><a>Todos los cursos</a></li>
                                    <li><a>En progreso</a></li>
                                    <li><a>Completados</a></li>
                                    <li><a>Pendientes</a></li>
                                </ul>
                            </div>
                            <div class="join">
                                <input class="join-item btn btn-square btn-sm" type="radio" name="view"
                                    aria-label="Grid" checked />
                                <input class="join-item btn btn-square btn-sm" type="radio" name="view"
                                    aria-label="List" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($enrolledCourses->count() > 0)
                <!-- Grid de Cursos -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($enrolledCourses as $course)
                        <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 group">
                            @if ($course->has_image)
                                <figure class="relative h-48 overflow-hidden">
                                    <img src="{{ $course->image_url }}" alt="{{ $course->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </figure>
                            @else
                                <figure
                                    class="relative h-48 bg-gradient-to-br from-primary to-secondary flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" />
                                    </svg>
                                </figure>
                            @endif

                            <!-- Badge de Progreso -->
                            <div class="absolute top-4 right-4 z-10">
                                @php
                                    $progress = rand(20, 95);
                                    $status =
                                        $progress == 100 ? 'Completado' : ($progress > 50 ? 'En progreso' : 'Iniciado');
                                    $badgeClass =
                                        $progress == 100
                                            ? 'badge-success'
                                            : ($progress > 50
                                                ? 'badge-warning'
                                                : 'badge-info');
                                @endphp
                                <div class="badge {{ $badgeClass }} badge-lg font-semibold">{{ $progress }}%</div>
                            </div>

                            <div class="card-body">
                                <h2 class="card-title text-lg">{{ $course->title }}</h2>
                                <div class="flex items-center gap-2 text-sm text-base-content/70 mb-3">
                                    <span
                                        class="badge badge-outline">{{ $course->category->name ?? 'Categoría' }}</span>
                                    <span class="badge badge-ghost">{{ $course->level ?? 'Intermedio' }}</span>
                                </div>

                                <p class="text-base-content/80 text-sm mb-4 line-clamp-2">
                                    {{ Str::limit($course->description ?? 'Descripción del curso', 100) }}
                                </p>

                                <!-- Barra de Progreso -->
                                <div class="mb-4">
                                    <div class="flex justify-between text-xs mb-1">
                                        <span>Progreso del curso</span>
                                        <span>{{ $progress }}/100</span>
                                    </div>
                                    <progress class="progress progress-primary w-full" value="{{ $progress }}"
                                        max="100"></progress>
                                </div>

                                <!-- Estadísticas del Curso -->
                                <div class="flex justify-between text-xs text-base-content/60 mb-4">
                                    <span>📚 {{ rand(8, 25) }} lecciones</span>
                                    <span>⏱️ {{ rand(2, 8) }}h restantes</span>
                                    <span>🎯 {{ rand(1, 5) }} evaluaciones</span>
                                </div>

                                <div class="card-actions justify-between items-center">
                                    <div class="flex items-center gap-2">
                                        <div class="avatar">
                                            <div
                                                class="w-8 h-8 rounded-full bg-primary text-primary-content flex items-center justify-center">
                                                <span
                                                    class="text-xs font-bold">{{ substr($course->professor->name ?? 'P', 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <span
                                            class="text-xs text-base-content/70">{{ $course->professor->name ?? 'Profesor' }}</span>
                                    </div>

                                    <div class="flex gap-2">
                                        @if ($progress < 100)
                                            <a href="{{ route('courses.show', $course) }}"
                                                class="btn btn-primary btn-sm">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" />
                                                </svg>
                                                Continuar
                                            </a>
                                        @else
                                            <button class="btn btn-success btn-sm">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Certificado
                                            </button>
                                        @endif

                                        <div class="dropdown dropdown-end">
                                            <div tabindex="0" role="button" class="btn btn-ghost btn-sm btn-square">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                </svg>
                                            </div>
                                            <ul tabindex="0"
                                                class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                                <li><a href="{{ route('courses.show', $course) }}">Ver detalles</a>
                                                </li>
                                                <li><a>Descargar certificado</a></li>
                                                <li><a>Calificar curso</a></li>
                                                <li><a class="text-error">Abandonar curso</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación (simulada) -->
                <div class="flex justify-center mt-8">
                    <div class="join">
                        <button class="join-item btn">«</button>
                        <button class="join-item btn btn-active">1</button>
                        <button class="join-item btn">2</button>
                        <button class="join-item btn">3</button>
                        <button class="join-item btn">»</button>
                    </div>
                </div>
            @else
                <!-- Estado Vacío -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body text-center py-16">
                        <svg class="w-24 h-24 mx-auto text-base-content/30 mb-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h3 class="text-2xl font-bold text-base-content mb-4">¡Aún no tienes cursos!</h3>
                        <p class="text-base-content/70 mb-8 max-w-md mx-auto">
                            Comienza tu viaje de aprendizaje explorando nuestro catálogo de cursos disponibles.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="/" class="btn btn-primary">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                                Explorar Cursos
                            </a>
                            <a href="/cursos/secundaria" class="btn btn-outline">Ver por Categorías</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
