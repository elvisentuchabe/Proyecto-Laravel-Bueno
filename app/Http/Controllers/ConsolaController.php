<?php

namespace App\Http\Controllers;

use App\Models\Consola;
use Illuminate\Http\Request;

class ConsolaController extends Controller
{
    // --- MÉTODOS DE LECTURA (Para todos los usuarios logueados) ---

    public function index()
    {
        // Ordenamos por año para que tenga sentido histórico
        $consolas = Consola::orderBy('anio_publicacion', 'asc')->get();
        return view('consolas.index', compact('consolas'));
    }

    public function show(Consola $consola)
    {
        // Cargamos la consola y sus juegos asociados para optimizar
        // Laravel busca automáticamente por ID gracias al modelo
        $consola->load('juegos');
        return view('consolas.show', compact('consola'));
    }

    // --- MÉTODOS DE ADMINISTRADOR (Solo Admin) ---
    // Estas funciones solo se ejecutarán si pasas el middleware 'admin' en las rutas

    // 1. Mostrar formulario de crear
    public function create()
    {
        return view('consolas.create');
    }

    // 2. Guardar en base de datos
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'fabricante' => 'required|string|max:255',
            'anio_publicacion' => 'required|integer|min:1950|max:'.date('Y'),
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            // Guarda en storage/app/public/logos
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        Consola::create($validated);

        return redirect()->route('consolas.index')
                         ->with('success', '¡Consola añadida al museo!');
    }

    // 3. Mostrar formulario de edición
    public function edit(Consola $consola)
    {
        return view('consolas.edit', compact('consola'));
    }

    // 4. Actualizar en base de datos
    public function update(Request $request, Consola $consola)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'fabricante' => 'required|string|max:255',
            'anio_publicacion' => 'required|integer|min:1950|max:'.date('Y'),
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        $consola->update($validated);

        return redirect()->route('consolas.show', $consola)
                         ->with('success', 'Consola actualizada correctamente.');
    }

    // 5. Eliminar
    public function destroy(Consola $consola)
    {
        // Seguridad: No permitir borrar si tiene juegos
        if($consola->juegos()->count() > 0){
             return back()->with('error', 'No puedes borrar esta consola porque tiene juegos asignados. Borra los juegos primero.');
        }

        $consola->delete();

        return redirect()->route('consolas.index')
                         ->with('success', 'Consola eliminada definitivamente.');
    }
}