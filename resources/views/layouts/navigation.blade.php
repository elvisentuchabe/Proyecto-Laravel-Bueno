<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- LOGO --}}
            <div class="flex items-center">
                <a href="{{ route('welcome') }}">
                    <x-application-logo />
                </a>
            </div>

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

                    @auth
                        {{-- Si SÍ está logueado --}}
                        <div class="flex items-center space-x-4 border-l pl-4 ml-2 border-gray-300">
                            <a href="{{ route('profile.edit') }}" class="text-gray-800 font-semibold text-sm hover:text-red-500 transition flex items-center">
                                <span class="mr-2">👤</span> {{ Auth::user()->name }}
                            </a>

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
