<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consola;

class ConsolaController extends Controller
{
    //Muestra el listado de todas las consolas
    public function index() {
        $consolas = Consola::all();

        return view('consolas.index', compact('consolas'));
    }

    //Muestra los juegos de una consola específica
    public function show($id) {
        $consola = Consola::with('videojuegos')->findOrFail($id);

        return view('consolas.show', compact('consola'));
    }

    public function destroy(Consola $consola) {
        $consola->delete();

        return redirect()->route('consolas.index')->with('success', 'Consola y sus juegos eliminados correctamente');
    }
}
