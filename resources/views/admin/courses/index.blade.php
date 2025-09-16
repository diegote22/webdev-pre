<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Revisión de Cursos</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost">Volver</a>
        </div>

        <form method="GET" action="{{ route('admin.courses') }}" class="mb-4 flex gap-3 items-end">
            <div>
                <label class="label">Estado</label>
                <select name="status" class="select select-bordered w-48">
                    <option value="">Todos</option>
                    @foreach (['pending' => 'Pendiente', 'under_review' => 'En revisión', 'published' => 'Publicado', 'unpublished' => 'Despublicado', 'rejected' => 'Rechazado'] as $k => $v)
                        <option value="{{ $k }}" @selected(($status ?? '') === $k)>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <label class="label">Buscar</label>
                <input type="text" name="q" value="{{ $q ?? '' }}" class="input input-bordered w-full"
                    placeholder="Título o descripción" />
            </div>
            <button class="btn btn-primary">Filtrar</button>
        </form>

        <div class="overflow-x-auto bg-base-100 shadow rounded-lg">
            <table class="table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Profesor</th>
                        <th>Categoría</th>
                        <th>Subcategoría</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th>Creado</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr>
                            <td class="font-semibold">{{ $course->title }}</td>
                            <td>{{ $course->professor->name ?? '—' }}</td>
                            <td>{{ $course->category->name ?? '—' }}</td>
                            <td>{{ $course->subCategory->name ?? '—' }}</td>
                            <td>${{ number_format($course->price, 2) }}</td>
                            <td>
                                @php($st = $course->status)
                                <span
                                    class="badge {{ match ($st) {'published' => 'badge-success','pending' => '','under_review' => 'badge-warning','rejected' => 'badge-error','unpublished' => 'badge-ghost',default => ''} }}">
                                    {{ [
                                        'pending' => 'Pendiente',
                                        'under_review' => 'En revisión',
                                        'published' => 'Publicado',
                                        'unpublished' => 'Despublicado',
                                        'rejected' => 'Rechazado',
                                    ][$st] ?? $st }}
                                </span>
                            </td>
                            <td>{{ $course->created_at?->format('Y-m-d') }}</td>
                            <td class="text-right">
                                <div class="join">
                                    @if ($course->status !== 'published')
                                        <form method="POST" action="{{ route('admin.courses.publish', $course) }}"
                                            onsubmit="return confirm('¿Publicar este curso?')">
                                            @csrf
                                            <button class="btn btn-success btn-sm join-item">Publicar</button>
                                        </form>
                                    @endif
                                    @if ($course->status === 'published')
                                        <form method="POST" action="{{ route('admin.courses.unpublish', $course) }}"
                                            onsubmit="return confirm('¿Despublicar este curso?')">
                                            @csrf
                                            <button class="btn btn-warning btn-sm join-item">Despublicar</button>
                                        </form>
                                    @endif
                                    @if ($course->status !== 'under_review')
                                        <form method="POST"
                                            action="{{ route('admin.courses.underReview', $course) }}">
                                            @csrf
                                            <button class="btn btn-info btn-sm join-item">Marcar en revisión</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.courses.reject', $course) }}"
                                        onsubmit="return confirm('¿Rechazar este curso?')" class="join-item">
                                        @csrf
                                        <input type="hidden" name="reason" value="Contenido insuficiente" />
                                        <button class="btn btn-error btn-sm">Rechazar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-gray-500 p-6">No hay cursos disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $courses->links() }}</div>
    </div>
</x-app-layout>
