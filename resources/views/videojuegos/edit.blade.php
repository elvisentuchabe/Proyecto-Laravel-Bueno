<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Videojuego') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Formulario para Editar (Apunta a la ruta UPDATE) --}}
                    <form action="{{ route('videojuegos.update', $videojuego) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT') {{-- ¡Importantísimo! Convierte el POST en un PUT --}}

                        <div>
                            <label for="titulo" class="block font-medium text-sm text-gray-700">Título</label>
                            <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $videojuego->titulo) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                        </div>

                        <div>
                            <label for="anio_lanzamiento" class="block font-medium text-sm text-gray-700">Año de Lanzamiento</label>
                            <input type="number" name="anio_lanzamiento" id="anio_lanzamiento" value="{{ old('anio_lanzamiento', $videojuego->anio_lanzamiento) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                        </div>

                        <div>
                            <label for="consola_id" class="block font-medium text-sm text-gray-700">Consola</label>
                            <select name="consola_id" id="consola_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                                @foreach($consolas as $consola)
                                    <option value="{{ $consola->id }}" {{ $videojuego->consola_id == $consola->id ? 'selected' : '' }}>
                                        {{ $consola->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="descripcion" class="block font-medium text-sm text-gray-700">Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">{{ old('descripcion', $videojuego->descripcion) }}</textarea>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Imagen Actual</label>
                            @if($videojuego->imagen)
                                <img src="{{ Storage::url($videojuego->imagen) }}" alt="Carátula" class="w-32 h-32 object-cover mt-2 mb-2 rounded border">
                            @else
                                <p class="text-gray-500 text-sm mt-1">No hay imagen subida</p>
                            @endif

                            <label for="imagen" class="block font-medium text-sm text-gray-700 mt-4">Cambiar Imagen (Opcional)</label>
                            <input type="file" name="imagen" id="imagen" class="block w-full text-sm text-gray-500 mt-1 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>

                        <div class="flex items-center gap-4 mt-4">
                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                                Actualizar Juego
                            </button>
                            <a href="{{ route('videojuegos.index') }}" class="text-gray-600 hover:underline">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>