<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'wallet_balance', // <--- NUEVO
        'total_donated',  // <--- NUEVO
        'cvc',            // <--- NUEVO
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'cvc', // Opcional: Para que nunca salga el CVC si conviertes el usuario a JSON
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            
            // --- ¡ESTO ES LO QUE FALTABA! ---
            'cvc' => 'encrypted',           // Encripta automático al guardar
            'wallet_balance' => 'decimal:2', // Asegura 2 decimales siempre
            'total_donated' => 'decimal:2',  // Asegura 2 decimales siempre
        ];
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
        return $this->belongsToMany(Juego::class, 'juego_user', 'user_id', 'juego_id')->withTimestamps();
    }
}