<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RetroVault - Proyecto Laravel</title>

    {{-- Carga de estilos y scripts de Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
{{-- CAMBIO 1: Añadimos 'min-h-screen flex flex-col' al body --}}
<body class="bg-gray-100 font-sans antialiased min-h-screen flex flex-col">

    {{-- Menú de navegación --}}
    @include('layouts.navigation')

    {{-- Cabecera --}}
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    {{-- Contenido Principal --}}
    {{-- CAMBIO 2: Añadimos 'flex-grow' o 'flex-1' para que este div ocupe todo el espacio libre --}}
    <main class="flex-grow py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensajes de estado --}}
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            {{-- Slots y Contenido --}}
            @isset($slot)
                {{ $slot }}
            @endisset

            @yield('content')
        </div>
    </main>

    {{-- CAMBIO 3: El Footer va aquí, fuera del main, justo antes de cerrar body --}}
    @include('layouts.footer')

</body>
</html>