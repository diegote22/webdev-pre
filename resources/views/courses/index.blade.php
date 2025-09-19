@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight heading-font">
            {{ __('Mis Cursos') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="alert alert-success mb-4">
                    {{ session('status') }}
                </div>
            @endif
            <div class="flex justify-end mb-4">
                <a href="{{ route('courses.create') }}" class="btn btn-primary">Nuevo curso</a>
            </div>
            {{-- Mensaje movido arriba para evitar duplicados --}}
            <div class="bg-base-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-base-content">
                    @if ($courses->count())
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($courses as $course)
                                <div class="card bg-base-100 w-full shadow-sm">
                                    <figure>
                                        @if ($course->has_image)
                                            <img src="{{ $course->image_url }}" alt="{{ $course->title }}"
                                                class="w-full h-48 object-cover" />
                                        @else
                                            <div class="w-full h-48 bg-base-200 flex items-center justify-center">
                                                <div class="text-center">
                                                    <svg class="mx-auto h-12 w-12 text-base-content/40" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <p class="mt-2 text-sm text-base-content/60">Imagen no disponible
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    </figure>
                                    <div class="card-body">
                                        <h2 class="card-title">
                                            {{ $course->title }}
                                            <div class="badge badge-secondary">NEW</div>
                                        </h2>

                                        <p class="text-sm text-base-content/80">
                                            {{ Str::limit($course->description ?? ($course->subtitle ?? 'Sin descripción'), 120) }}
                                        </p>

                                        <div class="card-actions justify-between items-center mt-4">
                                            <div class="flex items-center space-x-2">
                                                <div class="text-xs text-base-content/70">
                                                    {{ $course->category->name ?? '-' }}</div>
                                                @if (!empty($course->subCategory->name))
                                                    <div class="badge badge-outline">{{ $course->subCategory->name }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="flex items-center space-x-2">
                                                <div class="text-sm font-medium">$
                                                    {{ number_format($course->price ?? 0, 2) }}</div>
                                            </div>
                                        </div>

                                        <div class="card-actions justify-end mt-2">
                                            <a href="{{ route('courses.edit', $course) }}"
                                                class="btn btn-ghost btn-sm">Editar</a>
                                            <a href="{{ route('courses.wizard', $course) }}"
                                                class="btn btn-outline btn-sm">Asistente</a>
                                            @if ($course->status !== 'published')
                                                <form method="POST" action="{{ route('courses.publish', $course) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                        class="btn btn-success btn-sm">Publicar</button>
                                                </form>
                                            @else
                                                <form method="POST"
                                                    action="{{ route('courses.unpublish', $course) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                        class="btn btn-warning btn-sm">Ocultar</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $courses->links() }}
                        </div>
                    @else
                        <div class="py-8 text-center text-base-content/60">No tienes cursos aún.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
