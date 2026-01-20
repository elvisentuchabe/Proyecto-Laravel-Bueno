<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

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
                        <a href="{{ route('register') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold px-4 py-2 rounded-md text-sm transition shadow-md">
                            Registrarse
                        </a>
                    @endguest

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

            </div>

        </div>
    </div>

    </nav>
