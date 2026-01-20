<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConsolaController;
use App\Http\Controllers\VideojuegoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (No hace falta login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| RUTAS DE USUARIOS (Cualquiera que esté logueado)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. DASHBOARD Y PERFIL
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. FAVORITOS / BÓVEDA (¡¡AQUÍ!! Fuera del admin, accesible para todos)
    Route::get('/mi-boveda', [VideojuegoController::class, 'boveda'])->name('videojuegos.boveda');
    Route::post('/videojuegos/{videojuego}/favorito', [VideojuegoController::class, 'toggleFavorito'])->name('videojuegos.favorito');

    // 3. LECTURA (Ver listas y detalles)
    Route::get('/consolas', [ConsolaController::class, 'index'])->name('consolas.index');
    Route::get('/consolas/{consola}', [ConsolaController::class, 'show'])->name('consolas.show');
    
    Route::get('/videojuegos', [VideojuegoController::class, 'index'])->name('videojuegos.index');
    Route::get('/videojuegos/{videojuego}', [VideojuegoController::class, 'show'])->name('videojuegos.show');

    /*
    |--------------------------------------------------------------------------
    | ZONA PROHIBIDA: SOLO ADMINISTRADORES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin'])->group(function () {
        
        // Gestión de Consolas (Crear, Editar, Borrar)
        Route::get('/consolas/create', [ConsolaController::class, 'create'])->name('consolas.create');
        Route::post('/consolas', [ConsolaController::class, 'store'])->name('consolas.store');
        Route::get('/consolas/{consola}/edit', [ConsolaController::class, 'edit'])->name('consolas.edit');
        Route::put('/consolas/{consola}', [ConsolaController::class, 'update'])->name('consolas.update');
        Route::delete('/consolas/{consola}', [ConsolaController::class, 'destroy'])->name('consolas.destroy');

        // Gestión de Videojuegos (Todo menos ver)
        Route::resource('videojuegos', VideojuegoController::class)->except(['index', 'show']);
    });

});

require __DIR__.'/auth.php';