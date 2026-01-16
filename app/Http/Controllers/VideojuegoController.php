<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreVideojuegoRequest;
use App\Models\Juego;
use App\Models\Consola;

class VideojuegoController extends Controller
{

    // Muestra el listado de videojuegos (Paginado y Ordenado)
    public function index() {
        $videojuegos = Juego::orderBy('anio', 'desc')->paginate(10);

        return view('videojuegos.index', compact('videojuegos'));
    }

    //Muestra el formulario para crear un nuevo juego
    public function create() {
        $consolas = Consola::all();
        return view('videojuegos.create', compact('consolas'));
    }

    //Guarda el juego en la base de datos
    public function store(StoreVideojuegoRequest $request) {
        $datos = $request->validated();

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('public');
            
            $datos['imagen'] = $rutaImagen;
        }

        //Crear el juego en la BD (Eloquent)
        Juego::create($datos);

        //Redirección con Mensaje Flash
        return redirect()->route('videojuegos.index')->with('success', 'Videojuego creado correctamente');
    }

    //Elimina el juego de la base de datos
    public function destroy (Juego $videojuego) {
        $videojuego->delete();

        return redirect()->route('videojuegos.index')->with('success', 'Videojuego eliminado correctamente');
    }

    //Muestra el formulario de edición con los datos del juego
    public function edit(Juego $videojuego) {
        $consolas = Consola::all();

        return view('videojuegos.edit', compact('videojuego', 'consolas'));
    }

    //Actualiza el juego en la base de datos
    public function update(Request $request, Juego $videojuego) {
        $datos = $request->validate([
            'titulo' => 'required|string|max:255',
            'anio' => 'required|integer|min:1950|max:'.date('Y'),
            'descripcion' => 'nullable|string',
            'consola_id' => 'required|exists:consolas,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // En update es nullable (opcional cambiarla)
        ]);

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('public');
            $datos['imagen'] = $rutaImagen;
        } else {
            unset($datos['imagen']);
        }

        $videojuego->update($datos);

        return redirect()->route('videojuegos.index')->with('success', 'Videojuego actualizado correctamente');
    }
}
