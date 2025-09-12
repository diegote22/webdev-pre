<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Curso') }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="{ tab: 'general', videoType: 'youtube', localName: '' }" x-init="window.initPlyr()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-6">
                <!-- Aside de pestañas verticales -->
                <aside class="col-span-12 lg:col-span-3">
                    <div class="bg-white shadow-sm rounded-lg p-3 space-y-2 sticky top-4">
                        <button @click="tab='general'" :class="tab === 'general' ? 'bg-indigo-50 text-indigo-700' : ''"
                            class="w-full text-left px-3 py-2 rounded">Datos generales</button>
                        <button @click="tab='customize'"
                            :class="tab === 'customize' ? 'bg-indigo-50 text-indigo-700' : ''"
                            class="w-full text-left px-3 py-2 rounded">Personalización</button>
                        <button @click="tab='promo'" :class="tab === 'promo' ? 'bg-indigo-50 text-indigo-700' : ''"
                            class="w-full text-left px-3 py-2 rounded">Video promocional</button>
                        <button @click="tab='goals'" :class="tab === 'goals' ? 'bg-indigo-50 text-indigo-700' : ''"
                            class="w-full text-left px-3 py-2 rounded">Metas del curso</button>
                        <button @click="tab='requirements'"
                            :class="tab === 'requirements' ? 'bg-indigo-50 text-indigo-700' : ''"
                            class="w-full text-left px-3 py-2 rounded">Requisitos del curso</button>
                        <button @click="tab='sections'" :class="tab === 'sections' ? 'bg-indigo-50 text-indigo-700' : ''"
                            class="w-full text-left px-3 py-2 rounded">Secciones del curso</button>
                    </div>
                </aside>

                <!-- Panel principal -->
                <section class="col-span-12 lg:col-span-9">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <!-- General -->
                            <div x-show="tab==='general'">
                                <form method="POST" action="{{ route('courses.store') }}" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-medium">Título</label>
                                        <input name="title" value="{{ old('title') }}"
                                            class="mt-1 w-full border rounded p-2" required>
                                        @error('title')
                                            <p class="text-red-600 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium">Slug</label>
                                        <input name="slug" value="{{ old('slug') }}"
                                            class="mt-1 w-full border rounded p-2" placeholder="mi-curso-unico">
                                        <p class="text-xs text-gray-500 mt-1">Si lo dejas vacío, se generará
                                            automáticamente a partir del título.</p>
                                        @error('slug')
                                            <p class="text-red-600 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium">Descripción</label>
                                        <textarea name="description" class="mt-1 w-full border rounded p-2" rows="4" required>{{ old('description') }}</textarea>
                                        @error('description')
                                            <p class="text-red-600 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium">Categoría</label>
                                            <select name="category_id" class="mt-1 w-full border rounded p-2" required>
                                                <option value="">-- Selecciona --</option>
                                                @foreach ($categories as $cat)
                                                    <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>
                                                        {{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <p class="text-red-600 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium">Subcategoría</label>
                                            <select name="sub_category_id" class="mt-1 w-full border rounded p-2">
                                                <option value="">-- Opcional --</option>
                                                @foreach ($subCategories as $sc)
                                                    <option value="{{ $sc->id }}" @selected(old('sub_category_id') == $sc->id)>
                                                        {{ $sc->category->name }} — {{ $sc->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('sub_category_id')
                                                <p class="text-red-600 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium">Precio</label>
                                            <input name="price" type="number" step="0.01" min="0"
                                                value="{{ old('price', '0.00') }}"
                                                class="mt-1 w-full border rounded p-2" required>
                                            @error('price')
                                                <p class="text-red-600 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium">Nivel</label>
                                            <select name="level" class="mt-1 w-full border rounded p-2">
                                                <option value="">-- Opcional --</option>
                                                @foreach ($levels as $lvl)
                                                    <option value="{{ $lvl }}" @selected(old('level') == $lvl)>
                                                        {{ $lvl }}</option>
                                                @endforeach
                                            </select>
                                            @error('level')
                                                <p class="text-red-600 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium">Resumen</label>
                                        <textarea name="summary" class="mt-1 w-full border rounded p-2" rows="3">{{ old('summary') }}</textarea>
                                        @error('summary')
                                            <p class="text-red-600 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('courses.index') }}"
                                            class="px-4 py-2 bg-gray-100 rounded">Cancelar</a>
                                        <button type="submit"
                                            class="px-4 py-2 bg-indigo-600 text-white rounded">Crear</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Personalización (solo la vista de esa pestaña) -->
                            <div x-show="tab==='customize'" x-cloak>
                                @include('courses.partials.customize')
                            </div>

                            <!-- Video promocional con previsualización (solo esa pestaña) -->
                            <div x-show="tab==='promo'" x-cloak>
                                <div class="space-y-4" x-data="{ yt: '', fileUrl: '' }">
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium">Tipo de video</label>
                                            <select x-model="$root.videoType" class="mt-1 w-full border rounded p-2">
                                                <option value="youtube">YouTube</option>
                                                <option value="local">Archivo local</option>
                                            </select>
                                        </div>
                                        <template x-if="$root.videoType==='youtube'">
                                            <div class="sm:col-span-2">
                                                <label class="block text-sm font-medium">URL de YouTube</label>
                                                <input x-model="yt" class="mt-1 w-full border rounded p-2"
                                                    placeholder="https://www.youtube.com/watch?v=...">
                                            </div>
                                        </template>
                                        <template x-if="$root.videoType==='local'">
                                            <div class="sm:col-span-2">
                                                <label class="block text-sm font-medium">Seleccionar archivo de
                                                    video</label>
                                                <input type="file" accept="video/*"
                                                    @change="fileUrl = URL.createObjectURL($event.target.files[0]); $root.localName=$event.target.files[0]?.name || ''"
                                                    class="mt-1 w-full" />
                                                <p class="text-xs text-gray-500" x-text="$root.localName"></p>
                                            </div>
                                        </template>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium mb-2">Previsualización</label>
                                        <div class="aspect-video bg-black/5 rounded overflow-hidden">
                                            <template x-if="$root.videoType==='youtube' && yt">
                                                <div class="h-full">
                                                    <div class="js-player" data-plyr-provider="youtube"
                                                        :data-plyr-embed-id="(new URL(yt)).searchParams.get('v') || yt">
                                                    </div>
                                                </div>
                                            </template>
                                            <template x-if="$root.videoType==='local' && fileUrl">
                                                <video class="js-player" controls playsinline>
                                                    <source :src="fileUrl" type="video/mp4" />
                                                </video>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Metas (solo esa pestaña) -->
                            <div x-show="tab==='goals'" x-cloak>
                                @include('courses.partials.goals')
                            </div>

                            <!-- Requisitos (solo esa pestaña) -->
                            <div x-show="tab==='requirements'" x-cloak>
                                @include('courses.partials.requirements')
                            </div>

                            <!-- Secciones del curso (solo esa pestaña) -->
                            <div x-show="tab==='sections'" x-cloak>
                                @include('courses.partials.sections')
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
