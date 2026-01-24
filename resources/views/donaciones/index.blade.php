<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Título dinámico según el rol --}}
            @if(Auth::user()->isAdmin())
                💰 Gestión de Donaciones (Admin)
            @else
                💳 Zona de Donaciones
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- =========================================================
                 VISTA DE ADMINISTRADOR (TABLA DE DATOS)
                 ========================================================= --}}
            @if(Auth::user()->isAdmin())

                {{-- Tarjeta de Resumen Total --}}
                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl shadow-lg p-6 text-white mb-8 flex justify-between items-center">
                    <div>
                        <p class="text-purple-200 text-sm font-bold uppercase tracking-wider">Recaudación Total Histórica</p>
                        <p class="text-5xl font-extrabold mt-2">{{ number_format($recaudacionTotal, 2) }}€</p>
                    </div>
                    <div class="text-6xl opacity-30">📊</div>
                </div>

                {{-- Tabla de Donantes --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">🏆 Listado de Donantes</h3>

                        @if($donantes->isEmpty())
                            <p class="text-gray-500 italic text-center py-4">Aún no hay donaciones registradas.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Donado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($donantes as $donante)
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        {{-- Si tienes avatar, podrías ponerlo aquí --}}
                                                        <div class="text-sm font-medium text-gray-900">{{ $donante->name }}</div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-500">{{ $donante->email }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        {{ number_format($donante->total_donated, 2) }}€
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

            {{-- =========================================================
                 VISTA DE USUARIO NORMAL (PASARELA DE PAGO)
                 ========================================================= --}}
            @else

                {{-- MENSAJES DE FEEDBACK --}}
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r shadow-sm">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700 font-bold">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Error en la transacción</h3>
                                <p class="mt-2 text-sm text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r shadow-sm">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Revisa los siguientes campos:</h3>
                                <ul class="mt-2 list-disc list-inside text-sm text-yellow-700">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- ZONA DE CONTENIDO USUARIO --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- COLUMNA IZQUIERDA: TARJETA 3D FLIP --}}
                    <div class="space-y-6">
                        <div class="group h-56 w-full" style="perspective: 1000px;">
                            <div id="creditCard" onclick="flipCard()" class="relative h-full w-full rounded-xl shadow-2xl transition-all duration-700 cursor-pointer" style="transform-style: preserve-3d;">

                                {{-- CARA FRONTAL --}}
                                <div class="absolute inset-0 h-full w-full bg-gradient-to-br from-gray-800 to-black rounded-xl p-6 text-white overflow-hidden" style="backface-visibility: hidden;">
                                    <div class="absolute top-4 right-4 text-xl font-bold italic opacity-50">VISA</div>
                                    <div class="mt-8 mb-4">
                                        <div class="w-12 h-9 bg-yellow-200 rounded-md border border-yellow-400 opacity-90 flex items-center justify-center">
                                            <div class="w-8 h-5 border border-yellow-500 rounded-sm"></div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-xs text-gray-400 mb-1">Card Number</p>
                                        <div class="text-2xl font-mono tracking-widest text-shadow">**** **** **** 4242</div>
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
                                    <p class="absolute bottom-2 right-4 text-[10px] text-gray-500 italic">Click para girar ↻</p>
                                </div>

                                {{-- CARA TRASERA --}}
                                <div class="absolute inset-0 h-full w-full bg-gradient-to-bl from-gray-800 to-black rounded-xl text-white overflow-hidden" style="backface-visibility: hidden; transform: rotateY(180deg);">
                                    <div class="bg-black h-10 w-full mt-6 opacity-90"></div>
                                    <div class="px-6 mt-4">
                                        <p class="text-[10px] text-right text-gray-300 mr-2">CVC / CVV</p>
                                        <div class="bg-white text-black h-10 w-full rounded flex items-center justify-end pr-3 font-mono font-bold tracking-widest relative">
                                            <div class="absolute left-0 top-0 h-full w-3/4 bg-gray-200 opacity-50" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 5px, #ccc 5px, #ccc 10px);"></div>
                                            <span class="z-10 text-red-600 text-xl">{{ Auth::user()->cvc ?? 'XXX' }}</span>
                                        </div>
                                    </div>
                                    <div class="px-6 mt-4">
                                        <p class="text-[8px] text-gray-500 text-justify leading-tight">
                                            Esta tarjeta es intransferible y es propiedad del Banco Laravel.
                                        </p>
                                    </div>
                                    <div class="absolute bottom-4 right-6 w-12 h-8 bg-gray-400 rounded-full opacity-30 blur-sm"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Saldo --}}
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mt-4">
                            <p class="text-gray-500 text-sm font-bold uppercase mb-2">Tu Saldo Disponible</p>
                            <p class="text-3xl font-bold text-green-600">{{ number_format(Auth::user()->wallet_balance, 2) }}€</p>
                            <p class="text-xs text-gray-400 mt-2">Total donado hasta la fecha: {{ number_format(Auth::user()->total_donated, 2) }}€</p>
                        </div>
                    </div>

                    {{-- COLUMNA DERECHA: FORMULARIO --}}
                    <div class="bg-white p-8 rounded-xl shadow-md h-fit">
                        <h3 class="text-lg font-bold mb-4">Realizar Donación</h3>
                        <form action="{{ route('donaciones.store') }}" method="POST">
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

                {{-- SCRIPT JAVASCRIPT (SOLO PARA USUARIOS NORMALES QUE TIENEN TARJETA) --}}
                <script>
                    function flipCard() {
                        const card = document.getElementById('creditCard');
                        if (card.style.transform === 'rotateY(180deg)') {
                            card.style.transform = 'rotateY(0deg)';
                        } else {
                            card.style.transform = 'rotateY(180deg)';
                        }
                    }
                </script>

            @endif {{-- Fin del IF Admin --}}

        </div>
    </div>
</x-app-layout>
