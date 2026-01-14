<?php

namespace App\Http\Controllers;

use App\Models\Consola;
use Illuminate\Http\Request;

class ConsolaController extends Controller
{
    //Muestra el listado de todas las consolas
    public function index()
    {
        $consolas = Consola::all();

        return view('consolas.index', compact('consolas'));
    }

    //Muestra los juegos de una consola específica
    public function show($id)
    {
        $consola = Consola::with('videojuegos')->findOrFail($id);

        return view('consolas.show', compact('consola'));
    }
}
