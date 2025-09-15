@if (isset($course))
    <form method="POST" action="{{ route('courses.customize.save', $course) }}" enctype="multipart/form-data"
        class="space-y-6" x-data="coverForm({ initial: @js(!empty($course->image_path) ? Storage::url($course->image_path) : null) })">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <div class="lg:col-span-2 space-y-6">
                <div>
                    <label class="block text-sm font-medium text-base-content">Slug del curso</label>
                    <input name="slug"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="mi-curso-unico" value="{{ old('slug', $course->slug) }}">
                    <p class="text-xs text-base-content/60 mt-1">Si lo dejas vacío se generará automáticamente a partir
                        del título.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-base-content">Imagen de portada</label>
                    <input type="file" name="image" accept="image/*" class="mt-1" @change="preview($event)" />
                    <p class="text-xs text-base-content/60 mt-1">PNG/JPG hasta 2MB.</p>
                </div>

                <div class="flex justify-end">
                    <button
                        class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-sm"
                        type="submit">Guardar</button>
                </div>
            </div>

            <div>
                <div class="bg-gray-50 rounded-lg p-4 border">
                    <p class="text-sm text-base-content/70 mb-2">Previsualización</p>
                    <img x-ref="cover" :src="current || 'https://placehold.co/640x360?text=Portada'" alt="Portada"
                        class="w-full rounded-lg border shadow-sm" />
                </div>
            </div>
        </div>
    </form>
    <script>
        function coverForm({
            initial
        }) {
            return {
                current: initial,
                preview(e) {
                    const file = e.target.files?.[0]
                    if (!file) return
                    const allowed = ['image/png', 'image/jpeg', 'image/jpg']
                    if (!allowed.includes(file.type)) {
                        alert('Formato no soportado. Usa PNG o JPG.')
                        e.target.value = ''
                        return
                    }
                    if (file.size > 2 * 1024 * 1024) {
                        alert('El archivo supera 2MB.')
                        e.target.value = ''
                        return
                    }
                    const reader = new FileReader()
                    reader.onload = () => {
                        this.current = reader.result;
                        this.$refs.cover.src = this.current
                    }
                    reader.readAsDataURL(file)
                }
            }
        }
    </script>
@else
    <p class="text-sm text-base-content/70">Primero crea el curso desde la pestaña "Datos generales". Luego podrás
        personalizarlo aquí.</p>
@endif
