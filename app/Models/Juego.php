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
}