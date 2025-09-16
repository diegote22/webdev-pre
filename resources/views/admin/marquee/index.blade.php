<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Temas desplazables (Marquee)</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Éxitos via toast global del layout --}}
            @if ($errors->any())
                <div class="alert alert-error">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h3 class="card-title mb-4">Añadir texto</h3>
                    <form method="POST" action="{{ route('admin.marquee.store') }}"
                        class="grid md:grid-cols-4 gap-4 items-end">
                        @csrf
                        <div class="md:col-span-2">
                            <label class="label"><span class="label-text">Texto (ej: Física)</span></label>
                            <input type="text" name="text" maxlength="40" class="input input-bordered w-full"
                                required />
                        </div>
                        <div>
                            <label class="label"><span class="label-text">Orden</span></label>
                            <input type="number" name="order" value="{{ (int) ($items->max('order') + 1) }}"
                                class="input input-bordered w-full" />
                        </div>
                        <div class="flex items-center gap-2 mt-6">
                            <label class="cursor-pointer flex items-center gap-2">
                                <input type="checkbox" name="active" checked class="checkbox checkbox-primary" />
                                <span class="text-sm">Activo</span>
                            </label>
                            <button class="btn btn-primary ml-auto">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h3 class="card-title mb-4">Listado</h3>
                    <div class="space-y-2">
                        @forelse($items as $it)
                            <div class="flex items-center gap-4 p-3 rounded border bg-base-200/50">
                                <span class="text-sm w-10 font-mono">#{{ $it->order }}</span>
                                <span class="font-medium flex-1">{{ $it->text }}</span>
                                <form method="POST" action="{{ route('admin.marquee.toggle', $it) }}">
                                    @csrf
                                    <button class="btn btn-xs {{ $it->active ? 'btn-success' : 'btn-ghost border' }}"
                                        type="submit">{{ $it->active ? 'Activo' : 'Inactivo' }}</button>
                                </form>
                                <form method="POST" action="{{ route('admin.marquee.delete', $it) }}"
                                    onsubmit="return confirm('¿Eliminar?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-error btn-xs">Eliminar</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-sm opacity-70">Sin elementos todavía.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
