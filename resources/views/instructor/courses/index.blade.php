<x-instructor-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl">Mis cursos</h2>
            <a href="{{ route('instructor.courses.create') }}" class="btn btn-primary">+ Nuevo curso</a>
        </div>
    </x-slot>

    <x-container class="py-8">
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <div class="tabs tabs-boxed w-full overflow-x-auto">
                    @php(
    $statuses = [
        null => 'Todos',
        'published' => 'Publicados',
        'under_review' => 'En revisión',
        'pending' => 'Borradores',
        'rejected' => 'Rechazados',
        'unpublished' => 'No listados',
    ],
)
                    @foreach ($statuses as $key => $label)
                        <a class="tab {{ ($status ?? null) == $key ? 'tab-active' : '' }}"
                            href="{{ $key ? route('instructor.courses.index', ['status' => $key]) : route('instructor.courses.index') }}">{{ $label }}</a>
                    @endforeach
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th class="hidden md:table-cell">Estado</th>
                                <th class="hidden md:table-cell">Categoría</th>
                                <th class="hidden md:table-cell">Nivel</th>
                                <th>Precio</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($badgeMap = ['published' => 'success', 'under_review' => 'warning', 'pending' => 'info', 'rejected' => 'error', 'unpublished' => 'neutral'])
                            @forelse($courses as $course)
                                <tr>
                                    <td class="font-medium">{{ $course->title }}</td>
                                    <td class="hidden md:table-cell">
                                        <span class="badge badge-{{ $badgeMap[$course->status] ?? 'neutral' }}">
                                            {{ str_replace('_', ' ', $course->status ?? '—') }}
                                        </span>
                                    </td>
                                    <td class="hidden md:table-cell">{{ $course->category?->name ?? '—' }}</td>
                                    <td class="hidden md:table-cell">{{ $course->level ?? '—' }}</td>
                                    <td>{{ $course->price ? '$ ' . number_format($course->price, 2) : 'Gratis' }}</td>
                                    <td class="text-right">
                                        <div class="join">
                                            <a href="{{ route('instructor.courses.edit', $course) }}"
                                                class="btn btn-sm join-item">Editar</a>
                                            <a href="{{ route('courses.wizard', $course) }}"
                                                class="btn btn-sm btn-ghost join-item">Asistente</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center opacity-70 py-8">No tienes cursos aún.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-container>
</x-instructor-layout>
