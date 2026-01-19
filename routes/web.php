<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConsolaController;
use App\Http\Controllers\VideojuegoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Requiere Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. DASHBOARD
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 2. PERFIL
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ========================================================================
    // 3. ZONA DE ADMINISTRACIÓN (¡¡¡IMPORTANTE: VA PRIMERO!!!)
    // ========================================================================
    // Definimos esto ANTES que las rutas de lectura para que "create" no se confunda con un ID.
    
    Route::middleware(['admin'])->group(function () {
        
        // CONSOLAS (Admin)
        Route::get('/consolas/create', [ConsolaController::class, 'create'])->name('consolas.create');
        Route::post('/consolas', [ConsolaController::class, 'store'])->name('consolas.store');
        Route::get('/consolas/{consola}/edit', [ConsolaController::class, 'edit'])->name('consolas.edit');
        Route::put('/consolas/{consola}', [ConsolaController::class, 'update'])->name('consolas.update');
        Route::delete('/consolas/{consola}', [ConsolaController::class, 'destroy'])->name('consolas.destroy');

        // VIDEOJUEGOS (Admin)
        // Usamos resource exceptuando index y show (que son públicas abajo)
        Route::resource('videojuegos', VideojuegoController::class)->except(['index', 'show']);
    });

    // ========================================================================
    // 4. ZONA DE LECTURA (Usuarios normales + Admin)
    // ========================================================================
    
    // CONSOLAS (Lectura)
    Route::get('/consolas', [ConsolaController::class, 'index'])->name('consolas.index');
    Route::get('/consolas/{consola}', [ConsolaController::class, 'show'])->name('consolas.show');
    
    // VIDEOJUEGOS (Lectura)
    Route::get('/videojuegos', [VideojuegoController::class, 'index'])->name('videojuegos.index');
    // Esta ruta es la "peligrosa" (comodín). Al estar AL FINAL, ya no dará problemas.
    Route::get('/videojuegos/{videojuego}', [VideojuegoController::class, 'show'])->name('videojuegos.show');

});

require __DIR__.'/auth.php';