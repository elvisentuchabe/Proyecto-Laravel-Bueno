<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex items-center">
                <a href="{{ route('welcome') }}">
                    <x-application-logo />
                </a>
            </div>

            <div class="flex items-center space-x-4">
                <a href="{{ route('welcome') }}" class="text-gray-600 hover:text-black px-3 py-2 text-sm font-medium">
                    Inicio
                </a>
                <a href="#" class="text-gray-600 hover:text-black px-3 py-2 text-sm font-medium">
                    Nosotros
                </a>

                {{-- LÓGICA DE SEGURIDAD (AYMAN - RA6) --}}

                @guest
                    {{-- Esto solo se ve si el usuario NO ha iniciado sesión --}}
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-black px-3 py-2 text-sm font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold px-4 py-2 rounded-md text-sm transition">
                        Registrarse
                    </a>
                @endguest

                @auth
                    {{-- Esto solo se ve si el usuario SÍ ha iniciado sesión --}}
                    <div class="flex items-center space-x-4 border-l pl-4 ml-2">
                        <a href="{{ route('profile.edit') }}" class="text-gray-800 font-semibold text-sm hover:text-red-500 transition">
                            <i class="fa-regular fa-user mr-1"></i> {{ Auth::user()->name }}
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
</nav>
