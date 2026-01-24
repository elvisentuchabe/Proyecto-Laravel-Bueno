<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RetroVault - Proyecto Laravel</title>

    {{-- Carga de estilos y scripts de Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">

    {{-- Menú de navegación dinámico --}}
    @include('layouts.navigation')

    {{-- Cabecera opcional para títulos de página --}}
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    {{-- Contenido Principal Híbrido --}}
    <main class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- AQUI VA EL PASO 3 (Feedback) --}}
            {{-- Le añadí 'mb-4' para que no se pegue al contenido de abajo --}}
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif
            {{-- FIN DEL PASO 3 --}}

            {{-- Soporte para Componentes de Blade ($slot) --}}
            @isset($slot)
                {{ $slot }}
            @endisset

            {{-- Soporte para Plantillas tradicionales (@yield) --}}
            @yield('content')
        </div>
    </main>

</body>
</html>
