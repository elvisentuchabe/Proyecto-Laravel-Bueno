<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Museo de Consolas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- BOTÓN GLOBAL DE AÑADIR (Solo Admin) --}}
            @if(Auth::user()->role === 'admin')
                <div class="flex justify-end mb-4">
                    <a href="{{ route('consolas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
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
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($consolas as $consola)
                                {{-- CAMBIO: La tarjeta ahora es un div, no un enlace 'a' --}}
                                <div class="border rounded-lg shadow-sm hover:shadow-md transition duration-300 overflow-hidden bg-white flex flex-col">
                                    
                                    {{-- Enlace en la imagen para ir a detalles --}}
                                    <a href="{{ route('consolas.show', $consola) }}" class="h-48 bg-gray-100 flex items-center justify-center p-4 hover:bg-white transition relative">
                                        @if($consola->logo)
                                            <img src="{{ Str::startsWith($consola->logo, 'http') ? $consola->logo : asset('storage/'.$consola->logo) }}" 
                                                 alt="{{ $consola->nombre }}" 
                                                 class="max-h-full max-w-full object-contain">
                                        @else
                                            <span class="text-gray-400 font-bold text-xl">Sin Logo</span>
                                        @endif
                                    </a>

                                    {{-- Datos --}}
                                    <div class="p-4 border-t flex-1 flex flex-col">
                                        <a href="{{ route('consolas.show', $consola) }}" class="hover:text-blue-600 transition">
                                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $consola->nombre }}</h3>
                                        </a>
                                        
                                        <div class="flex justify-between items-center mt-2 mb-4">
                                            <span class="text-sm font-semibold text-gray-600 bg-gray-200 px-2 py-1 rounded">
                                                {{ $consola->fabricante }}
                                            </span>
                                            <span class="text-xs text-gray-500 font-mono">
                                                {{ $consola->anio_publicacion }}
                                            </span>
                                        </div>

                                        {{-- BOTÓN EDITAR (Solo Admin) --}}
                                        @if(Auth::user()->role === 'admin')
                                            <div class="mt-auto pt-3 border-t border-gray-100 flex justify-end">
                                                <a href="{{ route('consolas.edit', $consola) }}" class="text-sm bg-yellow-100 text-yellow-700 hover:bg-yellow-200 py-1 px-3 rounded font-medium transition">
                                                    ✏️ Editar
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>