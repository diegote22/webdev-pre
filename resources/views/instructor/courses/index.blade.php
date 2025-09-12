<x-instructor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mis cursos</h2>
    </x-slot>

    <x-container class="py-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-end mb-4">
                <a href="{{ route('instructor.courses.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Nuevo
                    curso</a>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2 pr-4">Título</th>
                        <th class="py-2 pr-4">Categoría</th>
                        <th class="py-2 pr-4">Nivel</th>
                        <th class="py-2 pr-4">Precio</th>
                        <th class="py-2 pr-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr class="border-b">
                            <td class="py-2 pr-4">{{ $course->title }}</td>
                            <td class="py-2 pr-4">{{ $course->category?->name ?? '-' }}</td>
                            <td class="py-2 pr-4">{{ $course->level ?? '-' }}</td>
                            <td class="py-2 pr-4">
                                {{ $course->price ? '$ ' . number_format($course->price, 2) : 'Gratis' }}</td>
                            <td class="py-2 pr-4 space-x-2">
                                <a href="{{ route('instructor.courses.edit', $course) }}"
                                    class="text-indigo-600 hover:underline">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="py-4 text-center text-gray-500" colspan="5">No tienes cursos aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-container>
</x-instructor-layout>
