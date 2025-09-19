<div id="navbar" class="navbar bg-base-100 shadow-sm sticky top-0 z-50">
    <!-- Logo/Brand -->
    <div class="navbar-start">
        <a href="/" class="btn btn-ghost text-xl font-bold text-primary logo-font">
            WebDev-Pre
        </a>
    </div>

    <!-- Navigation Menu (Desktop) -->
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1 gap-2">
            <li><a href="{{ route('courses.secundaria') }}" class="btn btn-ghost">Secundaria</a></li>
            <li><a href="{{ route('courses.pre-universitario') }}" class="btn btn-ghost">Pre-Universitario</a></li>
            <li><a href="{{ route('courses.universitario') }}" class="btn btn-ghost">Universitario</a></li>
            <li><a href="{{ route('pages.nosotros') }}" class="btn btn-ghost">Nosotros</a></li>
            <li><a href="{{ route('pages.preguntas') }}" class="btn btn-ghost">Preguntas</a></li>
        </ul>
    </div>

    <!-- Right Side - Auth buttons + Avatar P -->
    <div class="navbar-end">
        <div class="flex gap-2 items-center">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Ir a mi Panel</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" class="btn btn-ghost"
                        onclick="event.preventDefault(); this.closest('form').submit();">Cerrar sesión</a>
                </form>
                <div class="relative">
                    <div
                        class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-semibold">
                        P
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Registrarse</a>
            @endauth
        </div>
    </div>

    <!-- Mobile Menu Button -->
    <div class="dropdown dropdown-end lg:hidden ml-2">
        <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </div>
        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[60] p-2 shadow bg-base-100 rounded-box w-52">
            <li><a href="{{ route('courses.secundaria') }}">Secundaria</a></li>
            <li><a href="{{ route('courses.pre-universitario') }}">Pre-Universitario</a></li>
            <li><a href="{{ route('courses.universitario') }}">Universitario</a></li>
            <li><a href="{{ route('pages.nosotros') }}">Nosotros</a></li>
            <li><a href="{{ route('pages.preguntas') }}">Preguntas</a></li>
            <div class="divider"></div>
            @auth
                <li><a href="{{ route('dashboard') }}">Ir a mi Panel</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();">Cerrar sesión</a>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}">Iniciar Sesión</a></li>
                <li><a href="{{ route('register') }}">Registrarse</a></li>
            @endauth
        </ul>
    </div>
</div>
