<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Consola') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Formulario apuntando a UPDATE --}}
                    <form method="POST" action="{{ route('consolas.update', $consola) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT') {{-- Importante para editar --}}

                        <div>
                            <x-input-label for="nombre" :value="__('Nombre de la Consola')" />
                            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" 
                                          :value="old('nombre', $consola->nombre)" required autofocus />
                            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="fabricante" :value="__('Fabricante')" />
                            <x-text-input id="fabricante" class="block mt-1 w-full" type="text" name="fabricante" 
                                          :value="old('fabricante', $consola->fabricante)" required />
                            <x-input-error :messages="$errors->get('fabricante')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="anio_publicacion" :value="__('Año de Lanzamiento')" />
                            <x-text-input id="anio_publicacion" class="block mt-1 w-full" type="number" name="anio_publicacion" 
                                          :value="old('anio_publicacion', $consola->anio_publicacion)" required min="1950" max="{{ date('Y') }}" />
                            <x-input-error :messages="$errors->get('anio_publicacion')" class="mt-2" />
                        </div>

                        @if($consola->logo)
                            <div class="mb-2">
                                <span class="block text-sm font-medium text-gray-700">Logo Actual:</span>
                                <div class="mt-2 p-2 bg-gray-100 rounded inline-block">
                                    <img src="{{ Str::startsWith($consola->logo, 'http') ? $consola->logo : asset('storage/'.$consola->logo) }}" class="h-20 object-contain">
                                </div>
                            </div>
                        @endif

                        <div>
                            <x-input-label for="logo" :value="__('Cambiar Logo (Opcional)')" />
                            <input id="logo" type="file" name="logo" class="block mt-1 w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100" />
                            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4 border-t pt-4">
                            <x-primary-button>{{ __('Actualizar Consola') }}</x-primary-button>
                            <a href="{{ route('consolas.index') }}" class="text-gray-600 underline text-sm hover:text-gray-900">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>