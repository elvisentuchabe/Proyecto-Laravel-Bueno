<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonacionController extends Controller
{
    // Muestra la pantalla de la tarjeta
    public function index()
    {
        return view('donaciones.index');
    }

    // Procesa el pago
    public function store(Request $request)
    {
        // 1. Validaciones
        $request->validate([
            'amount' => 'required|numeric|min:1|max:5000',
            'card_number' => 'required|digits:16', // Debe tener 16 números
            'cvc' => 'required|digits:3',
            'expiry' => 'required',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 2. Comprobar si tiene saldo suficiente
        if ($user->wallet_balance < $request->amount) {
            return back()->with('error', '🚫 Transacción rechazada: No tienes suficiente saldo.');
        }

        // 3. Realizar la transacción
        $user->wallet_balance -= $request->amount; // Restamos saldo
        $user->total_donated += $request->amount;  // Sumamos a donaciones
        $user->save();

        return redirect()->route('donar.index')
            ->with('success', "✅ ¡Donación de {$request->amount}€ recibida! Gracias.");
    }
}
