@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Administrador') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Tarjeta de perfil admin + contadores -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <!-- Perfil administrador -->
                        <div class="flex items-center gap-4">
                            <div class="avatar">
                                <div class="w-20 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                    @php $me = auth()->user(); @endphp
                                    @if ($me?->avatar_path)
                                        <img src="{{ Storage::disk('public')->url($me->avatar_path) }}"
                                            alt="Admin" />
                                    @else
                                        <img src="https://api.dicebear.com/9.x/initials/svg?seed={{ urlencode($me?->name ?? 'A') }}"
                                            alt="Admin" />
                                    @endif
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">{{ $me?->name }}</h3>
                                <p class="text-base-content/70">Administrador</p>
                                <div class="mt-2 flex gap-2">
                                    <form method="POST" action="{{ route('admin.avatar.upload') }}"
                                        enctype="multipart/form-data" class="flex items-center gap-2">
                                        @csrf
                                        <input type="file" name="avatar" accept="image/*"
                                            class="file-input file-input-sm file-input-bordered" />
                                        <button class="btn btn-sm btn-primary" type="submit">Actualizar foto</button>
                                    </form>
                                    @if ($me?->avatar_path)
                                        <form method="POST" action="{{ route('admin.avatar.delete') }}"
                                            onsubmit="return confirm('¿Eliminar foto?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-ghost" type="submit">Eliminar</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Contadores -->
                        <div class="stats stats-vertical md:stats-horizontal shadow overflow-hidden">
                            <a href="{{ route('admin.students') }}"
                                class="stat hover:shadow-lg hover:scale-[1.02] transition transform-gpu will-change-transform">
                                <div class="stat-title">Alumnos</div>
                                <div class="stat-value">{{ $studentsCount ?? 0 }}</div>
                            </a>
                            <a href="{{ route('admin.courses', ['status' => 'published']) }}"
                                class="stat hover:shadow-lg hover:scale-[1.02] transition transform-gpu will-change-transform">
                                <div class="stat-title">Profesores</div>
                                <div class="stat-value">{{ $professorsCount ?? 0 }}</div>
                            </a>
                            <a href="{{ route('admin.courses') }}?q=Secundaria"
                                class="stat hover:shadow-lg hover:scale-[1.02] transition transform-gpu will-change-transform">
                                <div class="stat-title">Secundaria</div>
                                <div class="stat-value">{{ $secundariaCourses ?? 0 }}</div>
                            </a>
                            <a href="{{ route('admin.courses') }}?q=Pre-Universitario"
                                class="stat hover:shadow-lg hover:scale-[1.02] transition transform-gpu will-change-transform">
                                <div class="stat-title">Pre‑Universitario</div>
                                <div class="stat-value">{{ $preUniversitarioCourses ?? 0 }}</div>
                            </a>
                            <a href="{{ route('admin.courses') }}?q=Universitario"
                                class="stat hover:shadow-lg hover:scale-[1.02] transition transform-gpu will-change-transform">
                                <div class="stat-title">Universitario</div>
                                <div class="stat-value">{{ $universitarioCourses ?? 0 }}</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accesos rápidos -->
            <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-4">
                <a href="{{ route('admin.branding') }}" class="card bg-base-100 shadow hover:shadow-md transition">
                    <div class="card-body">
                        <h3 class="card-title">Branding</h3>
                        <p>Sube imagen/video del hero de la página.</p>
                    </div>
                </a>
                <a href="{{ route('admin.tokens') }}" class="card bg-base-100 shadow hover:shadow-md transition">
                    <div class="card-body">
                        <h3 class="card-title">Tokens de Profesor</h3>
                        <p>Genera y gestiona tokens de invitación.</p>
                    </div>
                </a>
                <a href="{{ route('admin.courses') }}" class="card bg-base-100 shadow hover:shadow-md transition">
                    <div class="card-body">
                        <h3 class="card-title">Cursos</h3>
                        <p>Revisa contenidos creados por profesores.</p>
                    </div>
                </a>
                <a href="{{ route('admin.homeGrid') }}" class="card bg-base-100 shadow hover:shadow-md transition">
                    <div class="card-body">
                        <h3 class="card-title">Grilla Portada</h3>
                        <p>Gestiona imágenes y videos de la sección metodología.</p>
                    </div>
                </a>
                <a href="{{ route('admin.marquee') }}" class="card bg-base-100 shadow hover:shadow-md transition">
                    <div class="card-body">
                        <h3 class="card-title">Marquee Temas</h3>
                        <p>Edita los textos desplazables (Biología, Física, etc.).</p>
                    </div>
                </a>
            </div>

            <!-- Widgets: Calendario y Calculadora -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Calendario simple -->
                <div class="card bg-base-100 shadow">
                    <div class="card-body">
                        <h3 class="card-title">Calendario</h3>
                        <div id="admin-calendar" class="grid grid-cols-7 gap-1 text-center"></div>
                        <div class="mt-3 flex items-center justify-between">
                            <div class="join">
                                <button class="btn btn-sm join-item" id="prev-month">«</button>
                                <button class="btn btn-sm join-item btn-ghost" id="current-month"></button>
                                <button class="btn btn-sm join-item" id="next-month">»</button>
                            </div>
                            <button class="btn btn-sm" id="today-btn">Hoy</button>
                        </div>
                    </div>
                </div>

                <!-- Calculadora -->
                <div class="card bg-base-100 shadow">
                    <div class="card-body">
                        <h3 class="card-title">Calculadora</h3>
                        <div class="w-full max-w-xs">
                            <input id="calc-display" class="input input-bordered w-full text-right text-2xl" readonly
                                value="0" />
                            <div class="grid grid-cols-4 gap-2 mt-4">
                                <button class="btn" data-key="7">7</button>
                                <button class="btn" data-key="8">8</button>
                                <button class="btn" data-key="9">9</button>
                                <button class="btn btn-ghost" data-key="/">÷</button>
                                <button class="btn" data-key="4">4</button>
                                <button class="btn" data-key="5">5</button>
                                <button class="btn" data-key="6">6</button>
                                <button class="btn btn-ghost" data-key="*">×</button>
                                <button class="btn" data-key="1">1</button>
                                <button class="btn" data-key="2">2</button>
                                <button class="btn" data-key="3">3</button>
                                <button class="btn btn-ghost" data-key="-">−</button>
                                <button class="btn" data-key="0">0</button>
                                <button class="btn" data-key=".">.</button>
                                <button class="btn btn-warning" id="calc-clear">C</button>
                                <button class="btn btn-ghost" data-key="+">+</button>
                                <button class="btn col-span-4 btn-primary" id="calc-equal">=</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // --- Calendario ---
        const calEl = document.getElementById('admin-calendar');
        const currentMonthEl = document.getElementById('current-month');
        let viewDate = new Date();

        function renderCalendar() {
            if (!calEl) return;
            calEl.innerHTML = '';

            const year = viewDate.getFullYear();
            const month = viewDate.getMonth();
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startWeekday = (firstDay.getDay() + 6) % 7; // lunes=0

            currentMonthEl.textContent = viewDate.toLocaleDateString('es-ES', {
                month: 'long',
                year: 'numeric'
            });

            const weekdays = ['L', 'M', 'X', 'J', 'V', 'S', 'D'];
            weekdays.forEach(d => {
                const h = document.createElement('div');
                h.className = 'font-semibold opacity-70';
                h.textContent = d;
                calEl.appendChild(h);
            });

            for (let i = 0; i < startWeekday; i++) {
                const empty = document.createElement('div');
                empty.className = 'p-2';
                calEl.appendChild(empty);
            }
            for (let day = 1; day <= lastDay.getDate(); day++) {
                const cell = document.createElement('button');
                cell.className = 'btn btn-ghost btn-sm';
                cell.textContent = day.toString();
                const isToday = (() => {
                    const t = new Date();
                    return day === t.getDate() && month === t.getMonth() && year === t.getFullYear();
                })();
                if (isToday) cell.classList.add('btn-primary');
                calEl.appendChild(cell);
            }
        }
        document.getElementById('prev-month')?.addEventListener('click', () => {
            viewDate.setMonth(viewDate.getMonth() - 1);
            renderCalendar();
        });
        document.getElementById('next-month')?.addEventListener('click', () => {
            viewDate.setMonth(viewDate.getMonth() + 1);
            renderCalendar();
        });
        document.getElementById('today-btn')?.addEventListener('click', () => {
            viewDate = new Date();
            renderCalendar();
        });
        renderCalendar();

        // --- Calculadora ---
        const display = document.getElementById('calc-display');
        let expr = '';

        function pushKey(k) {
            if (k === 'C') {
                expr = '';
                display.value = '0';
                return;
            }
            if (k === '=') {
                try {
                    // Evaluar de forma segura: solo números y operadores permitidos
                    if (!/^[-+*/().\d\s]+$/.test(expr)) throw new Error('Input inválido');
                    const result = Function(`"use strict"; return (${expr})`)();
                    display.value = String(result);
                    expr = String(result);
                } catch (e) {
                    display.value = 'Error';
                    expr = '';
                }
                return;
            }
            expr += k;
            display.value = expr;
        }
        document.querySelectorAll('[data-key]')?.forEach(btn => btn.addEventListener('click', () => pushKey(btn.dataset
            .key)));
        document.getElementById('calc-clear')?.addEventListener('click', () => pushKey('C'));
        document.getElementById('calc-equal')?.addEventListener('click', () => pushKey('='));
    </script>
</x-app-layout>
