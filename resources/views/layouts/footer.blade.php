<footer class="bg-gray-800 text-white py-8 mt-auto"> {{-- mt-auto asegura que se quede abajo --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
        
        <div class="text-center md:text-left">
            <h3 class="text-lg font-bold">🏛️ Museo de Videojuegos</h3>
            <p class="text-gray-400 text-sm mt-1">Preservando la historia digital, bit a bit.</p>
        </div>

        {{-- "A menos que la ruta sea donaciones.* (index o procesar), muestra el botón" --}}
        @unless(request()->routeIs('donaciones.*'))
            <div>
                <a href="{{ route('donaciones.index') }}" class="group relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-500 to-pink-500 group-hover:from-purple-500 group-hover:to-pink-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800">
                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0 flex items-center gap-2">
                        ☕ Invítanos a un café (Donar)
                    </span>
                </a>
            </div>
        @endunless
        
        <div class="text-gray-500 text-xs">
            &copy; {{ date('Y') }} Museo Proyecto. <br>Hecho con ❤️ por el equipo.
        </div>
    </div>
</footer>