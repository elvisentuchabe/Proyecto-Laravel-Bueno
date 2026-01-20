<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Bóveda de Favoritos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if($videojuegos->isEmpty())
                        <div class="text-center py-10">
                            <p class="text-gray-500 mb-4">Aún no tienes ningún juego en tu bóveda.</p>
                            <a href="{{ route('videojuegos.index') }}" class="text-indigo-600 hover:underline">
                                ¡Ve a explorar y añade algunos!
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($videojuegos as $juego)
                                <div class="border rounded-lg p-4 flex flex-col bg-gray-50">
                                    {{-- Título e Imagen --}}
                                    <h3 class="font-bold text-lg mb-2 truncate">{{ $juego->titulo }}</h3>
                                    @if($juego->imagen)
                                        <img src="{{ Str::startsWith($juego->imagen, 'http') ? $juego->imagen : asset('storage/'.$juego->imagen) }}" 
                                             class="w-full h-40 object-cover rounded mb-4">
                                    @endif

                                    {{-- Botones --}}
                                    <div class="mt-auto flex justify-between items-center pt-2 border-t border-gray-200">
                                        <a href="{{ route('videojuegos.show', $juego) }}" class="text-sm text-gray-600 hover:text-gray-900">Ver ficha</a>
                                        
                                        {{-- Botón para quitar de favoritos --}}
                                        <form action="{{ route('videojuegos.favorito', $juego) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold flex items-center gap-1">
                                                💔 Quitar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">{{ $videojuegos->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>