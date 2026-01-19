<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Museo de Consolas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- BOTÓN DE AÑADIR (Solo visible para ADMIN) --}}
            @if(Auth::user()->role === 'admin')
                <div class="flex justify-end mb-4">
                    <a href="{{ route('consolas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition duration-150 ease-in-out">
                        + Añadir Consola
                    </a>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if($consolas->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            <p class="text-lg">No hay consolas registradas todavía.</p>
                        </div>
                    @else
                        {{-- Grid de Consolas --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($consolas as $consola)
                                <a href="{{ route('consolas.show', $consola) }}" class="group block border rounded-lg shadow-sm hover:shadow-md hover:bg-gray-50 transition duration-300 overflow-hidden">
                                    
                                    {{-- Imagen / Logo --}}
                                    <div class="h-48 bg-gray-100 flex items-center justify-center p-4 group-hover:bg-white transition">
                                        @if($consola->logo)
                                            <img src="{{ Str::startsWith($consola->logo, 'http') ? $consola->logo : asset('storage/'.$consola->logo) }}" 
                                                 alt="{{ $consola->nombre }}" 
                                                 class="max-h-full max-w-full object-contain transform group-hover:scale-105 transition duration-300">
                                        @else
                                            <span class="text-gray-400 font-bold text-xl">Sin Logo</span>
                                        @endif
                                    </div>

                                    {{-- Datos --}}
                                    <div class="p-4 border-t">
                                        <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:text-blue-600 transition">{{ $consola->nombre }}</h3>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-sm font-semibold text-gray-600 bg-gray-200 px-2 py-1 rounded">
                                                {{ $consola->fabricante }}
                                            </span>
                                            <span class="text-xs text-gray-500 font-mono">
                                                {{ $consola->anio_publicacion }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>