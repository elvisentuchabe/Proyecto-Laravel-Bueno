<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreVideojuegoRequest;
use App\Models\Juego;
use App\Models\Consola;

class VideojuegoController extends Controller
{
    /**
     * Muestra el listado de videojuegos (Paginado y Ordenado)
     */
    public function index() {
        // Usamos 'anio_lanzamiento' para coincidir con la BD de Vicente
        $videojuegos = Juego::orderBy('anio_lanzamiento', 'desc')->paginate(10);

        return view('videojuegos.index', compact('videojuegos'));
    }

    /**
     * Muestra el formulario para crear un nuevo juego
     */
    public function create() {
        $consolas = Consola::all();
        return view('videojuegos.create', compact('consolas'));
    }

    /**
     * Guarda el juego en la base de datos
     */
    public function store(StoreVideojuegoRequest $request) {
        $datos = $request->validated();

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('public');
            $datos['imagen'] = $rutaImagen;
        }

        Juego::create($datos);

        return redirect()->route('videojuegos.index')->with('success', 'Videojuego creado correctamente');
    }

    /**
     * Elimina el juego de la base de datos
     */
    public function destroy(Juego $videojuego) {
        $videojuego->delete();

        return redirect()->route('videojuegos.index')->with('success', 'Videojuego eliminado correctamente');
    }

    /**
     * Muestra el formulario de edición con los datos del juego
     * ESTA ES LA FUNCIÓN QUE TE DABA ERROR
     */
    public function edit(Juego $videojuego) {
        $consolas = Consola::all();

        // OJO: Asegúrate de que la carpeta de la vista sea 'videojuegos' (plural)
        return view('videojuegos.edit', compact('videojuego', 'consolas'));
    }

    /**
     * Actualiza el juego en la base de datos
     */
    public function update(Request $request, Juego $videojuego) {
        // Validación manual para el update (simplificada)
        $datos = $request->validate([
            'titulo' => 'required|string|max:255',
            // Recordamos usar 'anio_lanzamiento'
            'anio_lanzamiento' => 'required|integer|min:1950|max:'.date('Y'),
            'descripcion' => 'nullable|string',
            'consola_id' => 'required|exists:consolas,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('public');
            $datos['imagen'] = $rutaImagen;
        } else {
            // Si no hay imagen nueva, quitamos la clave para no machacar la vieja
            unset($datos['imagen']);
        }

        $videojuego->update($datos);

        return redirect()->route('videojuegos.index')->with('success', 'Videojuego actualizado correctamente');
    }
}