<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class DonacionController extends Controller
{
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $donantes = User::where('total_donated', '>', 0)
                            ->orderByDesc('total_donated')
                            ->get();
            
            $totalRecaudado = $donantes->sum('total_donated');

            return view('donaciones.index', compact('donantes', 'totalRecaudado'));
        }

        return view('donaciones.index');
    }

    public function store(Request $request) {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:5000',
            'card_name' => 'required|string',
            'cvc' => 'required|digits:3',
            'card_number' => 'required|digits:16',
            'expiry' => ['required', 'regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/'], // Formato MM/YY
        ]);

        $partes = explode('/', $request->expiry); 
        $mes = $partes[0];
        $anio = '20' . $partes[1]; //

        // Creamos la fecha usando Carbon
        $fechaCaducidad = \Carbon\Carbon::create($anio, $mes, 1)->endOfMonth();

        if ($fechaCaducidad->isPast()) {
            return back()->withErrors(['expiry' => 'Tu tarjeta ha caducado.']);
        }

        //Algoritmo de Luhn
        $numero = $request->card_number;
        $suma = 0;
        $esPar = false;

        for ($i = strlen($numero) - 1; $i >= 0; $i--) {
            $digito = intval($numero[$i]);

            if ($esPar) {
                $digito *= 2;
                if ($digito > 9) {
                    $digito -= 9;
                }
            }

            $suma += $digito;
            $esPar = !$esPar;
        }

        if ($suma % 10 !== 0) {
            return back()->withErrors(['card_number' => 'Número de tarjeta inválido.']);
        }

        sleep(1);
        
        $user = Auth::user();
        $user->total_donated += $request->amount;
        $user->save();

        return redirect()->route('donaciones.index')
            ->with('success', "¡Muchas gracias! Has donado {$request->amount}€ correctamente.");
    }
}