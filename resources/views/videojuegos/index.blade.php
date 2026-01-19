<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Título Dinámico --}}
            {{ isset($esBoveda) ? '🛡️ Mi Bóveda Personal' : '📚 Biblioteca de Videojuegos' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensajes Flash --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filtro de Búsqueda --}}
            <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
                {{-- La acción del formulario cambia si estamos en boveda o index --}}
                <form action="{{ isset($esBoveda) ? route('videojuegos.boveda') : route('videojuegos.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">

                    <input type="text" name="search" placeholder="Buscar por título..."
                           value="{{ request('search') }}"
                           class="border-gray-300 rounded-md shadow-sm w-full md:w-1/3 focus:border-indigo-500 focus:ring-indigo-500">

                    <select name="consola_id" class="border-gray-300 rounded-md shadow-sm w-full md:w-1/4 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todas las consolas</option>
                        @foreach($consolas as $consola)
                            <option value="{{ $consola->id }}" {{ request('consola_id') == $consola->id ? 'selected' : '' }}>
                                {{ $consola->nombre }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
                        🔍 Filtrar
                    </button>

                    @if(request('search') || request('consola_id'))
                        <a href="{{ isset($esBoveda) ? route('videojuegos.boveda') : route('videojuegos.index') }}" class="text-gray-500 hover:text-black mt-2 md:mt-0 flex items-center">Limpiar</a>
                    @endif
                </form>
            </div>

            {{-- Botón Crear (Solo Admin) --}}
            @if(Auth::user()->isAdmin())
                <div class="flex justify-end mb-4">
                    <a href="{{ route('videojuegos.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition">
                        + Nuevo Juego
                    </a>
                </div>
            @endif

            {{-- Tabla --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Carátula</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Título</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Consola</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Favorito</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($videojuegos as $juego)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        @if($juego->imagen)
                                            <img src="{{ Str::startsWith($juego->imagen, 'http') ? $juego->imagen : asset('storage/'.$juego->imagen) }}"
                                                 class="w-12 h-12 object-cover rounded shadow-sm">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center text-gray-400">?</div>
                                        @endif
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm font-bold text-gray-800">
                                        {{ $juego->titulo }}
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <span class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full text-xs">
                                            {{ $juego->consola ? $juego->consola->nombre : 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                        <form action="{{ route('videojuegos.favorito', $juego) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="transition transform hover:scale-110 focus:outline-none">
                                                {{ Auth::user()->favoritos->contains($juego) ? '❤️' : '🤍' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right">
                                        <a href="{{ route('videojuegos.show', $juego) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold mr-3">Ver</a>
                                        @if(Auth::user()->isAdmin())
                                            <a href="{{ route('videojuegos.edit', $juego) }}" class="text-orange-600 hover:text-orange-900 mr-2">Editar</a>
                                            <form action="{{ route('videojuegos.destroy', $juego) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Borrar?')">X</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $videojuegos->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
