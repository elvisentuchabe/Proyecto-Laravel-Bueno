<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear el USUARIO ADMINISTRADOR (Tú)
        User::create([
            'name' => 'Usuario Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678'), // Contraseña fácil para pruebas
            'role' => 'admin', // <--- IMPORTANTE: Le damos el poder
        ]);

        // 2. Crear un USUARIO NORMAL (Para probar lo que NO puede hacer)
        User::create([
            'name' => 'Usuario Normal',
            'email' => 'usuario@test.com',
            'password' => Hash::make('12345678'),
            'role' => 'user', // <--- Rol normal
        ]);
        
        User::factory(5)->create(); 
    }
}
