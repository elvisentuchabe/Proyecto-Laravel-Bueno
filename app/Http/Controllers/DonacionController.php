<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donacion;

class DonacionController extends Controller
{
    public function index()
    {
        return view('donaciones.index');
    }

    public function procesar(Request $request)
    {
        // 1. Validamos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|numeric|min:1',
            'tarjeta' => 'required|string|min:16',
        ]);

        // 2. Guardamos en la Base de Datos
        // Gracias al modelo, la tarjeta se guardará encriptada automáticamente
        Donacion::create([
            'nombre' => $request->nombre,
            'cantidad' => $request->cantidad,
            'tarjeta' => $request->tarjeta, 
        ]);
        
        // 3. Redirigimos
        return redirect()->route('donaciones.index')
                         ->with('success', '¡Gracias ' . $request->nombre . '! Donación registrada correctamente.');
    }
}