<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    use HasFactory;

    protected $table = 'juegos'; 

    protected $fillable = [
        'titulo', 
        'anio_lanzamiento', 
        'descripcion', 
        'imagen', 
        'consola_id'
    ];

    public function consola() {
        return $this->belongsTo(Consola::class);
    }

    // Relación: Usuarios que han dado like a este juego
    public function fans()
    {
        return $this->belongsToMany(User::class, 'juego_user', 'juego_id', 'user_id');
    }
}