<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'wallet_balance', // <--- NUEVO
    'total_donated',// <--- NUEVO
    'cvc',  // <--- NUEVO
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    /**
     * Relación muchos a muchos con el modelo Juego.
     * Se especifica 'juego_user' porque es el nombre exacto de la tabla pivote que creamos.
     */
    public function favoritos()
    {
        return $this->belongsToMany(Juego::class, 'juego_user');
    }

    /*
    |--------------------------------------------------------------------------
    | Funciones Auxiliares
    |--------------------------------------------------------------------------
    */

    public function isAdmin() {
        return $this->role === 'admin';
    }

    // Relación Muchos a Muchos (Favoritos)
    public function favoritos() {
        return $this->belongsToMany(Juego::class, 'juego_user');
    }
}
