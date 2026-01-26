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
        'total_donated', // Solo guardamos el histórico de donaciones
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
            'total_donated' => 'decimal:2',
        ];
    }

    // --- Funciones Auxiliares ---

    public function isAdmin() {
        return $this->role === 'admin';
    }

    public function favoritos() {
        return $this->belongsToMany(Juego::class, 'juego_user', 'user_id', 'juego_id')->withTimestamps();
    }
}