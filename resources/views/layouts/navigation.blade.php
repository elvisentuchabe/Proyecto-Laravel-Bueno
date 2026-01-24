<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50 transition-all duration-300">
<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- ZONA IZQUIERDA --}}
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}" class="transition transform hover:scale-105">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}">
                        {{-- Asegúrate de que este componente exista o usa una <img> --}}
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                    {{-- Link: INICIO --}}
                    <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                        {{ __('Inicio') }}
                    </x-nav-link>

                    {{-- Link: VIDEOJUEGOS (Activo en index, show, create, etc.) --}}
                    <x-nav-link :href="route('videojuegos.index')" :active="request()->routeIs('videojuegos.*')">
                        {{ __('Videojuegos') }}
                    </x-nav-link>

                    {{-- Link: CONSOLAS --}}
                    <x-nav-link :href="route('consolas.index')" :active="request()->routeIs('consolas.*')">
                        {{ __('Consolas') }}
                    </x-nav-link>

                    {{-- Link: NOSOTROS --}}
                    <x-nav-link href="#" :active="false">
                        {{ __('Nosotros') }}
                    </x-nav-link>
                </div>
            {{-- LOGO --}}
            <div class="flex items-center">
                <a href="{{ route('welcome') }}">
                    <x-application-logo />
                </a>
            </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <div class="hidden sm:flex sm:items-center sm:ml-6">

                {{-- CASO 1: NO LOGUEADO (Invitado) --}}
                @guest
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-black px-3 py-2 text-sm font-medium transition duration-150 ease-in-out">
                            Iniciar Sesión
                        </a>
                        <a href="{{ route('register') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold px-4 py-2 rounded-md text-sm transition duration-150 ease-in-out shadow-sm">
                            Registrarse
                        </a>
                    </div>
                @endguest
            {{-- MENÚ CENTRAL Y DERECHA --}}
            <div class="flex items-center space-x-4">

                {{-- 1. ENLACES COMUNES (Para todos) --}}
                <a href="{{ route('welcome') }}" class="text-gray-600 hover:text-black px-3 py-2 text-sm font-medium">
                    Inicio
                </a>

                {{-- Solo mostramos estos si está logueado, ya que las rutas están protegidas --}}
                @auth
                    <a href="{{ route('videojuegos.index') }}" class="text-gray-600 hover:text-black px-3 py-2 text-sm font-medium {{ request()->routeIs('videojuegos.*') ? 'text-black font-bold underline' : '' }}">
                        Videojuegos
                    </a>
                    <a href="{{ route('consolas.index') }}" class="text-gray-600 hover:text-black px-3 py-2 text-sm font-medium {{ request()->routeIs('consolas.*') ? 'text-black font-bold underline' : '' }}">
                        Consolas
                    </a>

                    {{-- 2. ENLACES DE ADMINISTRADOR (Solo si es Admin) --}}
                    @if(Auth::user()->isAdmin())
                        <div class="hidden md:flex items-center space-x-2 border-l pl-4 border-gray-300">
                            <a href="{{ route('videojuegos.create') }}" class="text-red-600 hover:text-red-800 text-sm font-bold">
                                + Juego
                            </a>
                            <a href="{{ route('consolas.create') }}" class="text-red-600 hover:text-red-800 text-sm font-bold">
                                + Consola
                            </a>
                        </div>
                    @endif
                @endauth


                {{-- 3. ZONA DE USUARIO / LOGIN --}}
                <div class="ml-4 flex items-center">
                    @guest
                        {{-- Si NO está logueado --}}
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-black px-3 py-2 text-sm font-medium">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-full text-sm font-bold shadow-lg hover:shadow-xl hover:shadow-red-500/30 transition transform hover:-translate-y-0.5">
                            Registrarse
                        </a>
                    @endguest

            @auth
                {{-- Videojuegos Móvil --}}
                <a href="{{ route('videojuegos.index') }}" class="block w-full pl-3 pr-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out rounded-r-lg {{ request()->routeIs('videojuegos.*') ? 'border-red-600 text-red-700 bg-red-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                    {{ __('Videojuegos') }}
                </a>

                {{-- Consolas Móvil --}}
                <a href="{{ route('consolas.index') }}" class="block w-full pl-3 pr-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out rounded-r-lg {{ request()->routeIs('consolas.*') ? 'border-red-600 text-red-700 bg-red-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                    {{ __('Consolas') }}
                </a>

                <div class="mt-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('donar.index') }}" class="block w-full pl-3 pr-4 py-2 text-base font-black text-green-600 bg-green-50 rounded-lg">
                        {{ __('💳 Donar') }}
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
                        {{ __('👤 Mi Perfil') }}
                    </a>
                {{-- CASO 2: LOGUEADO (Usuario/Admin) --}}
                @auth
                    <div class="flex items-center ml-4 space-x-4">

                        {{-- Nombre del usuario con enlace a editar perfil --}}
                        <a href="{{ route('profile.edit') }}" class="flex items-center text-sm font-medium text-gray-700 hover:text-red-600 transition duration-150 ease-in-out">
                            <div class="mr-1">
                                {{-- Icono de usuario (FontAwesome opcional) --}}
                                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            {{ Auth::user()->name }}
                        </a>
                    @auth
                        {{-- Si SÍ está logueado --}}
                        <div class="flex items-center space-x-4 border-l pl-4 ml-2 border-gray-300">
                            <a href="{{ route('profile.edit') }}" class="text-gray-800 font-semibold text-sm hover:text-red-500 transition flex items-center">
                                <span class="mr-2">👤</span> {{ Auth::user()->name }}
                            </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full px-4 py-2 text-left text-sm leading-5 font-bold text-red-600 hover:bg-red-50 focus:outline-none focus:bg-red-50 transition duration-150 ease-in-out rounded-lg">
                            {{ __('🚪 Salir') }}
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
                        {{-- Separador vertical --}}
                        <span class="text-gray-300">|</span>

                        {{-- Botón Salir --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 hover:text-red-600 font-bold uppercase tracking-wider transition duration-150 ease-in-out">
                                Salir
                            </button>
                        </form>
                    </div>
                @endauth

            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-500 hover:text-red-600 text-xs uppercase tracking-wider font-bold transition">
                                    Salir
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            @endauth

            </div>

        </div>
    </div>

    </nav>
