<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConsolaController;
use App\Http\Controllers\VideojuegoController;
use Illuminate\Support\Facades\Route;

/* RUTAS PÚBLICAS */
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/* RUTAS PROTEGIDAS */
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ZONA ADMIN ---
    Route::middleware(['admin'])->group(function () {
        // Consolas
        Route::get('/consolas/create', [ConsolaController::class, 'create'])->name('consolas.create');
        Route::post('/consolas', [ConsolaController::class, 'store'])->name('consolas.store');
        Route::get('/consolas/{consola}/edit', [ConsolaController::class, 'edit'])->name('consolas.edit');
        Route::put('/consolas/{consola}', [ConsolaController::class, 'update'])->name('consolas.update');
        Route::delete('/consolas/{consola}', [ConsolaController::class, 'destroy'])->name('consolas.destroy');

        // Videojuegos (Gestión)
        Route::resource('videojuegos', VideojuegoController::class)->except(['index', 'show']);
    });

    // --- ZONA LECTURA Y FAVORITOS ---

    // 1. RUTA NUEVA: Mi Bóveda (Favoritos)
    Route::get('/mi-boveda', [VideojuegoController::class, 'boveda'])->name('videojuegos.boveda');

    // 2. Rutas Estándar
    Route::get('/consolas', [ConsolaController::class, 'index'])->name('consolas.index');
    Route::get('/consolas/{consola}', [ConsolaController::class, 'show'])->name('consolas.show');

    Route::get('/videojuegos', [VideojuegoController::class, 'index'])->name('videojuegos.index');
    Route::get('/videojuegos/{videojuego}', [VideojuegoController::class, 'show'])->name('videojuegos.show');

    // 3. Acción de dar Like/Dislike
    Route::post('/videojuegos/{juego}/favorito', [VideojuegoController::class, 'toggleFavorito'])->name('videojuegos.favorito');

});

require __DIR__.'/auth.php';

