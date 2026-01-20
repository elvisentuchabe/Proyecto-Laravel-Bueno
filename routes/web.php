<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConsolaController;
use App\Http\Controllers\VideojuegoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. PÁGINA DE BIENVENIDA
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| 2. ZONA DE USUARIOS (Requiere estar logueado)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // --- Dashboard y Perfil ---
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Bóveda de Favoritos (Cualquier usuario) ---
    // IMPORTANTE: Estas rutas van ANTES de los recursos o los {id}
    Route::get('/mi-boveda', [VideojuegoController::class, 'boveda'])->name('videojuegos.boveda');
    Route::post('/videojuegos/{videojuego}/favorito', [VideojuegoController::class, 'toggleFavorito'])->name('videojuegos.favorito');

    /*
    |--------------------------------------------------------------------------
    | 3. ZONA DE ADMINISTRACIÓN (Solo Admins) - PRIORIDAD ALTA
    |--------------------------------------------------------------------------
    | Definimos esto PRIMERO para que 'create' no se confunda con un ID.
    */
    Route::middleware(['admin'])->group(function () {
        
        // CONSOLAS (Admin)
        Route::get('/consolas/create', [ConsolaController::class, 'create'])->name('consolas.create');
        Route::post('/consolas', [ConsolaController::class, 'store'])->name('consolas.store');
        Route::get('/consolas/{consola}/edit', [ConsolaController::class, 'edit'])->name('consolas.edit');
        Route::put('/consolas/{consola}', [ConsolaController::class, 'update'])->name('consolas.update');
        Route::delete('/consolas/{consola}', [ConsolaController::class, 'destroy'])->name('consolas.destroy');

        // VIDEOJUEGOS (Admin)
        // Usamos resource exceptuando index y show que son públicos abajo.
        // Al estar aquí arriba, /videojuegos/create funcionará bien.
        Route::resource('videojuegos', VideojuegoController::class)->except(['index', 'show']);
    });

    /*
    |--------------------------------------------------------------------------
    | 4. ZONA DE LECTURA (Todos los usuarios) - PRIORIDAD BAJA
    |--------------------------------------------------------------------------
    | Estas rutas usan {id}, así que deben ir AL FINAL.
    */
    
    // Consolas
    Route::get('/consolas', [ConsolaController::class, 'index'])->name('consolas.index');
    Route::get('/consolas/{consola}', [ConsolaController::class, 'show'])->name('consolas.show');
    
    // Videojuegos
    Route::get('/videojuegos', [VideojuegoController::class, 'index'])->name('videojuegos.index');
    Route::get('/videojuegos/{videojuego}', [VideojuegoController::class, 'show'])->name('videojuegos.show');

});

require __DIR__.'/auth.php';