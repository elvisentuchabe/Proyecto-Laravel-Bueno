<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consola extends Model
{
    protected $fillable = ['nombre', 'fabricante', 'anio_publicacion', 'logo'];
}
