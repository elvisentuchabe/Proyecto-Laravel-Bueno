<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donacion extends Model
{
    protected $table = 'donaciones'; 

    protected $fillable = [
        'nombre',
        'cantidad',
        'tarjeta',
    ];

    protected $casts = [
        'tarjeta' => 'encrypted',
    ];
}