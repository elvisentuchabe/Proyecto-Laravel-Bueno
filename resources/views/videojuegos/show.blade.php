<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalles del Juego
            </h2>
            <a href="{{ route('videojuegos.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Volver a la lista
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-col md:flex-row gap-8">
                    
                    <div class="w-full md:w-1/3">
                        @if($videojuego->imagen)
                            <img src="{{ Str::startsWith($videojuego->imagen, 'http') ? $videojuego->imagen : asset('storage/'.$videojuego->imagen) }}" 
                                 alt="{{ $videojuego->titulo }}" 
                                 class="w-full h-auto rounded-lg shadow-lg object-cover">
                        @else
                            <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">
                                Sin carátula
                            </div>
                        @endif
                    </div>

                    <div class="w-full md:w-2/3">
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $videojuego->titulo }}</h1>
                        
                        <div class="flex items-center space-x-4 mb-6">
                            <span class="bg-indigo-100 text-indigo-800 text-sm font-medium px-3 py-1 rounded dark:bg-indigo-900 dark:text-indigo-300">
                                {{ $videojuego->consola ? $videojuego->consola->nombre : 'Consola Desconocida' }}
                            </span>
                            <span class="text-gray-500 text-sm font-semibold">
                                Año: {{ $videojuego->anio_lanzamiento }}
                            </span>
                        </div>

                        <div class="prose max-w-none text-gray-700 mb-8">
                            <h3 class="text-lg font-semibold mb-2">Descripción</h3>
                            <p>{{ $videojuego->descripcion ?: 'No hay descripción disponible para este título.' }}</p>
                        </div>

                        {{-- ZONA SEGURA: Solo el ADMIN ve los botones de acción --}}
                        @if(Auth::user()->role === 'admin')
                            <div class="flex space-x-3 pt-6 border-t border-gray-100">
                                <a href="{{ route('videojuegos.edit', $videojuego) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition">
                                    Editar
                                </a>
                                
                                <form action="{{ route('videojuegos.destroy', $videojuego) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres borrar este juego?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition">
                                        Borrar
                                    </button>
                                </form>
                            </div>
                        @endif
                        {{-- Fin de zona segura --}}

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>