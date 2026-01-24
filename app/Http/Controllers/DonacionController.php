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

            // 1. Buscamos a los usuarios que han donado algo (más de 0)
            $donantes = \App\Models\User::where('total_donated', '>', 0)
                                        ->orderByDesc('total_donated') // Los que más han donado primero
                                        ->get();

            // 2. Calculamos el total de dinero recaudado en toda la plataforma
            $recaudacionTotal = \App\Models\User::sum('total_donated');

            return view('donaciones.index', compact('donantes', 'recaudacionTotal'));
        }

        // Si es USUARIO NORMAL: Ve la pasarela de pago (lo que ya tenías)
        return view('donaciones.index');
    }

    public function store(Request $request)
    {
        // 1. VALIDACIÓN DEL FORMULARIO
        // Usamos 'bail' para que pare en cuanto detecte el primer error y no siga comprobando.
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:5000',
            'cvc' => 'required|digits:3',

            // Validación Tarjeta (Luhn)
            'card_number' => ['bail', 'required', 'digits:16', function ($attribute, $value, $fail) {
                $sum = 0;
                $flag = 0;
                for ($i = strlen($value) - 1; $i >= 0; $i--) {
                    $digit = (int) $value[$i];
                    $add = $flag++ & 1 ? $digit * 2 : $digit;
                    $sum += $add > 9 ? $add - 9 : $add;
                }
                if ($sum % 10 !== 0) {
                    $fail('El número de tarjeta es incorrecto (Fallo de autenticidad).');
                }
            }],

            // Validación Caducidad
            'expiry' => ['required', function ($attribute, $value, $fail) {
                if (!preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/', $value, $matches)) {
                    return $fail('El formato de fecha debe ser MM/YY (Ej: 12/25).');
                }

                // Creamos la fecha para comparar
                $mes = $matches[1];
                $anio = '20' . $matches[2];
                $fechaTarjeta = Carbon::createFromDate($anio, $mes, 1)->endOfMonth();

                if ($fechaTarjeta->isPast()) {
                    $fail('Tu tarjeta ha caducado. Por favor, utiliza otra tarjeta.');
                }
            }],
        ], [
            // MENSAJES PERSONALIZADOS (Feedback al usuario)
            'amount.min' => 'La donación mínima es de 1€.',
            'amount.max' => 'Por seguridad, el límite máximo es de 5000€.',
            'card_number.digits' => 'El número de tarjeta debe tener exactamente 16 dígitos.',
            'cvc.digits' => 'El CVC son los 3 dígitos de la parte trasera.',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 2. SIMULACIÓN DE PROCESO (Loading...)
        // Esto da sensación de que el sistema está "pensando"
        sleep(1);

        // 3. LÓGICA DE NEGOCIO (El dinero real)
        try {
            // Comprobamos saldo
            if ($user->wallet_balance < $request->amount) {
                // Devolvemos al usuario atrás con un mensaje de error específico
                return back()->with('error', "Saldo insuficiente. Tienes {$user->wallet_balance}€ disponibles y quieres donar {$request->amount}€.");
            }

            // Realizamos la transacción
            $user->wallet_balance -= $request->amount;
            $user->total_donated += $request->amount;
            $user->save();

            // Éxito
            return redirect()->route('donar.index')
                ->with('success', "¡Transacción completada! Has donado {$request->amount}€ correctamente.");

        } catch (\Exception $e) {
            // Si pasa algo raro en la base de datos, no mostramos el error técnico, sino uno amable
            return back()->with('error', 'Hubo un error técnico en la pasarela de pago. Inténtalo de nuevo más tarde.');
        }
    }
}
