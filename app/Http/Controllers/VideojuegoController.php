<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use App\Models\Consola;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideojuegoController extends Controller
{

    public function index() {
        // CAMBIO CLAVE: Usamos 'paginate(10)' en vez de 'get()'
        // Esto prepara los datos para que funcionen los botones de "Siguiente página"
        $videojuegos = Juego::with('consola')->paginate(10);

        return view('videojuegos.index', compact('videojuegos'));
    }

    // Muestra la ficha detallada de un juego
    public function show(Juego $videojuego){
        // El nombre de la variable ($videojuego) DEBE coincidir con el compact('videojuego')
        return view('videojuegos.show', compact('videojuego'));
    }

    public function create()
    {
        // Necesitamos las consolas para el desplegable (Select)
        $consolas = Consola::all();
        return view('videojuegos.create', compact('consolas'));
    }

    public function store(Request $request)
    {
        // 1. VALIDACIÓN ESTRICTA (RA6 - Seguridad)
        $validated = $request->validate([
            'titulo' => 'required|min:3|max:255',
            'anio_lanzamiento' => 'required|integer|min:1950|max:'.(date('Y')),
            'descripcion' => 'nullable|string',
            'consola_id' => 'required|exists:consolas,id', // Evita hackeos de IDs falsos
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Solo imágenes, max 2MB
        ]);

        // 2. MANEJO DE IMAGEN (RA5)
        if ($request->hasFile('imagen')) {
            // Guarda en storage/app/public/juegos
            $path = $request->file('imagen')->store('juegos', 'public');
            $validated['imagen'] = $path;
        }

        // 3. GUARDAR EN BD
        Juego::create($validated);

        // 4. FEEDBACK (Mensaje flash)
        return redirect()->route('consolas.show', $request->consola_id)
                         ->with('success', '¡Videojuego añadido correctamente a la colección!');
    }
    // --- MÉTODOS DE EDICIÓN ---

    public function edit(Juego $videojuego)
    {
        // 1. Necesitamos las consolas para el desplegable
        $consolas = \App\Models\Consola::all();

        // 2. Retornamos la vista de edición pasando el juego y las consolas
        return view('videojuegos.edit', compact('videojuego', 'consolas'));
    }

    public function update(Request $request, Juego $videojuego) {
        // 1. Validar datos (igual que en store, pero la imagen es opcional)
        $validated = $request->validate([
            'titulo' => 'required|min:3|max:255',
            'anio_lanzamiento' => 'required|integer|min:1950|max:'.date('Y'),
            'descripcion' => 'nullable|string',
            'consola_id' => 'required|exists:consolas,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Gestión de imagen (Solo si se sube una nueva)
        if ($request->hasFile('imagen')) {
            // (Opcional) Aquí podrías borrar la imagen antigua del storage si quisieras limpiar

            // Subir la nueva
            $path = $request->file('imagen')->store('juegos', 'public');
            $validated['imagen'] = $path;
        }

        // 3. Actualizar en BD
        $videojuego->update($validated);

        // 4. Redirigir
        return redirect()->route('videojuegos.show', $videojuego)
                         ->with('success', 'Juego actualizado correctamente.');
    }

    public function destroy(Juego $videojuego)
    {
        // 1. Si el juego tiene imagen, la borramos del disco duro para no dejar basura
        if ($videojuego->imagen) {
            Storage::disk('public')->delete($videojuego->imagen);
        }

        // 2. Borramos el registro de la base de datos
        $videojuego->delete();

        // 3. Redirigimos a la lista
        return redirect()->route('videojuegos.index')
                         ->with('success', 'Juego eliminado correctamente.');
    }
}
