<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use App\Models\Consola;
use App\Http\Requests\StoreVideojuegoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class VideojuegoController extends Controller
{
    // =========================================================================
    // 1. MÉTODO INDEX (Todos los juegos)
    // =========================================================================
    public function index(Request $request) {
        $query = Juego::with('consola');

        if ($request->filled('search')) {
            $query->where('titulo', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('consola_id')) {
            $query->where('consola_id', $request->consola_id);
        }

        $videojuegos = $query->paginate(10);
        $consolas = Consola::all();

        return view('videojuegos.index', compact('videojuegos', 'consolas'));
    }

    // =========================================================================
    // 2. MÉTODO BÓVEDA (Solo mis favoritos)
    // =========================================================================
    public function boveda(Request $request) {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Consulta sobre la relación 'favoritos' del usuario
        $query = $user->favoritos()->with('consola');

        // Mantenemos filtros por si quieres buscar dentro de tus favoritos
        if ($request->filled('search')) {
            $query->where('titulo', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('consola_id')) {
            // Nota: Al usar relación, a veces hay que especificar tabla
            $query->where('juegos.consola_id', $request->consola_id);
        }

        $videojuegos = $query->paginate(10);
        $consolas = Consola::all();

        // Variable bandera para cambiar el título en la vista
        $esBoveda = true;

        return view('videojuegos.index', compact('videojuegos', 'consolas', 'esBoveda'));
    }

    // =========================================================================
    // 3. MÉTODOS ESTÁNDAR
    // =========================================================================

    public function show(Juego $videojuego){
        return view('videojuegos.show', compact('videojuego'));
    }

    public function create()
    {
        $consolas = Consola::all();
        return view('videojuegos.create', compact('consolas'));
    }

    public function store(StoreVideojuegoRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('juegos', 'public');
            $validated['imagen'] = $path;
        }

        Juego::create($validated);

        return redirect()->route('videojuegos.index')
                         ->with('success', '¡Videojuego añadido correctamente!');
    }

    public function edit(Juego $videojuego)
    {
        $consolas = Consola::all();
        return view('videojuegos.edit', compact('videojuego', 'consolas'));
    }

    public function update(Request $request, Juego $videojuego) {
        $validated = $request->validate([
            'titulo' => 'required|min:3|max:255',
            'anio_lanzamiento' => 'required|integer|min:1950|max:'.date('Y'),
            'descripcion' => 'nullable|string',
            'consola_id' => 'required|exists:consolas,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            if($videojuego->imagen) {
                 Storage::disk('public')->delete($videojuego->imagen);
            }
            $path = $request->file('imagen')->store('juegos', 'public');
            $validated['imagen'] = $path;
        }

        $videojuego->update($validated);

        return redirect()->route('videojuegos.show', $videojuego)
                         ->with('success', 'Juego actualizado correctamente.');
    }

    public function destroy(Juego $videojuego)
    {
        if ($videojuego->imagen) {
            Storage::disk('public')->delete($videojuego->imagen);
        }

        $videojuego->delete();

        return redirect()->route('videojuegos.index')
                         ->with('success', 'Juego eliminado correctamente.');
    }

    public function toggleFavorito($id)
    {
        $juego = Juego::findOrFail($id);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->favoritos()->toggle($juego->id);

        return back();
    }
}
