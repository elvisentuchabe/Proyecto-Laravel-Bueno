<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use App\Models\Consola;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class VideojuegoController extends Controller
{
    // =========================================================================
    // 1. MÉTODO INDEX (CON FILTROS)
    // =========================================================================
    public function index(Request $request) {
        // Iniciamos la consulta base cargando la relación con consola
        $query = Juego::with('consola');

        // 1. Filtro por Título (si escribieron algo en el buscador)
        if ($request->filled('search')) {
            $query->where('titulo', 'like', '%' . $request->search . '%');
        }

        // 2. Filtro por Consola (si seleccionaron una del desplegable)
        if ($request->filled('consola_id')) {
            $query->where('consola_id', $request->consola_id);
        }

        // Obtenemos los resultados paginados (10 por página)
        $videojuegos = $query->paginate(10);

        // También necesitamos las consolas para llenar el desplegable del filtro en la vista
        $consolas = Consola::all();

        // Enviamos tanto los juegos como la lista de consolas a la vista
        return view('videojuegos.index', compact('videojuegos', 'consolas'));
    }

    // =========================================================================
    // 2. RESTO DE MÉTODOS CRUD
    // =========================================================================

    public function show(Juego $videojuego){
        return view('videojuegos.show', compact('videojuego'));
    }

    public function create() {
        $consolas = Consola::all();
        return view('videojuegos.create', compact('consolas'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'titulo' => 'required|min:3|max:255',
            'anio_lanzamiento' => 'required|integer|min:1950|max:'.date('Y'),
            'descripcion' => 'nullable|string',
            'consola_id' => 'required|exists:consolas,id',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('juegos', 'public');
        }

        // Parche para evitar el error de BD si no tienes la columna nullable
        $validated['licencia_imagen'] = 'Desconocida';

        Juego::create($validated);

        return redirect()->route('videojuegos.index')->with('success', 'Juego creado.');
    }

    public function edit(Juego $videojuego) {
        $consolas = Consola::all();
        return view('videojuegos.edit', compact('videojuego', 'consolas'));
    }

    public function update(Request $request, Juego $videojuego) {
        $validated = $request->validate([
            'titulo' => 'required|min:3|max:255',
            'anio_lanzamiento' => 'required|integer|min:1950|max:'.date('Y'),
            'descripcion' => 'nullable|string',
            'consola_id' => 'required|exists:consolas,id',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            if($videojuego->imagen) Storage::disk('public')->delete($videojuego->imagen);
            $validated['imagen'] = $request->file('imagen')->store('juegos', 'public');
        }

        $videojuego->update($validated);
        return redirect()->route('videojuegos.show', $videojuego)->with('success', 'Juego actualizado.');
    }

    public function destroy(Juego $videojuego) {
        if ($videojuego->imagen) {
            Storage::disk('public')->delete($videojuego->imagen);
        }
        $videojuego->delete();
        return redirect()->route('videojuegos.index')->with('success', 'Juego eliminado.');
    }

    // =========================================================================
    // 3. SISTEMA DE FAVORITOS (BÓVEDA)
    // =========================================================================

   public function boveda()
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();

        // Ahora el editor ya sabe que $user es TU modelo y quitará el rojo
        $videojuegos = $user->favoritos()->paginate(10);

        return view('videojuegos.boveda', compact('videojuegos'));
    }

   public function toggleFavorito(Juego $videojuego)
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();

        // Ahora el editor sabe que $user tiene el método 'favoritos()'
        $user->favoritos()->toggle($videojuego);

        return back();
    }
}
