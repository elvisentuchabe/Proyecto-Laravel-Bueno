<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConsolaController;
use App\Http\Controllers\VideojuegoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Vista 1: Listado de todas las consolas
Route::get('/consolas', [ConsolaController::class, 'index'])->name('consolas.index');

// Vista 2: Juegos de una consola específica
Route::get('/consolas/{consola}', [ConsolaController::class, 'show'])->name('consolas.show');

// CRUD de Videojuegos
Route::resource('videojuegos', VideojuegoController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// --- ZONA PROTEGIDA PARA VIDEOJUEGOS ---
Route::middleware(['auth'])->group(function () {

    // Mañana Aitor pondrá aquí sus rutas, por ejemplo:
    // Route::resource('videojuegos', VideojuegoController::class);

});
