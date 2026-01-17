<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listado de Consolas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if($consolas->isEmpty())
                        <p>No hay consolas registradas.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($consolas as $consola)
                                <div class="border p-4 rounded-lg shadow hover:bg-gray-50">
                                    {{-- Si tienes logos guardados, aquí iría la imagen. 
                                         Asumo que es texto o url por ahora según tu migración --}}
                                    <div class="h-20 bg-gray-200 mb-2 flex items-center justify-center">
                                        @if($consola->logo)
                                            <img src="{{ asset($consola->logo) }}" alt="{{ $consola->titulo }}" class="h-16 object-contain">
                                        @else
                                            <span class="text-gray-500">Sin Logo</span>
                                        @endif
                                    </div>

                                    <h3 class="text-lg font-bold">{{ $consola->titulo }}</h3>
                                    <p class="text-sm text-gray-600">Fabricante: {{ $consola->fabricante }}</p>
                                    <p class="text-sm text-gray-500">Año: {{ $consola->anio_publicacion }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>