<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Videojuego') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- La ruta 'videojuegos.store' la crearemos en el siguiente paso --}}
                    {{-- enctype es OBLIGATORIO porque vas a subir una imagen --}}
                    <form method="POST" action="{{ route('videojuegos.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="titulo" :value="__('Título del Juego')" />
                            <x-text-input id="titulo" class="block mt-1 w-full" type="text" name="titulo" :value="old('titulo')" required autofocus />
                            <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="consola_id" :value="__('Consola')" />
                            <select id="consola_id" name="consola_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="">Selecciona una consola</option>
                                @foreach($consolas as $consola)
                                    <option value="{{ $consola->id }}">{{ $consola->titulo }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('consola_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="anio_lanzamiento" :value="__('Año de Lanzamiento')" />
                            <x-text-input id="anio_lanzamiento" class="block mt-1 w-full" type="number" name="anio_lanzamiento" :value="old('anio_lanzamiento')" required />
                            <x-input-error :messages="$errors->get('anio_lanzamiento')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="descripcion" :value="__('Descripción')" />
                            <textarea id="descripcion" name="descripcion" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="3">{{ old('descripcion') }}</textarea>
                            <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="imagen" :value="__('Imagen del Juego')" />
                            <input id="imagen" type="file" name="imagen" class="block mt-1 w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100" />
                            <x-input-error :messages="$errors->get('imagen')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Guardar Videojuego') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>