<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon; //Para manejar fechas

class DonacionController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        if (Auth::user()->isAdmin()) {
            $donantes = User::where('total_donated', '>', 0)
                            ->orderByDesc('total_donated')
                            ->get();
            
            $totalRecaudado = $donantes->sum('total_donated');

            return view('donaciones.index', compact('donantes', 'totalRecaudado'));
        }

        return view('donaciones.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:5000',
            'card_name' => 'required|string',
            'cvc' => 'required|digits:3',
            'expiry' => ['required', function ($attribute, $value, $fail) {
                //Validamos formato (MM/YY)
                if (!preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/', $value, $matches)) {
                    return $fail('Formato inválido (Usa MM/YY).');
                }


                $mes = $matches[1];
                $anio = '20' . $matches[2]; // Convertimos '25' en '2025'
                $fechaTarjeta = Carbon::createFromDate($anio, $mes, 1)->endOfMonth();

                if ($fechaTarjeta->isPast()) {
                    $fail('Tu tarjeta ha caducado.');
                }
            }],

            'card_number' => ['required', 'digits:16', function ($attribute, $value, $fail) {
                // Algoritmo Luhn
                $sum = 0;
                $flag = 0;
                for ($i = strlen($value) - 1; $i >= 0; $i--) {
                    $digit = (int) $value[$i];
                    $add = $flag++ & 1 ? $digit * 2 : $digit;
                    $sum += $add > 9 ? $add - 9 : $add;
                }
                if ($sum % 10 !== 0) $fail('Número de tarjeta inválido.');
            }],
        ]);

        sleep(1); 

        // Actualizar dinero donado
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->total_donated += $request->amount;
        $user->save();

        return redirect()->route('donaciones.index')
            ->with('success', "¡Muchas gracias! Has donado {$request->amount}€ correctamente.");
    }
}