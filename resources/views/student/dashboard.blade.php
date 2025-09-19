@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <div class="min-h-screen bg-base-200">
        <!-- Hero Section de Bienvenida -->
        <div class="hero bg-gradient-to-r from-primary to-secondary text-primary-content py-12">
            <div class="hero-content text-center max-w-4xl">
                <div>
                    <div class="avatar mb-4">
                        <div
                            class="w-24 h-24 rounded-full overflow-hidden bg-base-100 text-base-content flex items-center justify-center">
                            @if ($user->avatar_path)
                                <img src="{{ Storage::url($user->avatar_path) }}" alt="{{ $user->name }}"
                                    class="w-full h-full object-cover" />
                            @elseif ($user->profile_photo_path)
                                <img src="{{ Storage::url($user->profile_photo_path) }}" alt="{{ $user->name }}"
                                    class="w-full h-full object-cover" />
                            @else
                                <span class="text-2xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                            @endif
                        </div>
                    </div>
                    <h1 class="text-4xl font-bold mb-4 heading-font">¡Bienvenido de vuelta, {{ $user->name }}!</h1>
                    <p class="text-lg opacity-90 mb-6 text-font">Continúa tu viaje de aprendizaje. Tienes
                        {{ $inProgressCourses }}
                        cursos en progreso.</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('student.my-courses') }}" class="btn btn-accent btn-lg">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Mis Cursos
                        </a>
                        <a href="#recommended" class="btn btn-outline btn-lg">Explorar Cursos</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Estadísticas del Estudiante -->
            <div class="stats stats-vertical lg:stats-horizontal shadow-xl bg-base-100 w-full mb-8">
                <div class="stat">
                    <div class="stat-figure text-primary">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="stat-title">Cursos Matriculados</div>
                    <div class="stat-value text-primary">{{ $totalCourses }}</div>
                    <div class="stat-desc">{{ $completedCourses }} completados</div>
                </div>

                <div class="stat">
                    <div class="stat-figure text-secondary">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="stat-title">Horas Estudiadas</div>
                    <div class="stat-value text-secondary">{{ $totalHours }}</div>
                    <div class="stat-desc">↗︎ 8 horas esta semana</div>
                </div>

                <div class="stat">
                    <div class="stat-figure text-accent">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="stat-title">Progreso General</div>
                    <div class="stat-value text-accent">{{ round(($completedCourses / $totalCourses) * 100) }}%</div>
                    <div class="stat-desc">{{ $inProgressCourses }} en progreso</div>
                </div>

                <div class="stat">
                    <div class="stat-figure text-warning">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="stat-title">Certificados</div>
                    <div class="stat-value text-warning">{{ $completedCourses }}</div>
                    <div class="stat-desc">Obtenidos</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Columna Principal -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Continuar Aprendiendo -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h2 class="card-title flex items-center">
                                <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" />
                                </svg>
                                Continuar Aprendiendo
                            </h2>

                            @if ($recentCourses->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($recentCourses->take(2) as $course)
                                        <div
                                            class="card card-compact bg-base-200 shadow-md hover:shadow-lg transition-shadow">
                                            @if ($course->has_image)
                                                <figure class="h-32">
                                                    <img src="{{ $course->image_url }}" alt="{{ $course->title }}"
                                                        class="w-full h-full object-cover">
                                                </figure>
                                            @else
                                                <figure
                                                    class="h-32 bg-gradient-to-r from-primary to-secondary flex items-center justify-center">
                                                    <svg class="w-12 h-12 text-white" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" />
                                                    </svg>
                                                </figure>
                                            @endif
                                            <div class="card-body">
                                                <h3 class="card-title text-sm">{{ $course->title }}</h3>
                                                <p class="text-xs opacity-70">
                                                    {{ $course->category->name ?? 'Categoría' }}</p>
                                                <div class="flex items-center justify-between mt-2">
                                                    <div class="text-xs">
                                                        <progress class="progress progress-primary w-20" value="70"
                                                            max="100"></progress>
                                                        <span class="ml-1">70%</span>
                                                    </div>
                                                    <a href="{{ route('courses.show', $course) }}"
                                                        class="btn btn-primary btn-xs">Continuar</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-16 h-16 mx-auto text-base-content/30 mb-4" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-base-content/60">¡Aún no tienes cursos! Explora nuestro catálogo.</p>
                                    <a href="/" class="btn btn-primary mt-4">Explorar Cursos</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Cursos Recomendados -->
                    <div class="card bg-base-100 shadow-xl" id="recommended">
                        <div class="card-body">
                            <h2 class="card-title flex items-center">
                                <svg class="w-6 h-6 text-secondary" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM15.657 6.343a1 1 0 011.414 0A9.972 9.972 0 0119 12a9.972 9.972 0 01-1.929 5.657 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 12c0-1.944-.694-3.731-1.843-5.121a1 1 0 010-1.415z"
                                        clip-rule="evenodd" />
                                </svg>
                                Cursos Recomendados Para Ti
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($recommendedCourses->take(4) as $course)
                                    <div
                                        class="card card-compact bg-base-200 shadow-md hover:shadow-lg transition-all hover:scale-105">
                                        @if ($course->has_image)
                                            <figure class="h-32">
                                                <img src="{{ $course->image_url }}" alt="{{ $course->title }}"
                                                    class="w-full h-full object-cover">
                                            </figure>
                                        @else
                                            <figure
                                                class="h-32 bg-gradient-to-r from-secondary to-accent flex items-center justify-center">
                                                <svg class="w-12 h-12 text-white" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </figure>
                                        @endif
                                        <div class="card-body">
                                            <h3 class="card-title text-sm">{{ $course->title }}</h3>
                                            <p class="text-xs opacity-70">{{ $course->category->name ?? 'Categoría' }}
                                            </p>
                                            <div class="flex items-center justify-between mt-2">
                                                <div class="badge badge-primary">{{ $course->level ?? 'Intermedio' }}
                                                </div>
                                                <a href="{{ route('courses.show', $course) }}"
                                                    class="btn btn-secondary btn-xs">Ver Curso</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">

                    <!-- Acciones Rápidas -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h3 class="card-title text-lg">Acciones Rápidas</h3>
                            <div class="space-y-3">
                                <a href="{{ route('student.my-courses') }}"
                                    class="btn btn-outline w-full justify-start">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Mis Cursos
                                </a>
                                <a href="{{ route('student.profile') }}"
                                    class="btn btn-outline w-full justify-start">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Editar Perfil
                                </a>
                                <a href="{{ route('student.messages') }}"
                                    class="btn btn-outline w-full justify-start">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                    Mensajes
                                    <div class="badge badge-primary badge-sm">3</div>
                                </a>
                                <a href="/" class="btn btn-outline w-full justify-start">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Explorar Cursos
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Progreso Semanal -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h3 class="card-title text-lg flex items-center">
                                <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                Progreso Semanal
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span>Horas estudiadas</span>
                                        <span>8/10 hrs</span>
                                    </div>
                                    <progress class="progress progress-primary" value="80"
                                        max="100"></progress>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span>Lecciones completadas</span>
                                        <span>12/15</span>
                                    </div>
                                    <progress class="progress progress-secondary" value="80"
                                        max="100"></progress>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span>Evaluaciones</span>
                                        <span>3/4</span>
                                    </div>
                                    <progress class="progress progress-accent" value="75"
                                        max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Logros Recientes -->
                    <div class="card bg-gradient-to-br from-yellow-400 to-orange-500 text-white shadow-xl">
                        <div class="card-body">
                            <h3 class="card-title flex items-center">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                ¡Logro Desbloqueado!
                            </h3>
                            <div class="text-center">
                                <div class="text-4xl mb-2">🎉</div>
                                <p class="font-semibold">Estudiante Dedicado</p>
                                <p class="text-sm opacity-90">Completaste 5 lecciones consecutivas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
