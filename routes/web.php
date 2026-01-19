<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConsolaController;
use App\Http\Controllers\VideojuegoController;
use Illuminate\Support\Facades\Route;

// --- RUTAS PÚBLICAS ---
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// --- RUTAS PROTEGIDAS (AUTH) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. DASHBOARD & PERFIL
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. ADMINISTRACIÓN (ADMIN)
    // Definimos esto PRIMERO para evitar conflictos de rutas
    Route::middleware(['admin'])->group(function () {
        // Genera: create, store, edit, update, destroy
        Route::resource('consolas', ConsolaController::class)->except(['index', 'show']);
        Route::resource('videojuegos', VideojuegoController::class)->except(['index', 'show']);
    });

    // 3. LECTURA E INTERACCIÓN (Cualquier usuario logueado)

    // --- CONSOLAS ---
    Route::get('/consolas', [ConsolaController::class, 'index'])->name('consolas.index');
    Route::get('/consolas/{consola}', [ConsolaController::class, 'show'])->name('consolas.show');

    // --- VIDEOJUEGOS ---
    Route::get('/videojuegos', [VideojuegoController::class, 'index'])->name('videojuegos.index');

    // Ruta para FAVORITOS (Agregada aquí)
    // Usamos {videojuego} para que coincida con el modelo automáticamente
    Route::post('/videojuegos/{videojuego}/favorito', [VideojuegoController::class, 'toggleFavorito'])->name('videojuegos.favorito');

    // Ruta de Detalle (Va al final por el comodín)
    Route::get('/videojuegos/{videojuego}', [VideojuegoController::class, 'show'])->name('videojuegos.show');
});

require __DIR__.'/auth.php';
