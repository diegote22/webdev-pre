@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <div class="min-h-screen bg-base-100">
        <!-- Breadcrumb -->
        <div class="bg-base-200 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-sm breadcrumbs">
                    <ul>
                        <li><a href="/" class="text-primary hover:text-primary-focus">Inicio</a></li>
                        <li><a href="#" class="text-primary hover:text-primary-focus">Cursos</a></li>
                        <li>{{ $course->title }}</li>
                    </ul>
                </div>
            </div>
                                        <h3 class="text-2xl font-bold">${{ number_format($course->price ?? 0, 2) }} <span class="text-sm font-normal">ARS</span></h3>
                                        <p class="text-xs text-base-content/60 mt-1">Pago único</p>
                    <div class="bg-base-100 rounded-lg shadow-lg p-6">
                        <h1 class="text-3xl font-bold text-base-content mb-4">{{ $course->title }}</h1>

                        <!-- Video/Imagen Principal -->
                        <div class="relative mb-6">
                            @if ($course->has_image)
                                <img src="{{ $course->image_url }}" alt="{{ $course->title }}"
                                    class="w-full h-64 object-cover rounded-lg">
                            @else
                                <div
                                    class="w-full h-64 bg-gradient-to-r from-primary to-secondary rounded-lg flex items-center justify-center">
                                    <div class="text-center text-white">
                                        <svg class="w-16 h-16 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" />
                                        </svg>
                                        <span class="text-lg font-semibold">Video Preview</span>
                                    </div>
                                </div>
                            @endif

                            <!-- Overlay de video si hay promo_video_url -->
                            @if ($course->promo_video_url)
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <button onclick="document.getElementById('promo-modal').showModal()"
                                        class="btn btn-circle btn-lg bg-black/50 border-white text-white hover:bg-black/70">
                                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" />
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>

                        @if ($course->promo_video_url)
                            <dialog id="promo-modal" class="modal">
                                <div class="modal-box w-11/12 max-w-4xl">
                                    <h3 class="font-bold text-lg mb-4">Video promocional</h3>
                                    <div class="aspect-video w-full">
                                        <iframe src="{{ $course->promo_video_url }}" class="w-full h-full"
                                            allowfullscreen></iframe>
                                    </div>
                                    <div class="modal-action">
                                        <form method="dialog">
                                            <button class="btn">Cerrar</button>
                                        </form>
                                    </div>
                                </div>
                            </dialog>
                        @endif

                        <!-- Rating y Info del Instructor -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-4">
                                <div class="rating rating-sm">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <input type="radio" class="mask mask-star-2 bg-orange-400" disabled
                                            @checked($i <= round($course->average_rating)) />
                                    @endfor
                                </div>
                                <span
                                    class="text-sm text-base-content/70">({{ number_format($course->average_rating, 1) }})</span>
                                <span class="text-xs text-base-content/60">{{ $course->reviews_count }} reseña(s)</span>
                            </div>

                            <div class="flex items-center space-x-2">
                                <div class="avatar">
                                    <div class="w-8 h-8 rounded-full">
                                        @php($avatar = $course->professor?->avatar_url)
                                        @if ($avatar)
                                            <img src="{{ $avatar }}" alt="{{ $course->professor->name }}" />
                                        @else
                                            <div
                                                class="w-8 h-8 rounded-full bg-primary text-primary-content flex items-center justify-center">
                                                <span
                                                    class="text-xs font-bold">{{ substr($course->professor->name ?? 'P', 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <span class="text-sm font-medium">Instructor:
                                    {{ $course->professor->name ?? 'Profesor Demo' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="bg-base-100 rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold text-base-content mb-4">Descripción</h2>
                        <p class="text-base-content/80 leading-relaxed">
                            {{ $course->description ?? 'Descripción del curso no disponible.' }}
                        </p>

                        @if ($course->summary)
                            <div class="mt-4">
                                <h3 class="font-semibold text-base-content mb-2">Resumen:</h3>
                                <p class="text-base-content/70">{{ $course->summary }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Metas/Objetivos -->
                    @if ($course->goals->count() > 0)
                        <div class="bg-base-100 rounded-lg shadow-lg p-6">
                            <h2 class="text-xl font-bold text-base-content mb-4">Metas</h2>
                            <ul class="space-y-2">
                                @foreach ($course->goals as $goal)
                                    <li class="flex items-start space-x-2">
                                        <svg class="w-5 h-5 text-success mt-0.5 flex-shrink-0" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-base-content/80">{{ $goal->text }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Requisitos -->
                    @if ($course->requirements->count() > 0)
                        <div class="bg-base-100 rounded-lg shadow-lg p-6">
                            <h2 class="text-xl font-bold text-base-content mb-4">Requisitos</h2>
                            <ul class="space-y-2">
                                @foreach ($course->requirements as $requirement)
                                    <li class="flex items-start space-x-2">
                                        <svg class="w-5 h-5 text-info mt-0.5 flex-shrink-0" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-base-content/80">{{ $requirement->text }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Temas relacionados -->
                    <div class="bg-base-100 rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold text-base-content mb-4">Temas relacionados</h2>
                        <div class="flex flex-wrap gap-2">
                            @if ($course->category)
                                <span class="badge badge-primary">{{ $course->category->name }}</span>
                            @endif
                            @if ($course->subCategory)
                                <span class="badge badge-secondary">{{ $course->subCategory->name }}</span>
                            @endif
                            @if ($course->level)
                                <span class="badge badge-accent">{{ $course->level }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Contenido del Curso -->
                    @if ($course->sections->count() > 0)
                        <div class="bg-base-100 rounded-lg shadow-lg p-6">
                            <h2 class="text-xl font-bold text-base-content mb-4">Contenido del Curso</h2>
                            <div class="space-y-4">
                                @foreach ($course->sections as $section)
                                    <div class="collapse collapse-arrow bg-base-200">
                                        <input type="checkbox" />
                                        <div
                                            class="collapse-title text-lg font-medium flex items-center justify-between">
                                            <span>{{ $section->name }}</span>
                                            <div class="flex items-center space-x-2 text-sm">
                                                @php($mins = $section->lessons->sum('duration'))
                                                <span class="badge badge-ghost">{{ $section->lessons->count() }}
                                                    lecciones</span>
                                                @if ($mins)
                                                    <span class="badge badge-outline">{{ $mins }} min</span>
                                                @endif
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="collapse-content space-y-3">
                                            @if ($section->summary)
                                                <p class="text-sm text-base-content/70">{{ $section->summary }}</p>
                                            @endif
                                            @if ($section->lessons->count() > 0)
                                                <ul class="space-y-2">
                                                    @foreach ($section->lessons as $lesson)
                                                        <li
                                                            class="flex items-center space-x-3 p-2 hover:bg-base-300 rounded">
                                                            <svg class="w-4 h-4 text-success" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" />
                                                            </svg>
                                                            <span
                                                                class="text-sm font-medium">{{ $lesson->title }}</span>
                                                            <div
                                                                class="flex items-center space-x-1 text-xs text-base-content/60">
                                                                @if ($lesson->duration)
                                                                    <svg class="w-3 h-3" fill="currentColor"
                                                                        viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd"
                                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                    <span>{{ $lesson->duration }} min</span>
                                                                @endif
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p class="text-sm text-base-content/60">No hay lecciones disponibles
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Reseñas de estudiantes -->
                    <div class="bg-base-100 rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold text-base-content mb-4">Reseñas de estudiantes</h2>

                        @auth
                            @php($isEnrolled = $course->students->contains(auth()->id()))
                            @if ($isEnrolled)
                                <form method="POST" action="{{ route('courses.review', $course) }}"
                                    class="space-y-3 mb-6">
                                    @csrf
                                    <div class="flex items-center gap-2">
                                        <div class="rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <input type="radio" name="rating"
                                                    class="mask mask-star-2 bg-orange-400" value="{{ $i }}"
                                                    @checked(optional($userReview)->rating == $i) />
                                            @endfor
                                        </div>
                                        <span class="text-sm text-base-content/60">Elige tu puntuación</span>
                                    </div>
                                    <textarea name="comment" class="textarea textarea-bordered w-full" rows="3"
                                        placeholder="Escribe tu reseña (opcional)">{{ old('comment', optional($userReview)->comment) }}</textarea>
                                    <button class="btn btn-primary"
                                        type="submit">{{ $userReview ? 'Actualizar reseña' : 'Enviar reseña' }}</button>
                                </form>
                            @endif
                        @endauth

                        <div class="space-y-4">
                            @forelse($course->reviews->sortByDesc('created_at') as $r)
                                <div class="border rounded p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <div class="avatar placeholder">
                                                <div class="w-8 h-8 rounded-full bg-neutral text-neutral-content">
                                                    <span
                                                        class="text-xs">{{ strtoupper(substr($r->user->name, 0, 1)) }}</span>
                                                </div>
                                            </div>
                                            <div class="font-medium">{{ $r->user->name }}</div>
                                        </div>
                                        <div class="rating rating-sm">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <input type="radio" class="mask mask-star-2 bg-orange-400" disabled
                                                    @checked($i <= (int) $r->rating) />
                                            @endfor
                                        </div>
                                    </div>
                                    @if ($r->comment)
                                        <p class="mt-2 text-sm text-base-content/80">{{ $r->comment }}</p>
                                    @endif
                                    <div class="text-xs text-base-content/60 mt-1">
                                        {{ $r->created_at->diffForHumans() }}</div>
                                </div>
                            @empty
                                <p class="text-sm text-base-content/60">Aún no hay reseñas.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-4 space-y-6">

                        <!-- Card de Compra -->
                        <div class="bg-base-100 rounded-lg shadow-lg p-6">
                            <div class="text-center mb-6">
                                <div class="text-4xl font-bold text-primary mb-2">
                                    ${{ number_format($course->price ?? 0, 2) }}
                                    <span class="text-sm font-normal text-base-content/60">ARS</span>
                                </div>
                                @if ($course->price > 0)
                                    <div class="text-sm text-base-content/60 line-through">
                                        ${{ number_format(($course->price ?? 0) * 1.3, 2) }} ARS
                                    </div>
                                @endif
                            </div>

                            <div class="space-y-3 mb-6">
                                <button class="btn btn-primary w-full">Añadir al carrito</button>
                                <button class="btn btn-outline w-full">Comprar ahora</button>
                            </div>

                            <div class="text-center text-sm text-base-content/60 mb-4">Incluye</div>

                            <div class="space-y-3">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-success" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" />
                                    </svg>
                                    @php($totalMins = $course->sections->sum(fn($s) => $s->lessons->sum('duration')))
                                    @php($hours = intdiv($totalMins, 60))
                                    @php($mins = $totalMins % 60)
                                    <span class="text-sm">{{ $hours }}h {{ $mins }}m de video</span>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-success" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm">Acceso en dispositivos móviles</span>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-success" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm">Material descargable</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
