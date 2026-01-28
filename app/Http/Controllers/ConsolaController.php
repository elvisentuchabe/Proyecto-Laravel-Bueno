<?php

namespace App\Http\Controllers;

use App\Models\Consola;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConsolaController extends Controller
{
    public function index() {
        $consolas = Consola::orderBy('anio_publicacion', 'asc')->get();
        return view('consolas.index', compact('consolas'));
    }

    public function show(Consola $consola) {
        $consola->load('juegos');
        return view('consolas.show', compact('consola'));
    }

    public function create() {
        return view('consolas.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'fabricante' => 'required|string|max:255',
            'anio_publicacion' => 'required|integer|min:1950|max:'.date('Y'),
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('consolas', 'public');
        }

        $validated['licencia_logo'] = 'Desconocida';

        Consola::create($validated);
        return redirect()->route('consolas.index')->with('success', 'Consola creada.');
    }

    public function edit(Consola $consola) {
        return view('consolas.edit', compact('consola'));
    }

    public function update(Request $request, Consola $consola) {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'fabricante' => 'required|string|max:255',
            'anio_publicacion' => 'required|integer|min:1950|max:'.date('Y'),
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if($consola->logo) Storage::disk('public')->delete($consola->logo);
            $validated['logo'] = $request->file('logo')->store('consolas', 'public');
        }

        $consola->update($validated);
        return redirect()->route('consolas.index')->with('success', 'Consola actualizada.');
    }

    public function destroy(Consola $consola) {
        if($consola->juegos()->count() > 0){
             return back()->with('error', 'No puedes borrar una consola con juegos.');
        }
        if ($consola->logo) {
            Storage::disk('public')->delete($consola->logo);
        }
        $consola->delete();
        return redirect()->route('consolas.index')->with('success', 'Consola eliminada.');
    }
}