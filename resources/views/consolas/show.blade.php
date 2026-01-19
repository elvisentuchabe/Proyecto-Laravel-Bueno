<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $consola->nombre }}
            </h2>
            <a href="{{ route('consolas.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Volver atrás</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <h3 class="text-2xl font-bold mb-4">Catálogo de Juegos</h3>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($consola->juegos->count() > 0)
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Carátula</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Título</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Año</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($consola->juegos as $juego)
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            @if($juego->imagen)
                                                <img src="{{ Str::startsWith($juego->imagen, 'http') ? $juego->imagen : asset('storage/'.$juego->imagen) }}" alt="" class="w-16 h-16 object-cover rounded">
                                            @else
                                                <span class="text-gray-400">Sin imagen</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap font-bold">{{ $juego->titulo }}</p>
                                            <p class="text-gray-600 text-xs">{{ $juego->descripcion }}</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                                <span class="relative">{{ $juego->anio_lanzamiento }}</span>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-center text-gray-500 py-10">No hay juegos registrados para esta consola todavía.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>