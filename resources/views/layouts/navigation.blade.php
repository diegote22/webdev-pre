<nav x-data="{ open: false }" class="bg-primary/80 backdrop-blur-sm sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-accent-blue to-accent-pink">
                        WebDev-Pre
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Inicio') }}
                    </x-nav-link>
                    <x-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.index')">
                        {{ __('Cursos') }}
                    </x-nav-link>
                    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')">
                        {{ __('Categorías') }}
                    </x-nav-link>

                    @auth
                        @if(auth()->user()->role?->name === 'Administrador')
                            <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                                {{ __('Gestionar Usuarios') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                                {{ __('Categorías') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.sub-categories.index')" :active="request()->routeIs('admin.sub-categories.*')">
                                {{ __('Subcategorías') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Panel Admin') }}
                            </x-nav-link>
                        @elseif(auth()->user()->role?->name === 'Profesor')
                            <x-nav-link :href="route('professor.dashboard')" :active="request()->routeIs('professor.*')">
                                {{ __('Mis Cursos') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings / Auth -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 px-2 py-1 border border-transparent rounded-full text-light-gray hover:text-white bg-transparent focus:outline-none transition ease-in-out duration-150">
                                @php($initial = mb_strtoupper(mb_substr(Auth::user()->name ?? 'U', 0, 1)))
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-accent-blue text-white font-semibold">{{ $initial }}</span>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm rounded-full border border-white/20 text-white/90 hover:bg-white/10">Iniciar sesión</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm rounded-full bg-gradient-to-r from-accent-blue to-accent-pink text-white font-semibold hover:opacity-90">Registrarse</a>
                    </div>
                @endauth
                <a href="{{ route('contact') }}" class="px-4 py-2 text-sm rounded-full bg-gradient-to-r from-accent-blue to-accent-pink text-white font-semibold hover:opacity-90">Contactar</a>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden px-4">
        <div class="pt-2 pb-3 space-y-1 bg-primary/95">
            <x-responsive-nav-link :href="route('home')">
                {{ __('Inicio') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('courses.index')">
                {{ __('Cursos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('categories.index')">
                {{ __('Categorías') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contact')">
                {{ __('Contactar') }}
            </x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Iniciar sesión') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">
                    {{ __('Registrarse') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
