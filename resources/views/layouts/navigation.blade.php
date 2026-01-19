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
            </div>

        </div>
    </div>

    </nav>
