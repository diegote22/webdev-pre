<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Cursos') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if(session('status'))
                    <div class="alert alert-success mb-4">
                        {{ session('status') }}
                    </div>
                @endif
            <div class="flex justify-end mb-4">
                    <a href="{{ route('courses.create') }}" class="btn btn-primary">Nuevo curso</a>
            </div>
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('status') }}</div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left border-b">
                                <th class="py-2 pr-4">Título</th>
                                <th class="py-2 pr-4">Categoría</th>
                                <th class="py-2 pr-4">Subcategoría</th>
                                <th class="py-2 pr-4">Precio</th>
                                <th class="py-2 pr-4">Nivel</th>
                                <th class="py-2 pr-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($courses as $course)
                                <tr class="border-b">
                                    <td class="py-2 pr-4">{{ $course->title }}</td>
                                    <td class="py-2 pr-4">{{ $course->category->name ?? '-' }}</td>
                                    <td class="py-2 pr-4">{{ $course->subCategory->name ?? '-' }}</td>
                                    <td class="py-2 pr-4">$ {{ number_format($course->price, 2) }}</td>
                                    <td class="py-2 pr-4">{{ $course->level ?? '-' }}</td>
                                    <td class="py-2 pr-4 space-x-2">
                                        <a href="{{ route('courses.edit', $course) }}"
                                            class="text-indigo-600 hover:underline">Editar</a>
                                        <a href="{{ route('courses.wizard', $course) }}"
                                            class="text-amber-600 hover:underline">Asistente</a>
                                        <form action="{{ route('courses.destroy', $course) }}" method="POST"
                                            class="inline" onsubmit="return confirm('¿Eliminar curso?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:underline"
                                                type="submit">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-center text-gray-500">No tienes cursos aún.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $courses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
