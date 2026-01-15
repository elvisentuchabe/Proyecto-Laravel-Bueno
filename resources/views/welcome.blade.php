@extends('layouts.app')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                ¡Ahora sí!
            </h1>
            <p class="text-gray-700">
                Página de bienvenida para cualquier usuario
            </p>
            <ul class="list-disc list-inside mt-2 text-gray-600">
                <li>El archivo <strong>welcome</strong> está cargando correctamente.</li>
                <li>Está heredando el diseño de <strong>layouts.app</strong>.</li>
                <li>Y la barra de navegación de arriba viene de <strong>layouts.navigation</strong>.</li>
            </ul>
        </div>
    </div>
@endsection