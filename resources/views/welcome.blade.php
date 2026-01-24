@php
    use App\Models\User;
    use App\Models\Juego;   // <--- CORREGIDO: Usamos Juego en vez de Videojuego
    use App\Models\Consola;

    // Solo cargamos datos si el usuario está logueado y es admin
    $isAdmin = Auth::check() && Auth::user()->isAdmin();

    // Variables por defecto
    $totalUsers = 0;
    $totalMoney = 0;
    $totalJuegos = 0;
    $totalConsolas = 0;
    $latestGames = collect([]);
    $topConsolas = collect([]);

    if ($isAdmin) {
        $totalUsers = User::count();
        $totalMoney = User::sum('total_donated');

        // CORREGIDO: Usamos el modelo Juego
        if (class_exists(Juego::class)) {
            $totalJuegos = Juego::count();
            // Traemos los últimos 5 juegos (asumiendo relación 'consola')
            $latestGames = Juego::with('consola')->latest()->take(5)->get();
        }

        if (class_exists(Consola::class)) {
            $totalConsolas = Consola::count();
            // Intentamos sacar el top consolas (relación 'juegos')
            $topConsolas = Consola::withCount('juegos')->orderByDesc('juegos_count')->take(4)->get();
        }
    }
@endphp

<x-app-layout>
    {{-- CASO 1: SI ES ADMINISTRADOR -> DASHBOARD DE MANDO --}}
    @if($isAdmin)
        <div class="py-12 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <h1 class="text-3xl font-black text-gray-800 mb-8 flex items-center gap-3">
                    <span class="text-red-600">⚡</span> Panel de Control
                </h1>

                {{-- 1. TARJETAS DE ESTADÍSTICAS (KPIs) --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                    {{-- Usuarios --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between transition hover:-translate-y-1 hover:shadow-md">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Usuarios</p>
                            <p class="text-3xl font-black text-gray-800 mt-1">{{ $totalUsers }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-xl text-xl">👥</div>
                    </div>

                    {{-- Recaudación --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between transition hover:-translate-y-1 hover:shadow-md">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Donaciones</p>
                            <p class="text-3xl font-black text-green-600 mt-1">{{ number_format($totalMoney, 0) }}€</p>
                        </div>
                        <div class="p-3 bg-green-50 text-green-600 rounded-xl text-xl">💰</div>
                    </div>

                    {{-- Juegos --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between transition hover:-translate-y-1 hover:shadow-md">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Videojuegos</p>
                            <p class="text-3xl font-black text-gray-800 mt-1">{{ $totalJuegos }}</p>
                        </div>
                        <div class="p-3 bg-red-50 text-red-600 rounded-xl text-xl">👾</div>
                    </div>

                    {{-- Consolas --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between transition hover:-translate-y-1 hover:shadow-md">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Consolas</p>
                            <p class="text-3xl font-black text-gray-800 mt-1">{{ $totalConsolas }}</p>
                        </div>
                        <div class="p-3 bg-purple-50 text-purple-600 rounded-xl text-xl">🎮</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- 2. ACCIONES RÁPIDAS (Accesos directos) --}}
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 lg:col-span-1 h-full">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            🚀 Acciones Rápidas
                        </h3>
                        <div class="space-y-4">
                            <a href="{{ route('videojuegos.create') }}" class="flex items-center justify-between p-4 bg-gray-50 hover:bg-red-50 hover:border-red-200 border border-transparent rounded-xl transition group">
                                <span class="font-bold text-gray-700 group-hover:text-red-700">Añadir Nuevo Juego</span>
                                <span class="bg-white shadow px-2 rounded text-gray-400 group-hover:text-red-500 text-lg font-bold">+</span>
                            </a>
                            <a href="{{ route('consolas.create') }}" class="flex items-center justify-between p-4 bg-gray-50 hover:bg-red-50 hover:border-red-200 border border-transparent rounded-xl transition group">
                                <span class="font-bold text-gray-700 group-hover:text-red-700">Añadir Nueva Consola</span>
                                <span class="bg-white shadow px-2 rounded text-gray-400 group-hover:text-red-500 text-lg font-bold">+</span>
                            </a>
                            <a href="{{ route('donar.index') }}" class="flex items-center justify-between p-4 bg-gray-50 hover:bg-green-50 hover:border-green-200 border border-transparent rounded-xl transition group">
                                <span class="font-bold text-gray-700 group-hover:text-green-700">Ver Donantes</span>
                                <span class="bg-white shadow px-2 rounded text-gray-400 group-hover:text-green-500 text-lg font-bold">€</span>
                            </a>
                        </div>
                    </div>

                    {{-- 3. ESTADÍSTICAS DE CONSOLAS --}}
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 lg:col-span-2 h-full">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            🏆 Consolas Top
                        </h3>
                        <div class="space-y-6">
                            @foreach($topConsolas as $consola)
                                @php
                                    $porcentaje = $totalJuegos > 0 ? ($consola->juegos_count / $totalJuegos) * 100 : 0;
                                @endphp
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm font-bold text-gray-700">{{ $consola->nombre }}</span>
                                        <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded">{{ $consola->juegos_count }} juegos</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                                        <div class="bg-gradient-to-r from-red-500 to-red-600 h-3 rounded-full transition-all duration-1000" style="width: {{ $porcentaje }}%"></div>
                                    </div>
                                </div>
                            @endforeach

                            @if($topConsolas->isEmpty())
                                <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                    <p class="text-gray-400">Aún no hay suficientes datos para mostrar estadísticas.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

    {{-- CASO 2: USUARIO NORMAL O INVITADO --}}
    @else
        <div class="relative bg-white overflow-hidden min-h-[calc(100vh-65px)]">
            <div class="max-w-7xl mx-auto">
                <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 min-h-[calc(100vh-65px)] flex flex-col justify-center">

                    <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                        <div class="sm:text-center lg:text-left">
                            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                                <span class="block xl:inline">Bienvenido a</span>
                                <span class="block text-gray-900">Retro<span class="text-red-600">Vault</span></span>
                            </h1>
                            <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                Tu cápsula del tiempo digital. Revive la época dorada de los videojuegos, gestiona tu colección y preserva la historia del software clásico.
                            </p>

                            <div class="mt-8 sm:mt-10 sm:flex sm:justify-center lg:justify-start gap-3">
                                @auth
                                    <div class="rounded-md shadow">
                                        {{-- Botón para ir a los juegos --}}
                                        <a href="{{ route('videojuegos.index') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-bold rounded-md text-white bg-red-600 hover:bg-red-700 md:py-4 md:text-lg transition transform hover:-translate-y-1 hover:shadow-lg">
                                            Ir a mi Bóveda
                                        </a>
                                    </div>
                                @else
                                    <div class="rounded-md shadow">
                                        <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-bold rounded-md text-white bg-red-600 hover:bg-red-700 md:py-4 md:text-lg transition transform hover:-translate-y-1 hover:shadow-lg">
                                            Crear Cuenta Gratis
                                        </a>
                                    </div>
                                    <div class="mt-3 sm:mt-0">
                                        <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-bold rounded-md text-red-700 bg-red-50 hover:bg-red-100 md:py-4 md:text-lg transition">
                                            Iniciar Sesión
                                        </a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </main>
                </div>
            </div>

            <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-gray-50">
                <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full"
                     src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?ixlib=rb-1.2.1&auto=format&fit=crop&w=2250&q=80"
                     alt="Retro gaming setup">
            </div>
        </div>
    @endif
</x-app-layout>
