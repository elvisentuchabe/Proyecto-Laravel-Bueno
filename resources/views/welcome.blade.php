@extends('layouts.app')

@section('content')
    <div class="bg-white w-full">
        <div class="flex flex-col lg:flex-row min-h-[600px]">

            <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-12 lg:px-20 py-12 lg:py-0">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold sm:text-5xl md:text-6xl mb-6">
                        <span class="block text-red-600">Bienvenido a</span>
                        <span class="block text-slate-900">RetroVault</span>
                    </h1>

                    <p class="mt-4 text-base text-gray-500 sm:text-lg md:text-xl lg:mx-0">
                        Tu cápsula del tiempo digital. Revive la época dorada de los videojuegos, el software clásico y la cultura pop. Gestiona tu colección y preserva la historia.
                    </p>

                    <div class="mt-8 sm:mt-10 sm:flex sm:justify-center lg:justify-start gap-3">
                        @auth
                            <div class="rounded-md shadow">
                                {{-- AQUI ESTÁ EL CAMBIO IMPORTANTE: route('videojuegos.boveda') --}}
                                <a href="{{ route('videojuegos.boveda') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-bold rounded-md text-white bg-red-600 hover:bg-red-700 md:py-4 md:text-lg transition duration-150">
                                    Ir a mi Bóveda
                                </a>
                            </div>
                        @else
                            <div class="rounded-md shadow">
                                <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-bold rounded-md text-white bg-red-600 hover:bg-red-700 md:py-4 md:text-lg transition duration-150">
                                    Iniciar Sesión
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0">
                                <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-bold rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-4 md:text-lg transition duration-150">
                                    Crear cuenta
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/2 h-64 sm:h-96 lg:h-auto relative bg-gray-50">
                <img class="absolute inset-0 w-full h-full object-cover"
                     src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                     alt="Setup retro con consolas y cassettes">
            </div>
        </div>
    </div>
@endsection
