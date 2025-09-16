@if (isset($course))
    <div class="space-y-6">
        @php($nextUnitNumber = ($course->sections()->count() ?? 0) + 1)
        <form method="POST" action="{{ route('courses.sections.store', $course) }}" class="flex gap-2" x-data
            x-init="$nextTick(() => { const i = $refs.newSection; if (i) { i.focus(); try { i.setSelectionRange(i.value.length, i.value.length) } catch (e) {} } })">
            @csrf
            <input x-ref="newSection" name="name"
                class="flex-1 input input-bordered bg-emerald-100 border-emerald-200 text-emerald-900 focus:border-emerald-300"
                value="Unidad {{ $nextUnitNumber }}: " required>
            <button class="btn" type="submit">Agregar sección</button>
        </form>

        <div class="flex justify-end">
            <button type="button" class="btn btn-primary" onclick="saveAll(this)">Guardar todo</button>
        </div>

        @forelse($course->sections()->with(['lessons.attachments'])->orderBy('position')->get() as $section)
            <div class="border rounded-lg p-4 bg-base-100 border-base-300 shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <form method="POST" action="{{ route('courses.sections.update', [$course, $section]) }}"
                        class="flex-1 flex gap-2">
                        @csrf
                        @method('PUT')
                        <input name="name"
                            value="{{ old('name', isset($section->name) && trim($section->name) !== '' ? $section->name : 'Unidad ' . ($section->position ?? $loop->iteration) . ': ') }}"
                            class="flex-1 input input-bordered bg-emerald-100 border-emerald-200 text-emerald-900 focus:border-emerald-300">
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
                                    <input name="title" value="{{ $lesson->title }}"
                                        class="flex-1 input input-bordered bg-emerald-50 border-emerald-200 text-emerald-900 focus:border-emerald-300"
                                        placeholder="Título de la lección">
                                    <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox"
                                            class="toggle" name="is_preview" value="1"
                                            @checked($lesson->is_preview)>
                                        Gratuita</label>
                                    <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox"
                                            class="toggle" name="is_published" value="1"
                                            @checked($lesson->is_published)>
                                        Publicada</label>
                                    <button class="btn" type="submit">Guardar lección</button>
                                </div>

                                <!-- Subtítulo: Video -->
                                <div class="text-sm font-medium text-base-content">Agregar video</div>
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
                                            <label class="text-sm text-base-content whitespace-nowrap">Archivo de
                                                video</label>
                                            <input type="file" name="video_file" accept="video/*"
                                                class="file-input file-input-bordered" @change="onLocalVideo($event)">
                                        </div>
                                        <div class="flex items-center gap-2 w-full md:w-auto">
                                            <label class="text-sm text-base-content whitespace-nowrap">Miniatura
                                                (opcional)
                                            </label>
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
                                                <p class="text-xs text-base-content/60"
                                                    x-show="!(youtubeUrl || initialUrl)">
                                                    Sin video</p>
                                            </div>
                                        </template>
                                        <template x-if="type==='local'">
                                            <video :src="localUrl || initialUrl"
                                                class="w-64 max-w-full aspect-video rounded border"
                                                x-show="localUrl || initialUrl" controls></video>
                                        </template>
                                        <template x-if="!type">
                                            <p class="text-xs text-base-content/60">Sin video</p>
                                        </template>
                                    </div>
                                </div>

                                <!-- Materiales de la lección -->
                                <div class="text-sm font-medium text-base-content">Material de la lección (PDF/Imagen)
                                </div>
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
                                                            class="inline-flex items-center justify-center w-10 h-10 bg-base-200 text-base-content border border-base-300 rounded text-xs font-semibold">FILE</span>
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
                                            <li class="text-base-content/60">Sin materiales aún.</li>
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
                        <p class="text-sm text-base-content/60">No hay lecciones en esta sección.</p>
                    @endforelse

                    <div class="collapse collapse-arrow bg-base-100 border mt-2">
                        <input type="checkbox" />
                        <div class="collapse-title font-semibold flex items-center gap-2 text-base">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Agregar lección
                        </div>
                        <div class="collapse-content">
                            <div class="card bg-base-100 border border-base-300 shadow-sm">
                                <div class="card-body p-5">
                                    <form method="POST"
                                        action="{{ route('courses.lessons.store', [$course, $section]) }}"
                                        enctype="multipart/form-data" x-data="addLessonForm()" class="space-y-6">
                                        @csrf
                                        <!-- Título -->
                                        <div class="form-control">
                                            <label class="label"><span class="label-text font-semibold">Tema de la
                                                    lección</span></label>
                                            <input name="title" placeholder="Ej: Introducción a la célula"
                                                class="input input-bordered h-12 bg-emerald-50 border-emerald-200 text-emerald-900 focus:border-emerald-300"
                                                required>
                                        </div>

                                        <!-- Imagen de portada + preview -->
                                        <div class="form-control">
                                            <label class="label"><span class="label-text font-semibold">Imagen de
                                                    portada</span></label>
                                            <input type="file" name="thumbnail" accept="image/*"
                                                class="file-input file-input-bordered w-full"
                                                @change="onThumb($event)" />
                                            <span class="label-text-alt">JPG o PNG, máx. 2MB</span>
                                            <img :src="thumbUrl" x-show="thumbUrl"
                                                class="mt-3 w-full max-w-md rounded border"
                                                alt="Previsualización de portada">
                                        </div>

                                        <!-- Video -->
                                        <div class="form-control">
                                            <label class="label"><span class="label-text font-semibold">Tipo de
                                                    video</span></label>
                                            <select name="video_type" class="select select-bordered h-12 w-full"
                                                x-model="type">
                                                <option value="">Sin video</option>
                                                <option value="youtube">YouTube</option>
                                                <option value="local">Archivo local</option>
                                            </select>
                                            <span class="label-text-alt">Selecciona el origen del video</span>
                                        </div>
                                        <div class="form-control" x-show="type==='youtube'">
                                            <label class="label"><span class="label-text font-semibold">URL de
                                                    YouTube</span></label>
                                            <input name="youtube_url"
                                                placeholder="https://www.youtube.com/watch?v=..."
                                                class="input input-bordered h-12">
                                        </div>
                                        <div class="form-control" x-show="type==='local'">
                                            <label class="label"><span class="label-text font-semibold">Subir video
                                                    local</span></label>
                                            <input type="file" name="video_file" accept="video/*"
                                                class="file-input file-input-bordered w-full"
                                                @change="onLocalVideo($event)">
                                            <span class="label-text-alt">MP4/WEBM/OGG</span>
                                        </div>
                                        <div class="form-control" x-show="type==='local'">
                                            <label class="label"><span
                                                    class="label-text font-semibold">Previsualización</span></label>
                                            <video :src="localUrl"
                                                class="w-full max-w-2xl aspect-video rounded border" x-show="localUrl"
                                                controls></video>
                                        </div>

                                        <!-- Descripción -->
                                        <div class="form-control">
                                            <label class="label"><span
                                                    class="label-text font-semibold">Descripción</span></label>
                                            <textarea name="description" class="textarea textarea-bordered" rows="4"
                                                placeholder="Resumen del contenido de la lección"></textarea>
                                        </div>

                                        <!-- Acceso -->
                                        <div class="form-control">
                                            <label class="label"><span class="label-text font-semibold">Configuración
                                                    de acceso</span></label>
                                            <div class="space-y-3">
                                                <label
                                                    class="flex items-start gap-3 p-3 rounded-lg border border-base-300 bg-base-200/30 cursor-pointer">
                                                    <input type="radio" name="access" value="public"
                                                        class="radio mt-1" checked @change="isPreview=false">
                                                    <span>
                                                        <span class="font-medium">Pública</span>
                                                        <span class="block text-sm opacity-70">Los estudiantes podrán
                                                            ver esta lección si tienen acceso al curso</span>
                                                    </span>
                                                </label>
                                                <label
                                                    class="flex items-start gap-3 p-3 rounded-lg border border-base-300 bg-base-200/30 cursor-pointer">
                                                    <input type="radio" name="access" value="free"
                                                        class="radio mt-1" @change="isPreview=true">
                                                    <span>
                                                        <span class="font-medium">Gratuita</span>
                                                        <span class="block text-sm opacity-70">Cualquier persona puede
                                                            ver esta lección sin comprar el curso</span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Publicación -->
                                        <div class="form-control">
                                            <label class="label"><span class="label-text font-semibold">Estado de
                                                    publicación</span></label>
                                            <label class="inline-flex items-center gap-2"><input type="checkbox"
                                                    class="toggle" name="is_published" value="1">
                                                Publicada</label>
                                        </div>

                                        <!-- Archivos -->
                                        <div class="form-control">
                                            <label class="label"><span class="label-text font-semibold">PDF para ver
                                                    online (máx. 1)</span></label>
                                            <input type="file" name="attachment_online" accept="application/pdf"
                                                class="file-input file-input-bordered w-full" />
                                            <span class="label-text-alt">Se reemplaza si ya existe uno</span>
                                        </div>
                                        <div class="form-control">
                                            <label class="label"><span class="label-text font-semibold">PDFs para
                                                    descargar (máx. 3)</span></label>
                                            <input type="file" name="attachments_download[]"
                                                accept="application/pdf" class="file-input file-input-bordered w-full"
                                                multiple />
                                            <span class="label-text-alt">Puedes seleccionar hasta 3 archivos</span>
                                        </div>

                                        <div class="divider"></div>
                                        <div class="card-actions justify-end">
                                            <button class="btn btn-primary" type="submit">Crear lección</button>
                                        </div>
                                        <input type="hidden" name="is_preview" :value="isPreview ? 1 : 0">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-sm text-base-content/60">Aún no has creado secciones.</p>
        @endforelse
    </div>
    <script>
        async function submitFormSequential(form) {
            const fd = new FormData(form)
            // Evitar enviar formularios de adjuntos sin archivos
            if (form.action.includes('attachments.store')) {
                const fileInput = form.querySelector('input[type="file"]')
                if (!fileInput || fileInput.files.length === 0) {
                    return {
                        skipped: true
                    }
                }
            }
            // Evitar enviar formularios de nueva lección sin título
            if (form.action.includes('lessons.store')) {
                const title = form.querySelector('input[name="title"]')
                if (!title || !title.value.trim()) {
                    return {
                        skipped: true
                    }
                }
            }
            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    body: fd,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                if (!res.ok) {
                    return {
                        ok: false,
                        status: res.status
                    }
                }
                return {
                    ok: true
                }
            } catch (err) {
                return {
                    ok: false,
                    error: err?.message || 'error'
                }
            }
        }

        async function saveAll(btn) {
            if (!btn) return
            const original = btn.innerText
            btn.disabled = true
            btn.classList.add('btn-disabled')
            btn.innerText = 'Guardando…'
            let ok = 0,
                fail = 0,
                skip = 0

            // 1) Actualizar secciones existentes
            const sectionUpdate = Array.from(document.querySelectorAll('form[action*="courses.sections.update"]'))
            for (const f of sectionUpdate) {
                const r = await submitFormSequential(f)
                if (r?.skipped) {
                    skip++;
                    continue
                }
                if (r?.ok) ok++;
                else fail++
            }

            // 2) Actualizar lecciones existentes
            const lessonUpdate = Array.from(document.querySelectorAll('form[action*="courses.lessons.update"]'))
            for (const f of lessonUpdate) {
                const r = await submitFormSequential(f)
                if (r?.skipped) {
                    skip++;
                    continue
                }
                if (r?.ok) ok++;
                else fail++
            }

            // 3) Subir adjuntos (solo si hay archivos seleccionados)
            const attachStore = Array.from(document.querySelectorAll(
                'form[action*="courses.lessons.attachments.store"]'))
            for (const f of attachStore) {
                const r = await submitFormSequential(f)
                if (r?.skipped) {
                    skip++;
                    continue
                }
                if (r?.ok) ok++;
                else fail++
            }

            // 4) Crear nuevas lecciones (si tienen título)
            const lessonStore = Array.from(document.querySelectorAll('form[action*="courses.lessons.store"]'))
            for (const f of lessonStore) {
                const r = await submitFormSequential(f)
                if (r?.skipped) {
                    skip++;
                    continue
                }
                if (r?.ok) ok++;
                else fail++
            }

            // 5) Crear nueva sección (si el usuario cambió el valor por defecto)
            const newSectionForm = document.querySelector('form[action*="courses.sections.store"]')
            if (newSectionForm) {
                const nameInput = newSectionForm.querySelector('input[name="name"]')
                if (nameInput) {
                    const value = (nameInput.value || '').trim()
                    // Enviar solo si no está vacío y el usuario lo modificó (heurística: diferente al valor de placeholder común "Unidad N:")
                    const looksDefault = /Unidad\s+\d+\s*:/.test(value)
                    if (value && !looksDefault) {
                        const r = await submitFormSequential(newSectionForm)
                        if (r?.skipped) {
                            skip++;
                        } else if (r?.ok) ok++;
                        else fail++
                    }
                }
            }

            btn.innerText = fail === 0 ? 'Guardado' : 'Guardado con errores'
            setTimeout(() => {
                btn.innerText = original;
                btn.disabled = false;
                btn.classList.remove('btn-disabled');
                window.location.reload()
            }, 600)
        }

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
                thumbUrl: '',
                onLocalVideo(e) {
                    const f = e.target.files?.[0]
                    if (!f) return
                    if (!f.type.startsWith('video/')) {
                        alert('Selecciona un archivo de video.');
                        e.target.value = '';
                        return
                    }
                    this.localUrl = URL.createObjectURL(f)
                },
                onThumb(e) {
                    const f = e.target.files?.[0]
                    if (!f) {
                        this.thumbUrl = '';
                        return
                    }
                    if (!f.type.startsWith('image/')) {
                        alert('Selecciona una imagen (JPG/PNG).');
                        e.target.value = '';
                        return
                    }
                    this.thumbUrl = URL.createObjectURL(f)
                }
            }
        }
    </script>
@else
    <p class="text-sm text-gray-600">Crea primero el curso para poder administrar secciones y lecciones.</p>
@endif
