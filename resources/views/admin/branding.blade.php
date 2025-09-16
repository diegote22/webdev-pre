<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Branding</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost">Volver</a>
        </div>

        {{-- Éxitos se muestran con el toast global --}}

        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">Hero actual</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Imagen</p>
                        @if (!empty($heroImagePath))
                            <img src="{{ Storage::url($heroImagePath) }}" class="rounded-lg border" />
                        @else
                            <div class="p-6 border rounded-lg text-gray-500">Sin imagen configurada</div>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Video</p>
                        @if (!empty($heroVideoPath))
                            <video src="{{ Storage::url($heroVideoPath) }}" controls
                                class="w-full rounded-lg border"></video>
                        @else
                            <div class="p-6 border rounded-lg text-gray-500">Sin video configurado</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.branding.save') }}" enctype="multipart/form-data"
            class="card bg-base-100 shadow p-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="label"><span class="label-text">Imagen del Hero (JPG/PNG)</span></label>
                    <input type="file" name="hero_image" accept="image/*"
                        class="file-input file-input-bordered w-full" />
                    @error('hero_image')
                        <div class="text-error text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="label"><span class="label-text">Video del Hero (MP4/WebM)</span></label>
                    <input type="file" name="hero_video" accept="video/mp4,video/webm"
                        class="file-input file-input-bordered w-full" />
                    @error('hero_video')
                        <div class="text-error text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</x-app-layout>
