<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('juego_user', function (Blueprint $table) {
            $table->id();

            // 1. Relación con Usuarios (tabla 'users')
            // Laravel detecta automáticamente la tabla 'users'
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // 2. Relación con Juegos (tabla 'juegos')
            // Como tu archivo se llama create_juegos_table, forzamos la conexión a 'juegos'
            $table->foreignId('juego_id')->constrained('juegos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('juego_user');
    }
};
