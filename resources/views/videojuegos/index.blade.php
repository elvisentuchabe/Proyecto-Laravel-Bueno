<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Colección') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- SEGURIDAD: Solo el ADMIN ve el botón de crear --}}
            @if(Auth::user()->role === 'admin')
                <div class="flex justify-end mb-4">
                    <a href="{{ route('videojuegos.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition">
                        + Nuevo Juego
                    </a>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Carátula</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Título</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Consola</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($videojuegos as $juego)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        @if($juego->imagen)
                                            <img src="{{ Str::startsWith($juego->imagen, 'http') ? $juego->imagen : asset('storage/'.$juego->imagen) }}" 
                                                 class="w-12 h-12 object-cover rounded">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded"></div>
                                        @endif
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <a href="{{ route('videojuegos.show', $juego) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-lg block">
                                            {{ $juego->titulo }}
                                        </a>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                            {{ $juego->consola ? $juego->consola->nombre : 'Sin Consola' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right">
                                        <a href="{{ route('videojuegos.show', $juego) }}" class="text-gray-500 hover:text-gray-900">Ver ficha &rarr;</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="mt-4">
                        {{ $videojuegos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>