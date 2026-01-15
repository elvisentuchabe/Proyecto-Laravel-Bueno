<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <div class="flex items-center">
                <a href="/">
                    <x-application-logo />
                </a>
            </div>

            <div class="flex items-center space-x-4">
                <a href="/" class="text-gray-600 hover:text-black px-3 py-2 text-sm font-medium">
                    Inicio
                </a>
                <a href="#" class="text-gray-600 hover:text-black px-3 py-2 text-sm font-medium">
                    Nosotros
                </a>
    
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-black px-3 py-2 text-sm font-medium">
                    Login
                </a>
                <a href="{{ route('register') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold px-4 py-2 rounded-md text-sm transition">
                    Registrarse
                </a>
            </div>
        </div>
    </div>
</nav>