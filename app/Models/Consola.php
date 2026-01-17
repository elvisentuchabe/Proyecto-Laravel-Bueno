<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consola extends Model
{
    use HasFactory;

    // Forzamos a que use la tabla 'consolas' para evitar errores
    protected $table = 'consolas'; 

    protected $fillable = [
        'nombre', 
        'fabricante', 
        'anio_publicacion', 
        'logo',
        'licencia_logo'
    ];

    public function videojuegos() {
        return $this->hasMany(Juego::class);
    }
}