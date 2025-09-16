@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
@endphp
<x-app-layout>
    <div class="max-w-7xl mx-auto p-4 lg:p-8" x-data="coursePlayer()">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <aside class="lg:col-span-1 space-y-4">
                <div class="bg-base-100 rounded shadow p-4">
                    <h2 class="text-sm font-semibold mb-2">Contenido</h2>
                    <ul class="space-y-3">
                        @foreach ($course->sections as $sec)
                            <li>
                                <div class="text-xs font-semibold mb-1 flex items-center justify-between">
                                    <span>{{ $sec->name }}</span>
                                    <span class="badge badge-ghost">{{ $sec->lessons->count() }}</span>
                                </div>
                                <ul class="space-y-1">
                                    @foreach ($sec->lessons as $l)
                                        <li>
                                            <a href="{{ route('student.courses.lesson', [$course, $l]) }}"
                                                class="block px-2 py-1 rounded text-xs hover:bg-base-200 {{ $l->id === $lesson->id ? 'bg-primary text-primary-content' : 'text-base-content/80' }}">
                                                <span class="truncate inline-block max-w-[140px] align-middle">{{ $l->title }}</span>
                                                @if ($l->duration)
                                                    <span class="ml-1 text-[10px] opacity-70">{{ $l->duration }}m</span>
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>
            <main class="lg:col-span-3 space-y-6">
                <div class="bg-base-100 rounded shadow overflow-hidden">
                    <div class="aspect-video w-full bg-black flex items-center justify-center relative">
                        @if ($lesson->video_type === 'youtube' && $lesson->video_url)
                            <iframe class="w-full h-full" src="{{ $lesson->video_url }}" allowfullscreen></iframe>
                        @elseif ($lesson->video_type === 'external' && $lesson->video_url)
                            <video x-ref="player" class="w-full h-full" controls playsinline @timeupdate="trackProgress($event)">
                                <source src="{{ $lesson->video_url }}" />
                            </video>
                        @else
                            <div class="text-base-content/50 text-sm">Sin video configurado</div>
                        @endif
                        <div class="absolute top-2 right-2 text-[10px] bg-base-100/80 px-2 py-1 rounded shadow">
                            <span>Progreso: <span x-text="progressDisplay">0%</span></span>
                        </div>
                    </div>
                    <div class="p-4 space-y-3">
                        <h1 class="text-xl font-semibold">{{ $lesson->title }}</h1>
                        @if ($lesson->description)
                            <p class="text-sm leading-relaxed text-base-content/80">{{ $lesson->description }}</p>
                        @endif
                        <div class="tabs tabs-bordered">
                            <a class="tab tab-active" @click.prevent="activeTab='materials'" :class="{ 'tab-active': activeTab==='materials' }">Material</a>
                            <a class="tab" @click.prevent="activeTab='info'" :class="{ 'tab-active': activeTab==='info' }">Info</a>
                        </div>
                        <div x-show="activeTab==='materials'" x-cloak class="mt-3">
                            @php($pdfs = $lesson->attachments->filter(fn($a) => Str::lower(pathinfo($a->name, PATHINFO_EXTENSION)) === 'pdf'))
                            @php($images = $lesson->attachments->filter(fn($a) => in_array(Str::lower(pathinfo($a->name, PATHINFO_EXTENSION)), ['jpg','jpeg','png','gif','webp'])))
                            <div class="space-y-4">
                                @if($pdfs->count() > 0)
                                    <div>
                                        <h3 class="text-sm font-semibold mb-2">PDFs</h3>
                                        <div class="flex flex-wrap gap-2 mb-2">
                                            @foreach($pdfs as $idx => $p)
                                                <button type="button" class="btn btn-xs" @click="loadPdf('{{ Storage::url($p->path) }}')">{{ $p->name }}</button>
                                            @endforeach
                                        </div>
                                        <div class="border rounded relative" x-show="currentPdfUrl">
                                            <canvas id="pdf-canvas" class="max-h-[600px] w-full"></canvas>
                                            <div class="flex items-center gap-2 p-2 text-xs">
                                                <button class="btn btn-xs" @click="prevPage()">Anterior</button>
                                                <button class="btn btn-xs" @click="nextPage()">Siguiente</button>
                                                <span>Página <span x-text="pageNum"></span>/<span x-text="pageCount"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if($images->count() > 0)
                                    <div>
                                        <h3 class="text-sm font-semibold mb-2">Imágenes</h3>
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                            @foreach($images as $img)
                                                <a href="{{ Storage::url($img->path) }}" target="_blank" class="block group">
                                                    <img src="{{ Storage::url($img->path) }}" alt="{{ $img->name }}" class="rounded border object-cover aspect-video group-hover:opacity-80" />
                                                    <span class="block mt-1 text-[10px] truncate">{{ $img->name }}</span>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                @if($pdfs->count()===0 && $images->count()===0)
                                    <p class="text-xs text-base-content/50">Sin material adicional.</p>
                                @endif
                            </div>
                        </div>
                        <div x-show="activeTab==='info'" x-cloak class="mt-3 text-xs text-base-content/70">
                            <p>Duración estimada: {{ $lesson->duration ? $lesson->duration . ' min' : 'N/D' }}</p>
                            <p>Sección: {{ $lesson->section->name }}</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js" integrity="sha512-h0QmkavRKu0kUQeFkC6qJbXA3ouzJXDo8wZfC4fVzz4YI8U/dKOppJ6n9LILSTNh8xmg7tKZYdnbHUiVDgE59w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function coursePlayer() {
            return {
                activeTab: 'materials',
                progressDisplay: '0%',
                sentComplete: false,
                currentPdfUrl: null,
                pdfDoc: null,
                pageNum: 0,
                pageCount: 0,
                rendering: false,
                queuePage: null,
                loadPdf(url) {
                    this.currentPdfUrl = url;
                    const CMAP_URL = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/cmaps/';
                    const CMAP_PACKED = true;
                    pdfjsLib.getDocument({ url, cMapUrl: CMAP_URL, cMapPacked: CMAP_PACKED }).promise.then(pdf => {
                        this.pdfDoc = pdf; this.pageCount = pdf.numPages; this.renderPage(1);
                    });
                },
                renderPage(num) {
                    if(!this.pdfDoc) return; this.rendering = true; this.pageNum = num;
                    this.pdfDoc.getPage(num).then(page => {
                        const viewport = page.getViewport({ scale: 1.2 });
                        const canvas = document.getElementById('pdf-canvas');
                        if(!canvas) return;
                        const ctx = canvas.getContext('2d');
                        canvas.height = viewport.height; canvas.width = viewport.width;
                        const renderTask = page.render({ canvasContext: ctx, viewport });
                        renderTask.promise.then(() => {
                            this.rendering = false;
                            if (this.queuePage !== null) { const q = this.queuePage; this.queuePage = null; this.renderPage(q);} 
                        });
                    });
                },
                queueRenderPage(num) { if (this.rendering) { this.queuePage = num; } else { this.renderPage(num); } },
                prevPage() { if (!this.pdfDoc || this.pageNum <= 1) return; this.queueRenderPage(this.pageNum - 1); },
                nextPage() { if (!this.pdfDoc || this.pageNum >= this.pageCount) return; this.queueRenderPage(this.pageNum + 1); },
                trackProgress(e) {
                    const el = e.target; if (!el.duration || el.duration === Infinity) return;
                    const percent = Math.min(100, Math.round((el.currentTime / el.duration) * 100));
                    this.progressDisplay = percent + '%';
                    if (percent >= 90 && !this.sentComplete) { this.sentComplete = true; this.sendProgress(el.currentTime, true); }
                    else if (percent % 10 === 0) { this.sendProgress(el.currentTime, false); }
                },
                sendProgress(seconds, completed) {
                    fetch('{{ route('student.courses.lesson.progress', [$course, $lesson]) }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                        body: new URLSearchParams({ seconds: Math.round(seconds), completed: completed ? 1 : 0 })
                    });
                }
            }
        }
    </script>
</x-app-layout>
