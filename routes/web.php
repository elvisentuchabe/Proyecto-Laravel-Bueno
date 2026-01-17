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

// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| ZONA PROTEGIDA (Requiere Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // 1. Dashboard (Verificado)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    // 2. Gestión de Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 3. TRABAJO DE AITOR: Consolas
    // He unificado todo aquí para seguridad. Asegúrate de que ConsolaController tenga el método 'index'.
    // 3. TRABAJO DE AITOR: Consolas (Listado, Detalle y Borrado)
    Route::get('/consolas', [ConsolaController::class, 'index'])->name('consolas.index');
    Route::get('/consolas/{consola}', [ConsolaController::class, 'show'])->name('consolas.show');
    Route::delete('/consolas/{consola}', [ConsolaController::class, 'destroy'])->name('consolas.destroy');

    // 4. TRABAJO DE VICENTE: Videojuegos
    // 'resource' crea AUTOMÁTICAMENTE: index, create, store, show, edit, update, destroy
    // No necesitas definir rutas sueltas para esto.
    Route::resource('videojuegos', VideojuegoController::class);

});

/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';