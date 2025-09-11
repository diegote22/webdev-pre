<x-app-layout>
    <main>
        <!-- =========== 1. Hero Section =========== -->
        <section class="bg-gradient-to-b from-primary to-primary/90">
            <div class="max-w-7xl mx-auto px-6 py-24 md:py-28 text-center">
                <h1 class="text-5xl md:text-7xl font-extrabold leading-tight text-transparent bg-clip-text bg-gradient-to-r from-accent-blue to-accent-pink">
                    Nuestra Plataforma
                </h1>
                <p class="mt-6 text-lg md:text-xl text-light-gray/80 max-w-2xl mx-auto">
                    Un ecosistema para aprender con foco y claridad. Cursos, profesores y herramientas en un mismo lugar.
                </p>
                <div class="mt-10 flex gap-4 justify-center">
                    <a href="#cursos" class="px-6 py-3 rounded bg-gradient-to-r from-accent-blue to-accent-pink text-white font-semibold hover:opacity-90 transition">Explorar cursos</a>
                    <a href="#nosotros" class="px-6 py-3 rounded border border-light-gray/50 text-light-gray hover:bg-white/10 transition">Saber más</a>
                </div>
            </div>
        </section>

        <!-- =========== 2. Logo Marquee =========== -->
        <section class="py-8 md:py-12">
            <div class="relative w-full overflow-hidden">
                <div class="flex animate-scroll">
                    <div class="flex w-max items-center">
                        <span class="mx-8 text-lg font-semibold text-light-gray/50">Biología</span>
                        <span class="mx-8 text-lg font-semibold text-light-gray/50">Matemáticas</span>
                        <span class="mx-8 text-lg font-semibold text-light-gray/50">Física</span>
                        <span class="mx-8 text-lg font-semibold text-light-gray/50">Anatomía</span>
                        <span class="mx-8 text-lg font-semibold text-light-gray/50">Fisiología</span>
                        <span class="mx-8 text-lg font-semibold text-light-gray/50">Química</span>
                        <span class="mx-8 text-lg font-semibold text-light-gray/50">Álgebra</span>
                        <span class="mx-8 text-lg font-semibold text-light-gray/50">Histología</span>
                        <!-- Repetir para efecto infinito -->
                        <span class="mx-8 text-lg font-semibold text-light-gray/50">Biología</span>
                        <span class="mx-8 text-lg font-semibold text-light-gray/50">Matemáticas</span>
                        <span class="mx-8 text-lg font-semibold text-light-gray/50">Física</span>
                        <span class="mx-8 text-lg font-semibold text-light-gray/50">Anatomía</span>
                        <span class="mx-8 text-lg font-semibold text-light-gray/50">Fisiología</span>
                        <span class="mx-8 text-lg font-semibold text-light-gray/50">Química</span>
                        <span class="mx-8 text-lg font-semibold text-light-gray/50">Álgebra</span>
                        <span class="mx-8 text-lg font-semibold text-light-gray/50">Histología</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- =========== 3. Course Carousels =========== -->
        <section id="cursos" class="max-w-7xl mx-auto px-6 py-16 md:py-24 space-y-16">
            @foreach(($categories ?? collect()) as $cat)
                @php(
                    $courses = $cat->subCategories->flatMap(fn($s) => $s->courses)->sortByDesc('created_at')->take(12)
                )
                @if($courses->isEmpty())
                    @continue
                @endif
                <div x-data="carousel()" id="cat-{{ \Illuminate\Support\Str::slug($cat->name) }}">
                    <div class="flex justify-between items-end mb-8">
                        <div>
                            <h2 class="text-3xl font-bold text-light-gray">{{ $cat->name }}</h2>
                            <p class="text-light-gray/80 mt-2">Explora los cursos de {{ strtolower($cat->name) }}.</p>
                            @php($subsWithCourses = ($cat->subCategories ?? collect())->filter(fn($s)=>$s->courses && $s->courses->count()>0))
                            @if($subsWithCourses->isNotEmpty())
                                <div class="mt-3 flex flex-wrap gap-2">
                                    @foreach($subsWithCourses->take(8) as $s)
                                        <a href="{{ route('categories.show', ['category'=>$cat, 'sub'=>$s->id]) }}" class="px-3 py-1 text-sm border border-light-gray/50 text-light-gray rounded-full hover:bg-white/10">
                                            {{ $s->name }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="hidden md:flex items-center gap-2">
                            <button @click="prev()" class="w-10 h-10 flex items-center justify-center bg-white/10 text-light-gray rounded-full shadow-md hover:bg-white/20 transition">‹</button>
                            <button @click="next()" class="w-10 h-10 flex items-center justify-center bg-white/10 text-light-gray rounded-full shadow-md hover:bg-white/20 transition">›</button>
                        </div>
                    </div>
                    <div class="relative">
                        <div x-ref="slider" class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth gap-3" style="-ms-overflow-style: none; scrollbar-width: none;">
                            @foreach($courses as $c)
                                <div class="flex-shrink-0 w-72 snap-start">
                                    <x-course-card :course="$c" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="text-center mt-6">
                        <a href="{{ route('categories.show', $cat) }}" class="inline-block px-6 py-2 border border-light-gray/50 text-light-gray rounded hover:bg-white/10">Ver más</a>
                    </div>
                </div>
            @endforeach
        </section>

        <!-- =========== 4. Image Section =========== -->
        <section id="nosotros" class="container mx-auto px-6 py-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-light-gray">Nuestra Metodología</h2>
                <p class="text-light-gray/80 mt-2 max-w-2xl mx-auto">Combinamos tecnología, pedagogía y la experiencia de
                    los mejores profesores para ofrecerte una experiencia de aprendizaje única.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="grid gap-4">
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md" src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md" src="https://images.unsplash.com/photo-1550745165-9bc0b252726a?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
                    </div>
                </div>
                <div class="grid gap-4">
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md" src="https://images.unsplash.com/photo-1534665482403-a909d0d97c67?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md" src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
                    </div>
                </div>
                <div class="grid gap-4">
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md" src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md" src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=2132&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
                    </div>
                </div>
                <div class="grid gap-4">
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md" src="https://images.unsplash.com/photo-1531482615713-2c657f6417e3?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md" src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
                    </div>
                </div>
            </div>
        </section>
    </main>

    

    <script>
        function carousel() {
            return {
                init() {
                    // Lógica de inicialización si es necesaria
                },
                next() {
                    const slider = this.$refs.slider;
                    const scrollAmount = slider.offsetWidth;
                    slider.scrollBy({
                        left: scrollAmount,
                        behavior: 'smooth'
                    });
                },
                prev() {
                    const slider = this.$refs.slider;
                    const scrollAmount = slider.offsetWidth;
                    slider.scrollBy({
                        left: -scrollAmount,
                        behavior: 'smooth'
                    });
                }
            }
        }
    </script>
</x-app-layout>
