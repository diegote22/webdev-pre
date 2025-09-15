@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <!-- Hero con buscador -->
    <div class="bg-gradient-to-r from-primary/10 to-primary/20 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-base-content mb-4">Buscar cursos</h1>
            <form action="{{ route('courses.search') }}" method="GET" class="w-full">
                <div class="join w-full">
                    <input type="text" name="q" value="{{ $q }}"
                        class="input input-bordered join-item w-full outline-none focus:outline-none focus:ring-0 focus:border-primary"
                        placeholder="Que curso estas buscando..." />
                    <button type="submit" class="btn btn-primary join-item">Buscar</button>
                </div>
            </form>
            @if ($q)
                <p class="mt-3 text-base-content/70">Resultados para: <span
                        class="font-semibold">"{{ $q }}"</span></p>
            @endif
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
                                        class="w-full h-48 bg-gradient-to-r from-primary to-secondary flex items-center justify-center transition-all duration-300">
                                        <span
                                            class="text-white font-bold text-lg text-center px-4 group-hover:scale-105 transition-transform duration-300">{{ $course->title }}</span>
                                    </div>
                                @endif
                            </figure>

                            <div class="card-body">
                                <h2 class="card-title text-lg group-hover:text-primary transition-colors duration-300">
                                    {{ $course->title }}
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
                                        <div class="text-2xl font-bold text-primary">
                                            ${{ number_format($course->price ?? 0, 2) }}
                                        </div>
                                        <span class="text-sm text-base-content/60">ARS</span>
                                    </div>
                                </div>

                                <div class="card-actions justify-end mt-4">
                                    <a href="{{ route('courses.show', $course) }}" class="btn btn-primary btn-sm">
                                        Ver Curso
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 flex justify-center">
                    {{ $courses->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto bg-base-100 rounded-lg shadow-lg p-8">
                        <svg class="mx-auto h-20 w-20 text-base-content/40" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                        <h3 class="mt-6 text-xl font-semibold text-base-content">No encontramos cursos</h3>
                        @if ($q)
                            <p class="mt-2 text-base-content/70">Intenta con otro término o revisa la ortografía de
                                "{{ $q }}".</p>
                        @else
                            <p class="mt-2 text-base-content/70">Empieza buscando por tema, categoría o profesor.</p>
                        @endif
                        <div class="mt-6">
                            <a href="/" class="btn btn-primary">Volver al Inicio</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
