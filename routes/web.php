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

// La página de bienvenida es lo único que ve todo el mundo
Route::get('/', function () {
    return view('welcome');
})->name('welcome');


/*
|--------------------------------------------------------------------------
| ZONA PROTEGIDA (TU TRABAJO DE SEGURIDAD - RA6)
|--------------------------------------------------------------------------
*/

// Este grupo asegura que NADIE entre a las consolas o juegos sin login
Route::middleware(['auth'])->group(function () {

    // 1. Dashboard con doble protección (auth + correo verificado)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    // 2. Gestión de Perfil (Tus rutas originales)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 3. TRABAJO DE AITOR: Consolas (Listado y Detalle)
    Route::get('/consolas', [ConsolaController::class, 'index'])->name('consolas.index');
    Route::get('/consolas/{consola}', [ConsolaController::class, 'show'])->name('consolas.show');

    // 4. TRABAJO DE VICENTE: Gestión completa de Videojuegos
    Route::resource('videojuegos', VideojuegoController::class);

});

/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACIÓN (BREEZE)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
