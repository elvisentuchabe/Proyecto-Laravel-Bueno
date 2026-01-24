<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DonacionController extends Controller
{
    public function index()
    {
        // Si es ADMINISTRADOR: Ve la tabla de gestión
        if (Auth::user()->role === 'admin') {
            $donantes = \App\Models\User::where('total_donated', '>', 0)
                                        ->orderByDesc('total_donated')
                                        ->get();

            $recaudacionTotal = \App\Models\User::sum('total_donated');

            return view('donaciones.index', compact('donantes', 'recaudacionTotal'));
        }

        // Si es USUARIO NORMAL: Ve la pasarela de pago
        return view('donaciones.index');
    }

    public function store(Request $request)
    {
        // 1. VALIDACIÓN SEGURA DEL FORMULARIO
        $request->validate([
            'amount' => 'required|numeric|min:1|max:5000',

            // --- AQUÍ ESTÁ EL CAMBIO DEL CVC ---
            'cvc' => [
                'required',
                'digits:3', // Debe tener 3 números
                function ($attribute, $value, $fail) {
                    // Obtenemos el usuario actual
                    $userCVC = Auth::user()->cvc;

                    // Si el usuario no tiene CVC configurado en la base de datos
                    if (!$userCVC) {
                         // Opcional: Si quieres permitir pagar si no tienen tarjeta guardada, borra este if.
                         // Pero para tu caso estricto:
                         $fail('No tienes una tarjeta vinculada con CVC en tu cuenta.');
                         return;
                    }

                    // Comparamos lo que escribió ($value) con lo que hay en la BD ($userCVC)
                    if ($value != $userCVC) {
                        $fail('⛔ El CVC es incorrecto. Revisa el reverso de tu tarjeta.');
                    }
                },
            ],

            // Validación Tarjeta (Algoritmo de Luhn) - Mantenemos tu código pro
            'card_number' => ['bail', 'required', 'digits:16', function ($attribute, $value, $fail) {
                $sum = 0;
                $flag = 0;
                for ($i = strlen($value) - 1; $i >= 0; $i--) {
                    $digit = (int) $value[$i];
                    $add = $flag++ & 1 ? $digit * 2 : $digit;
                    $sum += $add > 9 ? $add - 9 : $add;
                }
                if ($sum % 10 !== 0) {
                    $fail('El número de tarjeta no es válido (Fallo de autenticidad).');
                }
            }],

            // Validación Caducidad
            'expiry' => ['required', function ($attribute, $value, $fail) {
                if (!preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/', $value, $matches)) {
                    return $fail('Formato inválido. Usa MM/YY (Ej: 12/25).');
                }
                $mes = $matches[1];
                $anio = '20' . $matches[2];
                $fechaTarjeta = Carbon::createFromDate($anio, $mes, 1)->endOfMonth();

                if ($fechaTarjeta->isPast()) {
                    $fail('Tu tarjeta ha caducado.');
                }
            }],
        ], [
            // MENSAJES PERSONALIZADOS
            'amount.min' => 'La donación mínima es de 1€.',
            'amount.max' => 'El límite máximo es de 5000€.',
            'cvc.digits' => 'El CVC debe tener exactamente 3 dígitos.',
            'card_number.digits' => 'La tarjeta debe tener 16 dígitos.',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 2. SIMULACIÓN DE ESPERA
        sleep(1);

        // 3. LÓGICA DE PAGO
        try {
            // Comprobamos saldo en la cartera virtual
            if ($user->wallet_balance < $request->amount) {
                return back()->with('error', "Saldo insuficiente. Tienes {$user->wallet_balance}€ y quieres donar {$request->amount}€.");
            }

            // Realizamos la transacción
            $user->wallet_balance -= $request->amount;
            $user->total_donated += $request->amount;
            $user->save();

            return redirect()->route('donar.index')
                ->with('success', "¡Donación exitosa! Se verificó tu CVC y se descontaron {$request->amount}€.");

        } catch (\Exception $e) {
            return back()->with('error', 'Error técnico en el proceso. Inténtalo más tarde.');
        }
    }
}
