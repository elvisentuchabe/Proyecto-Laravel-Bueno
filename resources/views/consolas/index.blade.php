@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
                Mi Colección
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-8 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 shadow-sm rounded-r flex items-center gap-3">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-8 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 shadow-sm rounded-r flex items-center gap-3">
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            @endif

            {{-- GRID DE CONSOLAS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                @foreach ($consolas as $consola)
                    @php
                        // COLORES DE MARCA
                        $brand = match(true) {
                            Str::contains($consola->nombre, ['PS4', 'PS5', 'PlayStation', 'Sony']) => ['from' => 'from-blue-500', 'to' => 'to-indigo-600', 'text' => 'text-blue-600', 'bg_light' => 'bg-blue-50', 'shadow' => 'group-hover:shadow-blue-200'],
                            Str::contains($consola->nombre, ['Xbox', 'Microsoft']) => ['from' => 'from-green-500', 'to' => 'to-emerald-600', 'text' => 'text-green-600', 'bg_light' => 'bg-green-50', 'shadow' => 'group-hover:shadow-green-200'],
                            Str::contains($consola->nombre, ['Switch', 'Nintendo', 'Wii', 'DS']) => ['from' => 'from-red-500', 'to' => 'to-rose-600', 'text' => 'text-red-600', 'bg_light' => 'bg-red-50', 'shadow' => 'group-hover:shadow-red-200'],
                            Str::contains($consola->nombre, ['PC', 'Steam']) => ['from' => 'from-amber-400', 'to' => 'to-orange-500', 'text' => 'text-amber-600', 'bg_light' => 'bg-amber-50', 'shadow' => 'group-hover:shadow-amber-200'],
                            default => ['from' => 'from-purple-500', 'to' => 'to-fuchsia-600', 'text' => 'text-purple-600', 'bg_light' => 'bg-purple-50', 'shadow' => 'group-hover:shadow-purple-200']
                        };
                    @endphp

                    {{-- TARJETA LIMPIA --}}
                    <div class="group relative bg-white rounded-3xl p-6 shadow-sm border border-gray-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl {{ $brand['shadow'] }}">

                        {{-- CABECERA: Etiqueta y Admin --}}
                        <div class="flex justify-between items-start mb-6">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest {{ $brand['bg_light'] }} {{ $brand['text'] }}">
                                {{ $consola->fabricante }}
                            </span>

                            @if(Auth::user()->isAdmin())
                                <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('consolas.edit', $consola) }}" class="p-2 text-gray-400 hover:text-blue-500 transition">✏️</a>
                                    <form action="{{ route('consolas.destroy', $consola) }}" method="POST" onsubmit="return confirm('¿Borrar?');">
                                        @csrf @method('DELETE')
                                        <button class="p-2 text-gray-400 hover:text-red-500 transition">🗑️</button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        {{-- IMAGEN CENTRAL (Grande y Nítida) --}}
                        <div class="h-40 flex items-center justify-center mb-6 relative">
                            {{-- Círculo decorativo detrás --}}
                            <div class="absolute w-32 h-32 rounded-full {{ $brand['bg_light'] }} opacity-0 group-hover:scale-150 group-hover:opacity-50 transition-all duration-500"></div>

                            @if($consola->logo)
                                <img src="{{ Str::startsWith($consola->logo, 'http') ? $consola->logo : asset('storage/' . $consola->logo) }}"
                                     class="relative z-10 h-full w-auto object-contain drop-shadow-md transition-transform duration-300 group-hover:scale-110">
                            @else
                                <div class="relative z-10 w-24 h-24 rounded-2xl bg-gradient-to-br {{ $brand['from'] }} {{ $brand['to'] }} flex items-center justify-center text-white text-4xl font-black shadow-lg">
                                    {{ substr($consola->nombre, 0, 1) }}
                                </div>
                            @endif
                        </div>

                        {{-- INFORMACIÓN --}}
                        <div class="text-center">
                            <h3 class="text-2xl font-black text-gray-800 mb-1 leading-tight">{{ $consola->nombre }}</h3>
                            <p class="text-xs text-gray-400 font-medium">Lanzamiento: {{ $consola->anio_publicacion ?? '----' }}</p>
                        </div>

                        {{-- SEPARADOR --}}
                        <div class="my-6 border-t border-gray-100"></div>

                        {{-- FOOTER: Botón de Color --}}
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col text-left">
                                <span class="text-[10px] text-gray-400 font-bold uppercase">Juegos</span>
                                <span class="text-xl font-black text-gray-800">{{ $consola->juegos->count() }}</span>
                            </div>

                            <a href="{{ route('videojuegos.index', ['consola_id' => $consola->id]) }}"
                               class="px-6 py-2.5 rounded-xl bg-gradient-to-r {{ $brand['from'] }} {{ $brand['to'] }} text-white text-sm font-bold shadow-md hover:shadow-lg hover:shadow-{{ $brand['from'] }}/30 transition-all transform active:scale-95 flex items-center gap-2">
                                Ver Biblioteca
                                <span>→</span>
                            </a>
                        </div>

                    </div>
                @endforeach

            </div>

            {{-- EMPTY STATE --}}
            @if($consolas->isEmpty())
                <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-gray-200 mt-8">
                    <span class="text-6xl block mb-4 grayscale opacity-50">🎮</span>
                    <h3 class="text-xl font-bold text-gray-800">Colección vacía</h3>
                    <p class="text-gray-500 mt-2 text-sm">Añade tu primera consola para empezar.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
