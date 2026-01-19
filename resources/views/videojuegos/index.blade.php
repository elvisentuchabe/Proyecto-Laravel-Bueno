<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Listado de Videojuegos') }}
            </h2>

            {{-- BOTÓN CREAR (Solo Admin) --}}
            {{-- Verificamos primero si está logueado (@auth) y luego si es admin --}}
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('videojuegos.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition shadow-md">
                        + Nuevo Juego
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- TABLA --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Carátula
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Título
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Consola
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($videojuegos as $juego)
                                    <tr class="hover:bg-gray-50 transition duration-150">

                                        {{-- 1. CARÁTULA --}}
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            @if($juego->imagen)
                                                <img src="{{ Str::startsWith($juego->imagen, 'http') ? $juego->imagen : asset('storage/'.$juego->imagen) }}"
                                                     class="w-12 h-12 object-cover rounded shadow-sm">
                                            @else
                                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-xs">
                                                    N/A
                                                </div>
                                            @endif
                                        </td>

                                        {{-- 2. TÍTULO --}}
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <a href="{{ route('videojuegos.show', $juego) }}" class="text-gray-900 hover:text-indigo-600 font-bold text-lg block transition">
                                                {{ $juego->titulo }}
                                            </a>
                                        </td>

                                        {{-- 3. CONSOLA --}}
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ $juego->consola ? $juego->consola->nombre : 'Sin Consola' }}
                                            </span>
                                        </td>

                                        {{-- 4. ACCIONES (Aquí está la lógica combinada) --}}
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right">
                                            <div class="flex justify-end items-center space-x-3">

                                                {{-- Botón VER (Para todos) --}}
                                                <a href="{{ route('videojuegos.show', $juego) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                                    Ver
                                                </a>

                                                {{-- Botones ADMIN (Editar / Eliminar) --}}
                                                @auth
                                                    @if(Auth::user()->role === 'admin')

                                                        <span class="text-gray-300">|</span>

                                                        {{-- Editar --}}
                                                        <a href="{{ route('videojuegos.edit', $juego) }}" class="text-amber-600 hover:text-amber-900 font-medium">
                                                            Editar
                                                        </a>

                                                        {{-- Eliminar (Formulario) --}}
                                                        <form action="{{ route('videojuegos.destroy', $juego) }}" method="POST"
                                                              onsubmit="return confirm('¿Seguro que quieres borrar este juego?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium ml-2">
                                                                Borrar
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINACIÓN --}}
                    <div class="mt-4">
                        {{ $videojuegos->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
