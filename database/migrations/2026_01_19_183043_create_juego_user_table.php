<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('juego_user', function (Blueprint $table) {
            $table->id();

            // Relación con el Usuario (quien da like)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Relación con el Juego (el juego favorito)
            $table->foreignId('juego_id')->constrained('juegos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('juego_user');
    }
};
