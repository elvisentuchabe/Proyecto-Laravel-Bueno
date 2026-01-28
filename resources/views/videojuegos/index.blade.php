@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center gap-2">
                {{ isset($esBoveda) ? '🛡️ Mi Bóveda' : '📚 Biblioteca' }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-8 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 shadow-sm rounded-r flex items-center gap-3">
                    <span class="text-xl">✅</span>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            {{-- 🔍 FILTRO UNIBODY (Corregido: Sin doble flecha) --}}
            <div class="mb-12 max-w-5xl mx-auto">
                <form action="{{ isset($esBoveda) ? route('videojuegos.boveda') : route('videojuegos.index') }}" method="GET">

                    <div class="relative flex flex-col md:flex-row items-center p-1.5 rounded-3xl shadow-xl bg-gradient-to-br from-gray-100 to-gray-200 border border-white ring-1 ring-gray-200/50">

                        {{-- BUSCADOR --}}
                        <div class="relative w-full md:flex-1 group">
                            <div class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-600 transition-colors z-10 pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" placeholder="Buscar juego..." value="{{ request('search') }}"
                                   class="w-full pl-14 pr-4 py-4 bg-transparent border-none focus:ring-0 text-gray-800 font-bold placeholder-gray-500 h-16 rounded-l-2xl">
                        </div>

                        <div class="hidden md:block w-px h-8 bg-gray-300 mx-2"></div>
                        <div class="block md:hidden w-full h-px bg-gray-300 my-2"></div>

                        {{-- SELECTOR DE CONSOLAS (bg-none añadido para quitar flecha duplicada) --}}
                        <div class="relative w-full md:w-1/3 group">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-600 transition-colors z-10 pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            </div>

                            {{-- AQUÍ ESTÁ EL CAMBIO: 'bg-none' --}}
                            <select name="consola_id" class="w-full pl-12 pr-10 py-4 bg-transparent border-none focus:ring-0 text-gray-700 font-bold appearance-none bg-none cursor-pointer h-16">
                                <option value="">Todas las plataformas</option>
                                @foreach($consolas as $consola)
                                    <option value="{{ $consola->id }}" {{ request('consola_id') == $consola->id ? 'selected' : '' }}>
                                        {{ $consola->nombre }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- Flecha personalizada única --}}
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        {{-- BOTÓN BUSCAR --}}
                        <button type="submit" class="w-full md:w-auto bg-gray-900 hover:bg-black text-white font-bold py-3.5 px-8 rounded-2xl transition-all shadow-lg hover:shadow-2xl hover:-translate-y-0.5 ml-2">
                            Buscar
                        </button>

                        {{-- BOTÓN LIMPIAR --}}
                        @if(request('search') || request('consola_id'))
                            <a href="{{ isset($esBoveda) ? route('videojuegos.boveda') : route('videojuegos.index') }}"
                               class="absolute -top-3 -right-3 bg-red-500 text-white p-1.5 rounded-full shadow-md hover:bg-red-600 hover:scale-110 transition z-20" title="Limpiar todo">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- GRID DE JUEGOS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach ($videojuegos as $juego)
                    <div class="group relative bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 h-96">

                        <div class="absolute inset-0 h-full w-full bg-gray-100">
                            @if($juego->imagen)
                                <img src="{{ Str::startsWith($juego->imagen, 'http') ? $juego->imagen : asset('storage/'.$juego->imagen) }}"
                                     alt="{{ $juego->titulo }}"
                                     class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="h-full w-full flex flex-col items-center justify-center bg-gray-800 text-white">
                                    <span class="text-5xl mb-2 opacity-50">🎮</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-300"></div>
                        </div>

                        <div class="absolute top-4 left-4 z-10">
                            @php
                                $nombreConsola = $juego->consola->nombre ?? 'General';
                                $colorBadge = match(true) {
                                    Str::contains($nombreConsola, ['PS4', 'PS5', 'PlayStation']) => 'bg-blue-600',
                                    Str::contains($nombreConsola, ['Xbox', 'Series']) => 'bg-green-600',
                                    Str::contains($nombreConsola, ['Switch', 'Nintendo']) => 'bg-red-600',
                                    Str::contains($nombreConsola, ['PC']) => 'bg-gray-800',
                                    default => 'bg-purple-600'
                                };
                            @endphp
                            <span class="{{ $colorBadge }} text-white text-[10px] font-bold px-3 py-1.5 rounded-full shadow-lg backdrop-blur-md bg-opacity-90 uppercase tracking-wide border border-white/20">
                                {{ $nombreConsola }}
                            </span>
                        </div>

                        <div class="absolute top-3 right-3 z-20">
                            <form action="{{ route('videojuegos.favorito', $juego) }}" method="POST">
                                @csrf
                                @php $esFavorito = Auth::user()->favoritos->contains($juego); @endphp
                                <button type="submit" class="p-2.5 rounded-full transition-all duration-300 transform hover:scale-110 {{ $esFavorito ? 'bg-white text-red-500 shadow-lg' : 'bg-black/40 text-white hover:bg-white hover:text-red-500 backdrop-blur-md border border-white/10' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="{{ $esFavorito ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                            <h3 class="text-xl font-black text-white leading-tight mb-1 drop-shadow-lg tracking-tight">{{ $juego->titulo }}</h3>
                            <p class="text-gray-300 text-xs font-bold uppercase tracking-wider mb-4 opacity-80">{{ $juego->anio_lanzamiento }}</p>

                            <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-75">
                                <a href="{{ route('videojuegos.show', $juego) }}" class="flex-1 bg-white/95 backdrop-blur text-gray-900 text-center py-2.5 rounded-xl font-bold text-sm hover:bg-white transition shadow-lg">Ver</a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('videojuegos.edit', $juego) }}" class="p-2.5 bg-gray-800/80 text-white rounded-xl hover:bg-blue-600 transition backdrop-blur">✏️</a>
                                    <form action="{{ route('videojuegos.destroy', $juego) }}" method="POST" onsubmit="return confirm('¿Eliminar?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2.5 bg-gray-800/80 text-white rounded-xl hover:bg-red-600 transition backdrop-blur">🗑️</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $videojuegos->appends(request()->query())->links() }}
            </div>

            @if($videojuegos->isEmpty())
                <div class="text-center py-20 bg-white rounded-3xl shadow-sm mt-8 border border-dashed border-gray-200">
                    <span class="text-6xl block mb-4 grayscale opacity-30">👾</span>
                    <h3 class="text-xl font-bold text-gray-600">Sin resultados</h3>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

