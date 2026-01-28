<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear el USUARIO ADMINISTRADOR
        User::create([
            'name' => 'Usuario Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'total_donated' => 0.00,
        ]);

        // 2. Crear un USUARIO NORMAL
        User::create([
            'name' => 'Usuario Normal',
            'email' => 'usuario@test.com',
            'password' => Hash::make('12345678'),
            'role' => 'user',
            'total_donated' => 0,
        ]);
        
        // Usuarios aleatorios
        User::factory(5)->create(); 
    }
}