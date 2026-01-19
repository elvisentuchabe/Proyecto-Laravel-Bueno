<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Añadir Nueva Consola') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('consolas.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="nombre" :value="__('Nombre de la Consola')" />
                            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus placeholder="Ej: Super Nintendo" />
                            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="fabricante" :value="__('Fabricante')" />
                            <x-text-input id="fabricante" class="block mt-1 w-full" type="text" name="fabricante" :value="old('fabricante')" required placeholder="Ej: Nintendo, Sega, Sony..." />
                            <x-input-error :messages="$errors->get('fabricante')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="anio_publicacion" :value="__('Año de Lanzamiento')" />
                            <x-text-input id="anio_publicacion" class="block mt-1 w-full" type="number" name="anio_publicacion" :value="old('anio_publicacion')" required />
                            <x-input-error :messages="$errors->get('anio_publicacion')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="logo" :value="__('Logo (Imagen)')" />
                            <input id="logo" type="file" name="logo" class="block mt-1 w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100" />
                            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Guardar Consola') }}</x-primary-button>
                            <a href="{{ route('consolas.index') }}" class="text-gray-600 underline text-sm hover:text-gray-900">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>