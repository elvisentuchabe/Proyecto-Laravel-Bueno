<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use App\Models\Consola;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class VideojuegoController extends Controller
{
    public function index() {
        $videojuegos = Juego::with('consola')->paginate(10); 
        return view('videojuegos.index', compact('videojuegos'));
    }

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
    // --- SISTEMA DE FAVORITOS (BÓVEDA) ---

    // 1. Mostrar la Bóveda (solo los juegos que le gustan al usuario)
    public function boveda()
    {
        // Obtenemos los juegos favoritos del usuario conectado
        $videojuegos = \Illuminate\Support\Facades\Auth::user()->favoritos()->paginate(10);
        
        return view('videojuegos.boveda', compact('videojuegos'));
    }

    // 2. Acción de Dar/Quitar Like (Toggle)
    public function toggleFavorito(Juego $videojuego)
    {
        // El método 'toggle' detecta automáticamente:
        // - Si ya es favorito -> Lo quita
        // - Si no es favorito -> Lo añade
        \Illuminate\Support\Facades\Auth::user()->favoritos()->toggle($videojuego);

        // 'back()' nos devuelve a la página donde estábamos (index o bóveda)
        return back(); 
    }
}