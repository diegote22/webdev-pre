<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Alumnos') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.students') }}"
                        class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div>
                            <label class="label"><span class="label-text">Buscar</span></label>
                            <input type="text" name="q" value="{{ $q }}"
                                class="input input-bordered w-full" placeholder="Nombre o Email" />
                        </div>
                        <div>
                            <label class="label"><span class="label-text">Grupo</span></label>
                            <select name="group" class="select select-bordered w-full">
                                <option value="">Todos</option>
                                @foreach ($groups as $g)
                                    <option value="{{ $g }}" @selected($group === $g)>{{ $g }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <button class="btn btn-primary">Filtrar</button>
                            <a href="{{ route('admin.students') }}" class="btn btn-ghost ml-2">Limpiar</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card bg-base-100 shadow">
                <div class="card-body overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Grupo</th>
                                <th class="text-right">Cursos matriculados</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->student_group ?? '—' }}</td>
                                    <td class="text-right">{{ $student->courses_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center opacity-70">No hay alumnos para los filtros
                                        aplicados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">{{ $students->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
