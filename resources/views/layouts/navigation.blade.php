<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- ZONA IZQUIERDA --}}
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}" class="transition transform hover:scale-105">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                    {{-- Link INICIO --}}
                    @php
                        $active = request()->routeIs('welcome');
                        $classes = $active
                            ? 'group relative h-16 flex items-center text-sm font-bold text-black'
                            : 'group relative h-16 flex items-center text-sm font-medium text-gray-600 hover:text-red-600 transition-colors';
                        $lineClass = $active ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100';
                    @endphp
                    <a href="{{ route('welcome') }}" class="{{ $classes }}">
                        {{ __('Inicio') }}
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-red-600 transform {{ $lineClass }} transition-transform duration-300"></span>
                    </a>

                    @auth
                        {{-- Link VIDEOJUEGOS --}}
                        @php
                            $active = request()->routeIs('videojuegos.*') && !request()->routeIs('videojuegos.boveda');
                            $classes = $active
                                ? 'group relative h-16 flex items-center text-sm font-bold text-black'
                                : 'group relative h-16 flex items-center text-sm font-medium text-gray-600 hover:text-red-600 transition-colors';
                            $lineClass = $active ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100';
                        @endphp
                        <a href="{{ route('videojuegos.index') }}" class="{{ $classes }}">
                            {{ __('Videojuegos') }}
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-red-600 transform {{ $lineClass }} transition-transform duration-300"></span>
                        </a>

                        {{-- Link CONSOLAS --}}
                        @php
                            $active = request()->routeIs('consolas.*');
                            $classes = $active
                                ? 'group relative h-16 flex items-center text-sm font-bold text-black'
                                : 'group relative h-16 flex items-center text-sm font-medium text-gray-600 hover:text-red-600 transition-colors';
                            $lineClass = $active ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100';
                        @endphp
                        <a href="{{ route('consolas.index') }}" class="{{ $classes }}">
                            {{ __('Consolas') }}
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-red-600 transform {{ $lineClass }} transition-transform duration-300"></span>
                        </a>

                        {{-- Link MI BÓVEDA (FAVORITOS) - AÑADIDO --}}
                        @php
                            $active = request()->routeIs('videojuegos.boveda');
                            $classes = $active
                                ? 'group relative h-16 flex items-center text-sm font-bold text-black'
                                : 'group relative h-16 flex items-center text-sm font-medium text-gray-600 hover:text-red-600 transition-colors';
                            $lineClass = $active ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100';
                        @endphp
                        <a href="{{ route('videojuegos.boveda') }}" class="{{ $classes }}">
                            {{ __('Mi Bóveda') }}
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-red-600 transform {{ $lineClass }} transition-transform duration-300"></span>
                        </a>

                        {{-- ENLACES ADMIN (Botones Rojos) --}}
                        @if(Auth::user()->isAdmin())
                            <div class="hidden md:flex items-center space-x-3 border-l border-gray-200 ml-4 pl-4 h-8 self-center">
                                <a href="{{ route('videojuegos.create') }}" class="px-3 py-1 rounded-full bg-red-600 text-xs font-bold text-white hover:bg-red-700 hover:shadow-lg transition-all transform hover:-translate-y-0.5 shadow-red-500/30">
                                    + Juego
                                </a>
                                <a href="{{ route('consolas.create') }}" class="px-3 py-1 rounded-full bg-red-600 text-xs font-bold text-white hover:bg-red-700 hover:shadow-lg transition-all transform hover:-translate-y-0.5 shadow-red-500/30">
                                    + Consola
                                </a>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- ZONA DERECHA --}}
            <div class="hidden sm:flex sm:items-center sm:ml-6 gap-4">

                @auth
                    {{-- BOTÓN DONAR --}}
                    <a href="{{ route('donaciones.index') }}" class="group flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-full text-sm font-bold shadow-md hover:shadow-lg hover:shadow-green-500/30 transition-all transform hover:-translate-y-0.5">
                        <span>Donar</span>
                    </a>

                    {{-- DROPDOWN USUARIO --}}
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-gray-600 bg-gray-50 hover:bg-red-50 hover:text-red-600 focus:outline-none transition ease-in-out duration-150 gap-2">
                                <div class="flex items-center gap-2">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-8 h-8 rounded-full object-cover border-2 border-white shadow-sm">
                                    @else
                                        {{-- Avatar Rojo --}}
                                        <div class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold border-2 border-white shadow-sm">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <span class="hidden lg:inline">{{ Auth::user()->name }}</span>
                                </div>
                                <svg class="fill-current h-4 w-4 text-gray-400 group-hover:text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 border-b border-gray-100 text-xs text-gray-400">
                                Gestionar Cuenta
                            </div>
                            <x-dropdown-link :href="route('profile.edit')" class="hover:bg-red-50 hover:text-red-600">
                                {{ __('Mi Perfil') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-500 hover:bg-red-50 hover:text-red-700">
                                    {{ __('Cerrar Sesión') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    {{-- LOGIN / REGISTER --}}
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-red-600 font-bold text-sm transition">
                            Iniciar Sesión
                        </a>
                        <a href="{{ route('register') }}" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-full text-sm font-bold shadow-lg hover:shadow-xl hover:shadow-red-500/30 transition transform hover:-translate-y-0.5">
                            Registrarse
                        </a>
                    </div>
                @endauth
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-red-600 hover:bg-red-50 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MENÚ MÓVIL --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="sm:hidden bg-white border-b border-gray-100 shadow-lg">

        <div class="pt-2 pb-3 space-y-1 px-4">
            {{-- Inicio Móvil --}}
            <a href="{{ route('welcome') }}" class="block w-full pl-3 pr-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out rounded-r-lg {{ request()->routeIs('welcome') ? 'border-red-600 text-red-700 bg-red-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                {{ __('Inicio') }}
            </a>

            @auth
                {{-- Videojuegos Móvil --}}
                <a href="{{ route('videojuegos.index') }}" class="block w-full pl-3 pr-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out rounded-r-lg {{ request()->routeIs('videojuegos.*') && !request()->routeIs('videojuegos.boveda') ? 'border-red-600 text-red-700 bg-red-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                    {{ __('Videojuegos') }}
                </a>

                {{-- Consolas Móvil --}}
                <a href="{{ route('consolas.index') }}" class="block w-full pl-3 pr-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out rounded-r-lg {{ request()->routeIs('consolas.*') ? 'border-red-600 text-red-700 bg-red-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                    {{ __('Consolas') }}
                </a>

                {{-- MI BÓVEDA (FAVORITOS) Móvil - AÑADIDO --}}
                <a href="{{ route('videojuegos.boveda') }}" class="block w-full pl-3 pr-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out rounded-r-lg {{ request()->routeIs('videojuegos.boveda') ? 'border-red-600 text-red-700 bg-red-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                    {{ __('Mi Bóveda') }}
                </a>

                <div class="mt-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('donaciones.index') }}" class="block w-full pl-3 pr-4 py-2 text-base font-black text-green-600 bg-green-50 rounded-lg">
                        {{ __('Donar') }}
                    </a>
                </div>
            @endauth
        </div>

        <div class="pt-4 pb-4 border-t border-gray-200 bg-gray-50">
            @auth
                <div class="px-4 flex items-center gap-3">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                    @else
                        <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold border-2 border-white shadow-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1 px-2">
                    <a href="{{ route('profile.edit') }}" class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-red-50 hover:text-red-800 focus:outline-none focus:bg-red-50 transition duration-150 ease-in-out rounded-lg">
                        {{ __('Mi Perfil') }}
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full px-4 py-2 text-left text-sm leading-5 font-bold text-red-600 hover:bg-red-50 focus:outline-none focus:bg-red-50 transition duration-150 ease-in-out rounded-lg">
                            {{ __('Salir') }}
                        </button>
                    </form>
                </div>
            @else
                <div class="px-4 py-2 flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="w-full text-center py-2 text-gray-600 font-bold bg-white border border-gray-300 rounded-lg hover:text-red-600 hover:border-red-300 transition">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="w-full text-center py-2 text-white font-bold bg-red-600 hover:bg-red-700 rounded-lg shadow-md">
                        Registrarse
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>