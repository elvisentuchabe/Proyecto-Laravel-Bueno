<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Museo de Consolas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($consolas as $consola)
                    <a href="{{ route('consolas.show', $consola->id) }}" class="block transform transition hover:scale-105 duration-300">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                            <div class="p-6">
                                <div class="h-32 flex items-center justify-center mb-4">
                                    <img src="{{ asset($consola->logo) }}" alt="{{ $consola->nombre }}" class="max-h-full max-w-full object-contain">
                                </div>
                                <h3 class="text-lg font-bold text-center">{{ $consola->nombre }}</h3>
                                <p class="text-center text-gray-500">{{ $consola->fabricante }} - {{ $consola->anio_publicacion }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>