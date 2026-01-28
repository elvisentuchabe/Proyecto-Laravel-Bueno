<x-app-layout>
    {{-- LISTA DE DONANTES --}}
    @if(isset($donantes))
        <div class="py-12 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                {{-- Encabezado --}}
                <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                    <h2 class="text-3xl font-black text-gray-800">
                        Control de Donaciones
                    </h2>
                    <div class="bg-green-100 border border-green-200 text-green-800 px-6 py-3 rounded-xl font-bold text-xl shadow-sm">
                        Total Recaudado: {{ number_format($totalRecaudado, 2) }}€
                    </div>
                </div>

                {{-- Tabla de Donantes --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                    @if($donantes->isEmpty())
                        <div class="p-12 text-center">
                            <h3 class="text-xl font-bold text-gray-400">Aún no hay donaciones registradas.</h3>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-6 py-4">Usuario</th>
                                        <th class="px-6 py-4">Email</th>
                                        <th class="px-6 py-4 text-right">Total Donado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($donantes as $donante)
                                        <tr class="bg-white border-b hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 font-bold text-gray-900 flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold">
                                                    {{ substr($donante->name, 0, 1) }}
                                                </div>
                                                {{ $donante->name }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $donante->email }}
                                            </td>
                                            <td class="px-6 py-4 text-right font-black text-green-600 text-base">
                                                {{ number_format($donante->total_donated, 2) }}€
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    {{-- FORMULARIO DE PAGO --}}
    @else
        <div class="py-12 bg-gray-50 min-h-screen">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm rounded-r flex items-center gap-3">
                        <div>
                            <p class="font-bold">¡Donación Recibida!</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-sm rounded-r">
                        <p class="font-bold">Error</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    {{-- COLUMNA 1: Visuales e Información --}}
                    <div class="space-y-6">
                        
                        {{-- Tarjeta Visual --}}
                        <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl shadow-xl p-6 text-white h-56 flex flex-col justify-between relative overflow-hidden transform transition hover:scale-[1.02] duration-300">
                            {{-- Decoración --}}
                            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                            
                            <div class="flex justify-between items-start z-10">
                                <div class="w-12 h-8 bg-yellow-500/80 rounded flex items-center justify-center shadow-inner">
                                    <div class="w-8 h-5 border border-white/30 rounded-sm"></div>
                                </div>
                                <span class="font-mono text-lg tracking-widest opacity-80">DEBIT</span>
                            </div>

                            <div class="z-10 mt-4">
                                <label class="text-xs text-gray-400 uppercase tracking-wider block mb-1">Número de Tarjeta</label>
                                <div class="text-2xl font-mono tracking-widest text-shadow-sm">
                                    **** **** **** ****
                                </div>
                            </div>

                            <div class="flex justify-between items-end z-10">
                                <div>
                                    <label class="text-[10px] text-gray-400 uppercase block">Titular</label>
                                    <div class="font-medium tracking-wide uppercase text-sm">{{ Auth::user()->name }}</div>
                                </div>
                                <div>
                                    <label class="text-[10px] text-gray-400 uppercase block text-right">Expira</label>
                                    <div class="font-mono text-sm">MM/YY</div>
                                </div>
                            </div>
                        </div>

                        {{-- Tarjeta de Impacto (Total Donado) --}}
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-5">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tu Impacto Total</p>
                                <p class="text-3xl font-black text-gray-800">
                                    {{ number_format(Auth::user()->total_donated, 2) }}€
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Gracias por mantener vivo el museo.</p>
                            </div>
                        </div>

                        {{-- Información de Seguridad --}}
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                                Pago 100% Seguro
                            </h3>
                            <p class="text-sm text-gray-500">
                                Simulación de pasarela de pago segura (SSL). Tus datos viajan encriptados y no se almacenan permanentemente.
                            </p>
                        </div>
                    </div>

                    {{-- COLUMNA 2: Formulario --}}
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 h-fit">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            Realizar Donación
                        </h2>
                        
                        <form action="{{ route('donaciones.store') }}" method="POST" class="space-y-5">
                            @csrf

                            {{-- Cantidad --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cantidad a donar (€)</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-bold">€</span>
                                    <input type="number" name="amount" min="1" max="5000" class="pl-8 w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 transition" placeholder="10" required>
                                </div>
                                @error('amount') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                            </div>

                            {{-- Nombre --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre en la tarjeta</label>
                                <input type="text" name="card_name" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 transition uppercase" placeholder="Your name" required>
                            </div>

                            {{-- Número --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Número de tarjeta</label>
                                <div class="relative">
                                    <input type="text" name="card_number" maxlength="16" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 transition font-mono pl-10" placeholder="0000 0000 0000 0000" required>
                                </div>
                                @error('card_number') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                {{-- Fecha --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Caducidad</label>
                                    <input type="text" name="expiry" placeholder="MM/YY" maxlength="5" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 transition text-center" required>
                                    @error('expiry') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                                </div>
                                
                                {{-- CVC --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">CVC</label>
                                    <div class="relative">
                                        <input type="text" name="cvc" maxlength="3" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 transition text-center" placeholder="123" required>
                                    </div>
                                    @error('cvc') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-red-600 text-white font-bold py-3.5 rounded-lg hover:bg-red-700 transition transform hover:-translate-y-0.5 shadow-lg shadow-red-500/30 mt-6 flex justify-center items-center gap-2">
                                <span>Confirmar Pago</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endif
</x-app-layout>