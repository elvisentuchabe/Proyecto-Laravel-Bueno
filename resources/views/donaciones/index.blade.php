<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Apoya al Museo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            
            {{-- Mensaje de Éxito --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    <strong class="font-bold">¡Pago Recibido!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Realizar Donación</h3>
                    <p class="text-gray-500 text-sm">Tu apoyo mantiene vivos los servidores.</p>
                </div>

                <form action="{{ route('donaciones.procesar') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="nombre" :value="__('Nombre del Donante')" />
                        <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" required placeholder="Ej: Tu Nombre" />
                    </div>

                    <div>
                        <x-input-label for="cantidad" :value="__('Cantidad (€)')" />
                        <x-text-input id="cantidad" class="block mt-1 w-full" type="number" name="cantidad" min="1" step="0.01" required placeholder="5.00" />
                    </div>

                    <div>
                        <x-input-label for="tarjeta" :value="__('Número de Tarjeta (Simulación)')" />
                        <div class="relative">
                            <x-text-input id="tarjeta" class="block mt-1 w-full pl-10" type="text" name="tarjeta" required placeholder="0000 0000 0000 0000" />
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                💳
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">* No introduzcas una tarjeta real, esto es una demo.</p>
                    </div>

                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none">
                        Confirmar Donación
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>