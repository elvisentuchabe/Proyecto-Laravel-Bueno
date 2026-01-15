<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RetroVault - Proyecto Laravel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">

    {{-- Tu barra de navegación con @auth y @guest --}}
    @include('layouts.navigation')

    {{-- Título de la cabecera opcional (usado en perfil) --}}
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <main class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- CAMBIO CLAVE: Cambiamos @yield por $slot --}}
            {{ $slot }}
        </div>
    </main>

</body>
</html>
