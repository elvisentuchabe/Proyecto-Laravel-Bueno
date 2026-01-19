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
                    
                    {{-- CAMBIO 1: La ruta apunta a 'update' y pasamos el objeto $videojuego --}}
                    <form method="POST" action="{{ route('videojuegos.update', $videojuego) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        {{-- CAMBIO 2: Directiva obligatoria para actualizaciones --}}
                        @method('PUT')

                        <div>
                            <x-input-label for="titulo" :value="__('Título del Juego')" />
                            {{-- CAMBIO 3: En 'value', usamos el dato del juego ($videojuego->titulo) como valor por defecto --}}
                            <x-text-input id="titulo" class="block mt-1 w-full" type="text" name="titulo" 
                                          :value="old('titulo', $videojuego->titulo)" required autofocus />
                            <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="consola_id" :value="__('Plataforma / Consola')" />
                            <select id="consola_id" name="consola_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="" disabled>Selecciona una consola...</option>
                                @foreach($consolas as $consola)
                                    {{-- CAMBIO 4: Lógica para pre-seleccionar la consola que ya tenía el juego --}}
                                    <option value="{{ $consola->id }}" 
                                        {{ old('consola_id', $videojuego->consola_id) == $consola->id ? 'selected' : '' }}>
                                        {{ $consola->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('consola_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="anio_lanzamiento" :value="__('Año de Lanzamiento')" />
                            <x-text-input id="anio_lanzamiento" class="block mt-1 w-full" type="number" name="anio_lanzamiento" 
                                          :value="old('anio_lanzamiento', $videojuego->anio_lanzamiento)" required />
                            <x-input-error :messages="$errors->get('anio_lanzamiento')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="descripcion" :value="__('Descripción')" />
                            {{-- CAMBIO 5: En textareas, el valor va entre las etiquetas, no en un atributo value --}}
                            <textarea id="descripcion" name="descripcion" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('descripcion', $videojuego->descripcion) }}</textarea>
                            <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                        </div>

                        @if($videojuego->imagen)
                            <div class="mb-4">
                                <span class="block text-sm font-medium text-gray-700">Imagen Actual:</span>
                                <img src="{{ Str::startsWith($videojuego->imagen, 'http') ? $videojuego->imagen : asset('storage/'.$videojuego->imagen) }}" class="w-32 h-32 object-cover mt-2 rounded border">
                            </div>
                        @endif

                        <div>
                            <x-input-label for="imagen" :value="__('Cambiar Carátula (Opcional)')" />
                            <input id="imagen" type="file" name="imagen" class="block mt-1 w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100" />
                            <x-input-error :messages="$errors->get('imagen')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Actualizar Juego') }}</x-primary-button>
                            <a href="{{ route('videojuegos.show', $videojuego) }}" class="text-gray-600 underline text-sm hover:text-gray-900">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>