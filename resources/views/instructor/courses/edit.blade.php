<x-instructor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar curso: {{ $course->title }}</h2>
    </x-slot>

    <x-container class="py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                <h2 class="text-2xl font-bold text-white">Editar Curso: {{ $course->title }}</h2>
                <p class="text-indigo-100 mt-1">Actualiza los detalles de tu curso</p>
            </div>
            <div class="p-6">

                <form action="{{ route('instructor.courses.update', $course) }}" method="POST"
                    enctype="multipart/form-data" x-data="courseEditForm()">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Columna Izquierda -->
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="title" value="Título del Curso"
                                    class="text-lg font-semibold text-gray-700" />
                                <x-text-input id="title" name="title" type="text"
                                    class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                    x-model="title" x-on:input="updateSlug()" required />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="slug" value="Slug (URL amigable)"
                                    class="text-lg font-semibold text-gray-700" />
                                <x-text-input id="slug" name="slug" type="text"
                                    class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                    x-model="slug" required />
                                <p class="text-sm text-gray-500 mt-1">Se genera automáticamente, pero puedes editarlo
                                </p>
                                <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="category_id" value="Categoría"
                                        class="text-lg font-semibold text-gray-700" />
                                    <select id="category_id" name="category_id"
                                        class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200">
                                        <option value="">Selecciona categoría</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected(old('category_id', $course->category_id) == $category->id)>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="level" value="Nivel"
                                        class="text-lg font-semibold text-gray-700" />
                                    <select id="level" name="level"
                                        class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200">
                                        <option value="">Selecciona nivel</option>
                                        @foreach ($levels as $level)
                                            <option value="{{ $level }}" @selected(old('level', $course->level) == $level)>
                                                {{ $level }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('level')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="price" value="Precio (USD)"
                                    class="text-lg font-semibold text-gray-700" />
                                <x-text-input id="price" name="price" type="number" step="0.01" min="0"
                                    class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                    value="{{ old('price', $course->price) }}" placeholder="0.00 para gratis" />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="summary" value="Resumen breve"
                                    class="text-lg font-semibold text-gray-700" />
                                <textarea id="summary" name="summary"
                                    class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                    rows="3" placeholder="Describe brevemente el curso">{{ old('summary', $course->summary) }}</textarea>
                                <x-input-error :messages="$errors->get('summary')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Columna Derecha -->
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="description" value="Descripción completa"
                                    class="text-lg font-semibold text-gray-700" />
                                <textarea id="description" name="description"
                                    class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                    rows="8" placeholder="Describe detalladamente el contenido del curso">{{ old('description', $course->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- Imagen del Curso -->
                            <div
                                class="bg-gray-50 rounded-lg p-6 border-2 border-dashed border-gray-300 hover:border-indigo-400 transition duration-200">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <div class="mt-4">
                                        <x-input-label for="image" value="Imagen del curso"
                                            class="text-lg font-semibold text-gray-700 cursor-pointer" />
                                        <input id="image" name="image" type="file" accept="image/*"
                                            class="hidden" x-on:change="preview($event)" />
                                        <p class="text-sm text-gray-500">PNG, JPG hasta 2MB</p>
                                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-center">
                                    <img x-ref="preview"
                                        src="{{ $course->has_image ? $course->image_url : 'https://placehold.co/400x225?text=Previsualización' }}"
                                        alt="Preview" class="w-full max-w-sm rounded-lg shadow-md border" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between items-center">
                        <a href="{{ route('instructor.courses.index') }}"
                            class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-200 shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Volver
                        </a>
                        <div class="flex space-x-4">
                            <a href="{{ route('courses.wizard', $course) }}"
                                class="inline-flex items-center px-6 py-3 border border-indigo-300 rounded-lg text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition duration-200 shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Abrir Asistente
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-sm font-semibold">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Guardar Cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </x-container>

    <script>
        function courseEditForm() {
            return {
                title: @js(old('title', $course->title)),
                slug: @js(old('slug', $course->slug)),
                prevSlug: @js(old('slug', $course->slug)),
                updateSlug() {
                    if (!this.slug || this.slug === this.prevSlug) {
                        this.slug = this.string_to_slug(this.title)
                        this.prevSlug = this.slug
                    }
                },
                string_to_slug(str) {
                    str = str.trim().toLowerCase()
                    const from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;"
                    const to = "aaaaaeeeeeiiiiooooouuuunc------"
                    for (let i = 0, l = from.length; i < l; i++) {
                        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i))
                    }
                    return str.replace(/[^a-z0-9 -]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                },
                preview(e) {
                    const file = e.target.files[0]
                    if (!file) return

                    // Validación en frontend
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png']
                    const maxSize = 2 * 1024 * 1024 // 2MB

                    if (!allowedTypes.includes(file.type)) {
                        alert('Solo se permiten archivos JPG, JPEG o PNG.')
                        e.target.value = ''
                        return
                    }

                    if (file.size > maxSize) {
                        alert('El archivo no debe superar los 2MB.')
                        e.target.value = ''
                        return
                    }

                    const reader = new FileReader()
                    reader.onload = () => this.$refs.preview.src = reader.result
                    reader.readAsDataURL(file)
                }
            }
        }
        document.addEventListener('DOMContentLoaded', () => {
            if (window.ClassicEditor && document.querySelector('#description')) {
                ClassicEditor.create(document.querySelector('#description')).catch(() => {})
            }
        })
    </script>
    <!-- CKEditor CDN opcional -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
</x-instructor-layout>
