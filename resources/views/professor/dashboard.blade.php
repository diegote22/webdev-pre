@php($user = $user ?? \Illuminate\Support\Facades\Auth::user())

<x-app-layout>
    <div class="min-h-screen bg-base-200">
        <div class="bg-base-100 border-b border-base-300">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold heading-font">Mi Panel</h1>
                    <p class="text-base-content/70 mt-1 text-font">Bienvenido, {{ $user->name }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('courses.create') }}" class="btn btn-primary">+ Nuevo curso</a>
                    <a href="{{ route('instructor.courses.index') }}" class="btn">Ir a Mis cursos</a>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
            <!-- Tarjetas de métricas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="card bg-base-100 shadow">
                    <div class="card-body">
                        <div class="text-sm opacity-70">Cursos totales</div>
                        <div class="text-3xl font-bold">{{ $stats['total'] }}</div>
                    </div>
                </div>
                <a href="{{ route('instructor.courses.index', ['status' => 'published']) }}"
                    class="card bg-base-100 shadow hover:bg-base-300/20 transition">
                    <div class="card-body">
                        <div class="text-sm opacity-70">Publicados</div>
                        <div class="text-3xl font-bold text-success">{{ $stats['published'] }}</div>
                    </div>
                </a>
                <a href="{{ route('instructor.courses.index', ['status' => 'under_review']) }}"
                    class="card bg-base-100 shadow hover:bg-base-300/20 transition">
                    <div class="card-body">
                        <div class="text-sm opacity-70">En revisión</div>
                        <div class="text-3xl font-bold text-warning">{{ $stats['under_review'] }}</div>
                    </div>
                </a>
                <div class="card bg-base-100 shadow">
                    <div class="card-body">
                        <div class="text-sm opacity-70">Alumnos totales</div>
                        <div class="text-3xl font-bold">{{ $totalStudents }}</div>
                    </div>
                </div>
            </div>

            <!-- Accesos rápidos -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('courses.index') }}" class="card bg-base-100 hover:bg-base-300/20 transition shadow">
                    <div class="card-body">
                        <div class="font-bold">Gestionar cursos</div>
                        <div class="text-sm opacity-70">Crear, editar, subir materiales</div>
                    </div>
                </a>
                <a href="{{ route('instructor.courses.index') }}"
                    class="card bg-base-100 hover:bg-base-300/20 transition shadow">
                    <div class="card-body">
                        <div class="font-bold">Mis cursos</div>
                        <div class="text-sm opacity-70">Listado y edición rápida</div>
                    </div>
                </a>
                <a href="{{ route('notifications.index') }}"
                    class="card bg-base-100 hover:bg-base-300/20 transition shadow relative">
                    <div class="card-body">
                        <div class="font-bold">Notificaciones</div>
                        <div class="text-sm opacity-70">Mensajes y avisos del sistema</div>
                        @if (($unread ?? 0) > 0)
                            <span class="badge badge-error absolute top-2 right-2">{{ $unread }}</span>
                        @endif
                    </div>
                </a>
            </div>

            <!-- Recientes -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="card-title">Actividad reciente</h2>
                        <a href="{{ route('courses.index') }}" class="link">Ver todos</a>
                    </div>
                    @if ($recentCourses->isEmpty())
                        <div class="text-base-content/70">Todavía no tienes actividad reciente.</div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Curso</th>
                                        <th class="hidden sm:table-cell">Estado</th>
                                        <th class="hidden sm:table-cell">Actualizado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($statusClasses = ['published' => 'success', 'under_review' => 'warning', 'pending' => 'info', 'rejected' => 'error'])
                                    @foreach ($recentCourses as $course)
                                        <tr>
                                            <td class="font-medium">{{ $course->title }}</td>
                                            <td class="hidden sm:table-cell">
                                                <span
                                                    class="badge badge-{{ $statusClasses[$course->status] ?? 'neutral' }}">{{ str_replace('_', ' ', $course->status) }}</span>
                                            </td>
                                            <td class="hidden sm:table-cell">{{ $course->updated_at->diffForHumans() }}
                                            </td>
                                            <td>
                                                <a href="{{ route('courses.edit', $course->id) }}"
                                                    class="btn btn-sm">Editar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
