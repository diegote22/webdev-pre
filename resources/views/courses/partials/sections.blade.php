@if (isset($course))
    <div class="space-y-6">
        <form method="POST" action="{{ route('courses.sections.store', $course) }}" class="flex gap-2">
            @csrf
            <input name="name" class="flex-1 input input-bordered" placeholder="Nombre de la nueva sección" required>
            <button class="btn" type="submit">Agregar sección</button>
        </form>

        @forelse($course->sections()->with(['lessons.attachments'])->orderBy('position')->get() as $section)
            <div class="border rounded-lg p-4 bg-white shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <form method="POST" action="{{ route('courses.sections.update', [$course, $section]) }}"
                        class="flex-1 flex gap-2">
                        @csrf
                        @method('PUT')
                        <input name="name" value="{{ $section->name }}" class="flex-1 input input-bordered">
                        <button class="btn" type="submit">Guardar sección</button>
                    </form>
                    <form method="POST" action="{{ route('courses.sections.destroy', [$course, $section]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-error" type="submit">Eliminar sección</button>
                    </form>
                </div>

                <div class="space-y-2">
                    @forelse($section->lessons()->orderBy('position')->get() as $lesson)
                        <div class="rounded border p-3 bg-gray-50" x-data="lessonForm({ initialType: '{{ $lesson->video_type }}', initialUrl: @js($lesson->video_url) })">
                            <form method="POST"
                                action="{{ route('courses.lessons.update', [$course, $section, $lesson]) }}"
                                class="space-y-3" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <!-- Título y switches -->
                                <div class="flex items-center gap-3">
                                    <input name="title" value="{{ $lesson->title }}" class="flex-1 input input-bordered"
                                        placeholder="Título de la lección">
                                    <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox" class="toggle"
                                            name="is_preview" value="1" @checked($lesson->is_preview)>
                                        Gratuita</label>
                                    <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox" class="toggle"
                                            name="is_published" value="1" @checked($lesson->is_published)>
                                        Publicada</label>
                                    <button class="btn" type="submit">Guardar lección</button>
                                </div>

                                <!-- Subtítulo: Video -->
                                <div class="text-sm font-medium text-black">Agregar video</div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-start">
                                    <div class="flex gap-2 md:col-span-2 flex-wrap">
                                        <select name="video_type" class="select select-bordered" x-model="type">
                                            <option value="">Sin video</option>
                                            <option value="youtube" @selected($lesson->video_type === 'youtube')>YouTube</option>
                                            <option value="local" @selected($lesson->video_type === 'local')>Archivo local</option>
                                        </select>
                                        <input name="youtube_url" x-model.lazy="youtubeUrl"
                                            value="{{ $lesson->video_type === 'youtube' ? $lesson->video_url : '' }}"
                                            placeholder="URL YouTube" class="flex-1 input input-bordered"
                                            x-show="type==='youtube'">
                                        <div class="flex items-center gap-2 w-full md:w-auto" x-show="type==='local'">
                                            <label class="text-sm text-black whitespace-nowrap">Archivo de video</label>
                                            <input type="file" name="video_file" accept="video/*"
                                                class="file-input file-input-bordered" @change="onLocalVideo($event)">
                                        </div>
                                        <div class="flex items-center gap-2 w-full md:w-auto">
                                            <label class="text-sm text-black whitespace-nowrap">Miniatura
                                                (opcional)</label>
                                            <input type="file" name="thumbnail" accept="image/*"
                                                class="file-input file-input-bordered" title="Miniatura">
                                        </div>
                                    </div>
                                    <div>
                                        <template x-if="type==='youtube'">
                                            <div>
                                                <a :href="youtubeUrl || initialUrl" target="_blank"
                                                    class="text-xs text-indigo-700 underline"
                                                    x-show="youtubeUrl || initialUrl">Ver en YouTube</a>
                                                <p class="text-xs text-gray-500" x-show="!(youtubeUrl || initialUrl)">
                                                    Sin video</p>
                                            </div>
                                        </template>
                                        <template x-if="type==='local'">
                                            <video :src="localUrl || initialUrl"
                                                class="w-64 max-w-full aspect-video rounded border"
                                                x-show="localUrl || initialUrl" controls></video>
                                        </template>
                                        <template x-if="!type">
                                            <p class="text-xs text-gray-500">Sin video</p>
                                        </template>
                                    </div>
                                </div>

                                <!-- Materiales de la lección -->
                                <div class="text-sm font-medium text-black">Material de la lección (PDF/Imagen)</div>
                                <div class="space-y-2">
                                    <form method="POST"
                                        action="{{ route('courses.lessons.attachments.store', [$course, $section, $lesson]) }}"
                                        enctype="multipart/form-data" class="flex items-center gap-2">
                                        @csrf
                                        <input type="file" name="attachments[]" accept="application/pdf,image/*"
                                            multiple class="file-input file-input-bordered">
                                        <button class="btn" type="submit">Subir</button>
                                    </form>
                                    <ul class="text-sm list-disc pl-5 space-y-2">
                                        @forelse(($lesson->attachments ?? collect()) as $att)
                                            <li class="flex items-center justify-between gap-3">
                                                <div class="flex items-center gap-2 min-w-0">
                                                    @php($ext = strtolower(pathinfo($att->name, PATHINFO_EXTENSION)))
                                                    @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                        <img src="{{ Storage::url($att->path) }}"
                                                            alt="{{ $att->name }}"
                                                            class="w-10 h-10 object-cover rounded border">
                                                    @elseif($ext === 'pdf')
                                                        <span
                                                            class="inline-flex items-center justify-center w-10 h-10 bg-red-50 text-red-600 border rounded text-xs font-semibold">PDF</span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center justify-center w-10 h-10 bg-gray-100 text-gray-700 border rounded text-xs font-semibold">FILE</span>
                                                    @endif
                                                    <a href="{{ Storage::url($att->path) }}" target="_blank"
                                                        class="text-indigo-700 underline truncate">{{ $att->name }}</a>
                                                </div>
                                                <form method="POST"
                                                    action="{{ route('courses.lessons.attachments.destroy', [$course, $section, $lesson, $att]) }}"
                                                    onsubmit="return confirm('¿Eliminar material?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="text-red-600 text-xs">Eliminar</button>
                                                </form>
                                            </li>
                                        @empty
                                            <li class="text-gray-500">Sin materiales aún.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </form>
                            <form method="POST"
                                action="{{ route('courses.lessons.destroy', [$course, $section, $lesson]) }}"
                                class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-error" type="submit">Eliminar lección</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No hay lecciones en esta sección.</p>
                    @endforelse

                    <details class="mt-2">
                        <summary class="cursor-pointer text-sm text-black">Agregar lección</summary>
                        <form method="POST" action="{{ route('courses.lessons.store', [$course, $section]) }}"
                            class="mt-2 grid grid-cols-1 sm:grid-cols-6 gap-2" enctype="multipart/form-data"
                            x-data="addLessonForm()">
                            @csrf
                            <input name="title" placeholder="Título de la lección"
                                class="sm:col-span-2 input input-bordered" required>
                            <select name="video_type" class="select select-bordered" x-model="type">
                                <option value="">Sin video</option>
                                <option value="youtube">YouTube</option>
                                <option value="local">Archivo local</option>
                            </select>
                            <input name="youtube_url" placeholder="URL YouTube" class="input input-bordered"
                                x-show="type==='youtube'">
                            <div class="flex items-center gap-2" x-show="type==='local'">
                                <label class="text-sm text-black whitespace-nowrap">Archivo de video</label>
                                <input type="file" name="video_file" accept="video/*" class="file-input file-input-bordered"
                                    @change="onLocalVideo($event)">
                            </div>
                            <div class="sm:col-span-6 flex items-center gap-4 mt-1">
                <label class="inline-flex items-center gap-1 text-sm"><input type="checkbox" class="toggle"
                    name="is_preview" value="1"> Gratuita</label>
                <label class="inline-flex items-center gap-1 text-sm"><input type="checkbox" class="toggle"
                    name="is_published" value="1"> Publicada</label>
                <button class="ml-auto btn" type="submit">Agregar</button>
                            </div>
                            <div class="sm:col-span-6" x-show="type==='local'">
                                <div class="text-sm text-black mb-1">Previsualización</div>
                                <video :src="localUrl" class="w-64 max-w-full aspect-video rounded border"
                                    x-show="localUrl" controls></video>
                            </div>
                        </form>
                    </details>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500">Aún no has creado secciones.</p>
        @endforelse
    </div>
    <script>
        function lessonForm({
            initialType,
            initialUrl
        }) {
            return {
                type: initialType || '',
                youtubeUrl: initialType === 'youtube' ? (initialUrl || '') : '',
                localUrl: '',
                initialUrl: (initialType === 'local') ? (initialUrl || '') : '',
                onLocalVideo(e) {
                    const f = e.target.files?.[0]
                    if (!f) return
                    if (!f.type.startsWith('video/')) {
                        alert('Selecciona un archivo de video.');
                        e.target.value = '';
                        return
                    }
                    this.localUrl = URL.createObjectURL(f)
                }
            }
        }

        function addLessonForm() {
            return {
                type: '',
                localUrl: '',
                onLocalVideo(e) {
                    const f = e.target.files?.[0]
                    if (!f) return
                    if (!f.type.startsWith('video/')) {
                        alert('Selecciona un archivo de video.');
                        e.target.value = '';
                        return
                    }
                    this.localUrl = URL.createObjectURL(f)
                }
            }
        }
    </script>
@else
    <p class="text-sm text-gray-600">Crea primero el curso para poder administrar secciones y lecciones.</p>
@endif
