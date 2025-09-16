<div class="navbar bg-base-100 shadow-sm">
    @php
        // Centralizamos el usuario autenticado y su rol para evitar referencias indefinidas
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $roleName = optional($user?->role)->name; // Puede ser 'Administrador', 'Profesor', 'Estudiante' o null
        $roleNorm = $roleName ? strtolower(trim($roleName)) : null;
        $isProfessor = in_array($roleNorm, ['profesor', 'docente'], true);
        // Badge de rol por defecto
        $badgeText = $roleNorm === 'administrador' ? 'Admin' : ($isProfessor ? 'Profe' : ($roleNorm === 'estudiante' ? 'Estu' : ''));
        $badgeClass = $roleNorm === 'administrador' ? 'badge-accent' : ($isProfessor ? 'badge-secondary' : ($roleNorm === 'estudiante' ? 'badge-primary' : 'badge-ghost'));
    @endphp
    <!-- Logo/Brand -->
    <div class="flex-1">
        <a href="{{ route('home') }}" class="btn btn-ghost text-xl font-bold text-primary gap-2 items-center">
            <img src="{{ asset('img/webdev.png') }}" alt="WebDev-Pre" class="h-8 w-auto" loading="lazy" />
            <span class="hidden sm:inline">WebDev-Pre</span>
        </a>
    </div>

    <!-- Navigation Menu (Desktop) -->
    <div class="navbar-center hidden lg:flex items-center gap-4">
        <ul class="menu menu-horizontal px-1 gap-2">
            <li>
                <a href="{{ route('dashboard') }}"
                    class="btn btn-ghost {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 15v-1a2 2 0 114 0v1" />
                    </svg>
                    Mi Panel
                </a>
            </li>

            @auth
                @if ($isProfessor)
                    <li>
                        <a href="{{ route('professor.profile') }}"
                            class="btn btn-ghost {{ request()->routeIs('professor.profile') ? 'bg-primary/10 text-primary' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Perfil
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('courses.index') }}"
                            class="btn btn-ghost {{ request()->routeIs('courses.index') ? 'bg-primary/10 text-primary' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            Mis Cursos
                        </a>
                    </li>
                @elseif ($roleNorm === 'estudiante')
                    <li>
                        <a href="{{ route('student.profile') }}"
                            class="btn btn-ghost {{ request()->routeIs('student.profile') ? 'bg-primary/10 text-primary' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Perfil
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('student.my-courses') }}"
                            class="btn btn-ghost {{ request()->routeIs('student.my-courses') ? 'bg-primary/10 text-primary' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            Mis Cursos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('student.messages') }}"
                            class="btn btn-ghost {{ request()->routeIs('student.messages') ? 'bg-primary/10 text-primary' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            Mensajes
                        </a>
                    </li>
                @elseif ($roleNorm === 'administrador')
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="btn btn-ghost {{ request()->routeIs('admin.dashboard') ? 'bg-primary/10 text-primary' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11h8M8 15h5" />
                            </svg>
                            Administración
                        </a>
                    </li>
                @endif
            @endauth
        </ul>
        <!-- Search bar (Desktop) -->
        <form action="{{ route('courses.search') }}" method="GET" class="w-96">
            <div class="join w-full">
                <input type="search" name="q" value="{{ request('q') }}"
                    class="input input-bordered join-item w-full outline-none focus:outline-none focus:ring-0 focus:border-primary"
                    placeholder="Que curso estas buscando..." />
                <button type="submit" class="btn btn-primary join-item">Buscar</button>
            </div>
        </form>
    </div>

    <!-- Right Side - Profile -->
    <div class="flex-none gap-2">
        @auth
            <!-- Notifications (Details/Summary for reliable toggle) -->
            <details class="dropdown dropdown-end">
                <summary class="btn btn-ghost btn-circle">
                    <div class="indicator">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-5 5-5-5h5V3h5v14z" />
                        </svg>
                        @if (!empty($unreadMessagesCount))
                            <span class="badge badge-xs badge-primary indicator-item">{{ $unreadMessagesCount }}</span>
                        @endif
                    </div>
                </summary>
                <div class="mt-3 z-[60] card card-compact dropdown-content w-60 bg-base-100 shadow">
                    <div class="card-body">
                        <span class="font-bold text-lg">{{ $unreadMessagesCount ?? 0 }} Notificaciones</span>
                        <span
                            class="text-info text-sm">{{ ($unreadMessagesCount ?? 0) > 0 ? 'Nuevos mensajes disponibles' : 'Sin notificaciones nuevas' }}</span>
                        <div class="card-actions mt-2">
                            @php($notifHref = $roleName === 'Estudiante' ? route('student.messages') : route('notifications.index'))
                            <a href="{{ $notifHref }}" class="btn btn-primary btn-sm btn-block"
                                title="Ver todas las notificaciones">Ver todas</a>
                        </div>
                    </div>
                </div>
            </details>

            <!-- User Avatar Dropdown (componente unificado) -->
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                    <div class="relative">
                        @if($user?->avatar_path)
                            <div class="avatar">
                                <div class="w-10 h-10 rounded-full">
                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" />
                                </div>
                            </div>
                        @else
                            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-semibold">
                                {{ $user?->initials ?? 'U' }}
                            </div>
                        @endif
                        @if(!empty($badgeText ?? null))
                            <span class="badge badge-xs {{ $badgeClass ?? 'badge-ghost' }} absolute -bottom-1 -right-1">{{ $badgeText }}</span>
                        @endif
                    </div>
                </div>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 z-[60] p-2 shadow bg-base-100 rounded-box w-52">
                    <li class="menu-title">
                        <span>{{ $user?->name }}</span>
                    </li>
                    <li>
                        <a href="{{ route('profile.edit') }}" class="justify-between">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Perfil
                            </span>
                            @switch($isProfessor ? 'profesor' : $roleNorm)
                                @case('estudiante')
                                    <span class="badge badge-primary">Estudiante</span>
                                @break

                                @case('profesor')
                                    <span class="badge badge-secondary">Profesor</span>
                                @break

                                @case('administrador')
                                    <span class="badge badge-accent">Administrador</span>
                                @break

                                @default
                                    <span class="badge">Usuario</span>
                            @endswitch
                        </a>
                    </li>
                    <li class="menu-title"><span>Accesos rápidos</span></li>
                    @if($isProfessor)
                        <li><a href="{{ route('professor.dashboard') }}">Panel Profesor</a></li>
                        <li><a href="{{ route('professor.profile') }}">Perfil</a></li>
                        <li><a href="{{ route('courses.index') }}">Mis Cursos</a></li>
                        <li><a href="{{ route('courses.create') }}">Crear Curso</a></li>
                    @elseif($roleNorm === 'estudiante')
                        <li><a href="{{ route('student.dashboard') }}">Mi Panel</a></li>
                        <li><a href="{{ route('student.my-courses') }}">Mis Cursos</a></li>
                        <li><a href="{{ route('student.messages') }}">Mensajes</a></li>
                    @elseif($roleNorm === 'administrador')
                        <li><a href="{{ route('admin.dashboard') }}">Panel Admin</a></li>
                        <li><a href="{{ route('admin.branding') }}">Branding</a></li>
                        <li><a href="{{ route('admin.marquee') }}">Marquee</a></li>
                        <li><a href="{{ route('admin.homeGrid') }}">Home Grid</a></li>
                        <li><a href="{{ route('admin.students') }}">Estudiantes</a></li>
                        <li><a href="{{ route('admin.courses') }}">Cursos</a></li>
                    @endif
                    <li>
                        <a href="#">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Configuración
                        </a>
                    </li>
                    <div class="divider my-1"></div>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();" class="text-error">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Cerrar Sesión
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <!-- Guest Navigation -->
            <div class="flex gap-2 items-center">
                <a href="{{ route('login') }}" class="btn btn-ghost">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Registrarse</a>
            </div>
        @endauth

        <!-- Mobile Menu Button -->
        <div class="dropdown dropdown-end lg:hidden">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </div>
            <ul tabindex="0"
                class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-72">
                <li class="px-2 py-1">
                    <form action="{{ route('courses.search') }}" method="GET">
                        <div class="join w-full">
                            <input type="search" name="q" value="{{ request('q') }}"
                                class="input input-bordered join-item w-full outline-none focus:outline-none focus:ring-0 focus:border-primary"
                                placeholder="Que curso estas buscando..." />
                            <button type="submit" class="btn btn-primary join-item">Ir</button>
                        </div>
                    </form>
                </li>
                @auth
                    @php($roleName = optional(Auth::user()->role)->name)
                    @php($roleNorm = $roleName ? strtolower(trim($roleName)) : null)
                    @php($isProfessor = in_array($roleNorm, ['profesor', 'docente'], true))
                    <li><a href="{{ route('dashboard') }}">Mi Panel</a></li>
                    @if ($isProfessor)
                        <li><a href="{{ route('professor.profile') }}">Perfil</a></li>
                        <li><a href="{{ route('courses.index') }}">Mis Cursos</a></li>
                    @elseif ($roleNorm === 'estudiante')
                        <li><a href="{{ route('student.profile') }}">Perfil</a></li>
                        <li><a href="{{ route('student.my-courses') }}">Mis Cursos</a></li>
                        <li><a href="{{ route('student.messages') }}">Mensajes</a></li>
                    @elseif ($roleNorm === 'administrador')
                        <li><a href="{{ route('admin.dashboard') }}">Administración</a></li>
                    @endif
                @else
                    <li><a href="{{ route('login') }}">Iniciar Sesión</a></li>
                    <li><a href="{{ route('register') }}">Registrarse</a></li>
                @endauth
            </ul>
        </div>
    </div>
</div>
