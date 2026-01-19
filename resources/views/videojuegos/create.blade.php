<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Añadir Nuevo Videojuego') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- IMPORTANTE: enctype="multipart/form-data" es obligatorio para subir imágenes --}}
                    <form method="POST" action="{{ route('videojuegos.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="titulo" :value="__('Título del Juego')" />
                            <x-text-input id="titulo" class="block mt-1 w-full" type="text" name="titulo" :value="old('titulo')" required autofocus placeholder="Ej: Super Mario Bros" />
                            <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="consola_id" :value="__('Plataforma / Consola')" />
                            <select id="consola_id" name="consola_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="" disabled selected>Selecciona una consola...</option>
                                @foreach($consolas as $consola)
                                    {{-- Usamos old() para mantener la selección si hay error --}}
                                    <option value="{{ $consola->id }}" {{ old('consola_id') == $consola->id ? 'selected' : '' }}>
                                        {{ $consola->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('consola_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="anio_lanzamiento" :value="__('Año de Lanzamiento')" />
                            <x-text-input id="anio_lanzamiento" class="block mt-1 w-full" type="number" name="anio_lanzamiento" :value="old('anio_lanzamiento')" required min="1950" max="{{ date('Y') }}" />
                            <x-input-error :messages="$errors->get('anio_lanzamiento')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="descripcion" :value="__('Descripción')" />
                            <textarea id="descripcion" name="descripcion" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('descripcion') }}</textarea>
                            <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="imagen" :value="__('Carátula del Juego')" />
                            <input id="imagen" type="file" name="imagen" class="block mt-1 w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100" />
                            <x-input-error :messages="$errors->get('imagen')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Guardar Juego') }}</x-primary-button>
                            <a href="{{ route('videojuegos.index') }}" class="text-gray-600 underline text-sm hover:text-gray-900">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>