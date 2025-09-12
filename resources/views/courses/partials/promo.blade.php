@if(isset($course))
    <!-- Plyr CSS -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />

    <form method="POST" action="{{ route('courses.promo.save', $course) }}" enctype="multipart/form-data"
          x-data="promoForm({
              initialUrl: @js($course->promo_video_url),
          })" x-init="init()" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <!-- Controles -->
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-black">Tipo de video</label>
                    <select name="video_type" x-model="type" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="youtube">YouTube</option>
                        <option value="local">Archivo local</option>
                    </select>
                </div>

                <div x-show="type==='youtube'">
                    <label class="block text-sm font-medium text-black">URL de YouTube</label>
                    <input name="youtube_url" x-model.lazy="youtubeUrl" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="https://www.youtube.com/watch?v=...">
                    <p class="text-xs text-gray-500 mt-1">Pega un enlace de YouTube válido. Se previsualizará abajo.</p>
                </div>

                <div x-show="type==='local'" x-cloak>
                    <label class="block text-sm font-medium text-black">Seleccionar archivo</label>
                    <input type="file" name="video_file" accept="video/mp4,video/webm,video/ogg" class="mt-1 w-full" @change="handleFile($event)" />
                    <p class="text-xs text-gray-500 mt-1">MP4/WebM/Ogg hasta 200MB. Se previsualizará abajo.</p>
                </div>

                <div class="flex justify-end pt-2">
                    <button class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-sm" type="submit">
                        Guardar
                    </button>
                </div>
            </div>

            <!-- Previsualización -->
            <div class="lg:col-span-2">
                <div class="bg-gray-50 rounded-lg p-4 border">
                    <!-- YouTube -->
                    <div x-show="type==='youtube'" class="aspect-video">
                        <div x-ref="yt" class="h-full w-full rounded overflow-hidden border"
                             x-bind:data-plyr-provider="'youtube'"
                             x-bind:data-plyr-embed-id="ytId || ''"></div>
                    </div>
                    <!-- Local -->
                    <div x-show="type==='local'" x-cloak class="aspect-video">
                        <video x-ref="video" class="w-full h-full rounded overflow-hidden border" playsinline controls>
                            <source x-bind:src="fileUrl || initialLocalUrl || ''" />
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Plyr JS -->
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
    <script>
        function promoForm({ initialUrl }){
            return {
                type: 'youtube',
                youtubeUrl: '',
                ytId: '',
                fileUrl: '',
                initialLocalUrl: '',
                player: null,
                init(){
                    // Detectar tipo por URL inicial (si existe)
                    if(initialUrl){
                        if(this.isYouTube(initialUrl)){
                            this.type = 'youtube'
                            this.youtubeUrl = initialUrl
                            this.ytId = this.extractYouTubeID(initialUrl)
                            this.$nextTick(() => this.mountPlayer())
                        } else {
                            this.type = 'local'
                            this.initialLocalUrl = initialUrl
                            this.$nextTick(() => this.mountPlayer())
                        }
                    } else {
                        this.$nextTick(() => this.mountPlayer())
                    }

                    // Reaccionar a cambios de URL de YouTube
                    this.$watch('youtubeUrl', (val) => {
                        if(this.type !== 'youtube') return
                        this.ytId = this.extractYouTubeID(val)
                        this.remount()
                    })

                    // Reaccionar a cambios de tipo
                    this.$watch('type', () => {
                        this.remount()
                    })
                },
                remount(){
                    this.destroyPlayer()
                    this.$nextTick(() => this.mountPlayer())
                },
                mountPlayer(){
                    this.destroyPlayer()
                    if(!window.Plyr) return
                    if(this.type === 'youtube' && this.$refs.yt && this.ytId){
                        this.player = new Plyr(this.$refs.yt, { youtube: { rel: 0, modestbranding: 1 } })
                    } else if(this.type === 'local' && this.$refs.video){
                        this.player = new Plyr(this.$refs.video, { controls: [ 'play', 'progress', 'current-time', 'mute', 'volume', 'settings', 'pip', 'airplay', 'fullscreen' ] })
                    }
                },
                destroyPlayer(){
                    try{ if(this.player && this.player.destroy){ this.player.destroy(); } }catch(e){}
                    this.player = null
                },
                handleFile(e){
                    const f = e.target.files?.[0]
                    if(!f) return
                    const allowed = ['video/mp4','video/webm','video/ogg']
                    if(!allowed.includes(f.type)){
                        alert('Formato no soportado. Usa MP4, WebM u Ogg.')
                        e.target.value = ''
                        return
                    }
                    if(f.size > 200*1024*1024){
                        alert('El archivo supera el límite de 200MB.')
                        e.target.value = ''
                        return
                    }
                    this.fileUrl = URL.createObjectURL(f)
                    this.remount()
                },
                isYouTube(url){
                    return /youtu\.be|youtube\.com/.test(url || '')
                },
                extractYouTubeID(url){
                    if(!url) return ''
                    const r = /(?:youtu\.be\/|v=|\/embed\/)([\w-]{11})/;
                    const m = url.match(r)
                    return m ? m[1] : ''
                }
            }
        }
    </script>
@else
    <p class="text-sm text-gray-600">Primero crea el curso para poder subir o vincular un video promocional.</p>
@endif
