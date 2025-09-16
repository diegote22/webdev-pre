<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestión Grilla Portada</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">
            {{-- Mensaje de éxito centralizado en toast global --}}
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
                    <h3 class="card-title mb-4">Añadir / Reemplazar Item</h3>
                    <form method="POST" action="{{ route('admin.homeGrid.store') }}" enctype="multipart/form-data"
                        class="grid md:grid-cols-4 gap-4 items-end">
                        @csrf
                        <div>
                            <label class="label"><span class="label-text">Posición (1-8)</span></label>
                            <select name="order" class="select select-bordered w-full" required>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('order') == $i ? 'selected' : '' }}>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="label"><span class="label-text">Título (opcional)</span></label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                class="input input-bordered w-full" maxlength="100" />
                        </div>
                        <div>
                            <label class="label"><span class="label-text">Archivo (imagen o video)</span></label>
                            <input type="file" name="media" accept="image/*,video/mp4,video/webm"
                                class="file-input file-input-bordered w-full" required />
                        </div>
                        <div class="md:col-span-4">
                            <button class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @for ($slot = 1; $slot <= 10; $slot++)
                    @php $it = $items->get($slot); @endphp
                    <div
                        class="relative group border rounded-lg overflow-hidden bg-base-100 shadow flex items-center justify-center h-64">
                        @if ($it)
                            @if ($it->media_type === 'image')
                                <img src="{{ $it->url }}" class="absolute inset-0 w-full h-full object-cover"
                                    alt="{{ $it->title }}" />
                            @else
                                <video class="absolute inset-0 w-full h-full object-cover" autoplay loop muted
                                    playsinline>
                                    <source src="{{ $it->url }}" type="video/mp4" />
                                </video>
                            @endif
                            <div
                                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex flex-col items-center justify-center gap-3 text-white p-2 text-center">
                                <div class="font-semibold">{{ $it->title ?? 'Sin título' }}</div>
                                <form method="POST" action="{{ route('admin.homeGrid.delete', $it) }}"
                                    onsubmit="return confirm('¿Eliminar este elemento?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-error">Eliminar</button>
                                </form>
                            </div>
                        @else
                            <span class="text-sm opacity-70">Slot {{ $slot }} vacío</span>
                        @endif
                    </div>
                @endfor
            </div>
            <p class="text-sm text-base-content/70">Sugerencia: Usa imágenes con orientación variada (vertical /
                cuadrada) y videos cortos silenciosos para mejor dinamismo.</p>
        </div>
    </div>
</x-app-layout>
