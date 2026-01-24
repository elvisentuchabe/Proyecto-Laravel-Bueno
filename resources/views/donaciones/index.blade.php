<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            💳 Zona de Donaciones
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensajes de Feedback --}}
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- TARJETA VISUAL (Izquierda) --}}
                <div class="bg-gradient-to-br from-gray-800 to-black rounded-xl p-6 text-white shadow-xl relative overflow-hidden">
                    <div class="absolute top-4 right-4 text-xl font-bold italic opacity-50">VISA</div>
                    <div class="mt-8 mb-4">
                        <div class="w-12 h-8 bg-yellow-300 rounded opacity-80"></div>
                    </div>
                    <div class="text-2xl font-mono tracking-widest mb-4">
                        **** **** **** 4242
                    </div>
                    <div class="flex justify-between text-sm text-gray-400">
                        <div>
                            <p class="text-xs">Titular</p>
                            <p class="text-white font-bold uppercase">{{ Auth::user()->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs">Expira</p>
                            <p class="text-white">12/30</p>
                        </div>
                    </div>

                    {{-- Saldo --}}
                    <div class="mt-8 pt-4 border-t border-gray-700">
                        <p class="text-xs text-gray-400">Saldo Actual</p>
                        <p class="text-3xl font-bold text-green-400">{{ number_format(Auth::user()->wallet_balance, 2) }}€</p>
                    </div>
                </div>

                {{-- FORMULARIO (Derecha) --}}
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-bold mb-4">Realizar Donación</h3>
                    <form action="{{ route('donar.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Cantidad (€)</label>
                            <input type="number" name="amount" min="1" max="5000" class="w-full border-gray-300 rounded shadow-sm" placeholder="Ej: 20">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Número de Tarjeta (Simulado)</label>
                            <input type="text" name="card_number" maxlength="16" class="w-full border-gray-300 rounded shadow-sm" placeholder="1234567812345678">
                        </div>

                        <div class="flex gap-4 mb-6">
                            <div class="w-1/2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Caducidad</label>
                                <input type="text" name="expiry" placeholder="MM/YY" class="w-full border-gray-300 rounded shadow-sm">
                            </div>
                            <div class="w-1/2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">CVC</label>
                                <input type="text" name="cvc" placeholder="123" maxlength="3" class="w-full border-gray-300 rounded shadow-sm">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded shadow transition transform hover:scale-105">
                            💸 Donar Ahora
                        </button>
                    </form>

                    <div class="mt-4 text-center text-sm text-gray-500">
                        Total donado históricamente: <span class="font-bold text-black">{{ Auth::user()->total_donated }}€</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
