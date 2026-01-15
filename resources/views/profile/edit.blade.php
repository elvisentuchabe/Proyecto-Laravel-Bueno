<x-app-layout>
    {{-- Título de la sección personalizado para RetroVault --}}
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Gestión de Cuenta - RetroVault') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Bloque 1: Información Personal (Borde Azul para info básica) --}}
            <div class="p-6 bg-white shadow-md sm:rounded-xl border-t-4 border-blue-500">
                <div class="max-w-xl">
                    <header class="mb-6">
                        <h3 class="text-lg font-bold text-gray-900 uppercase tracking-wide">
                            <i class="fa-solid fa-user-gear mr-2"></i> Datos del Usuario
                        </h3>
                        <p class="text-sm text-gray-500">Actualiza tu nombre y correo electrónico vinculado a tu cuenta.</p>
                    </header>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Bloque 2: Cambio de Contraseña (Borde Amarillo - Seguridad RA6) --}}
            <div class="p-6 bg-white shadow-md sm:rounded-xl border-t-4 border-yellow-500">
                <div class="max-w-xl">
                    <header class="mb-6">
                        <h3 class="text-lg font-bold text-gray-900 uppercase tracking-wide">
                            <i class="fa-solid fa-lock mr-2"></i> Seguridad de la Cuenta
                        </h3>
                        <p class="text-sm text-gray-500">Recomendamos usar una contraseña robusta para proteger tu colección.</p>
                    </header>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Bloque 3: Eliminar Cuenta (Borde Rojo - Acción Crítica) --}}
            <div class="p-6 bg-white shadow-md sm:rounded-xl border-t-4 border-red-600">
                <div class="max-w-xl">
                    <header class="mb-6">
                        <h3 class="text-lg font-bold text-red-600 uppercase tracking-wide">
                            <i class="fa-solid fa-triangle-excursion mr-2"></i> Zona Peligrosa
                        </h3>
                        <p class="text-sm text-gray-500">Borrar la cuenta es irreversible. Se perderán todos tus datos de acceso.</p>
                    </header>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
