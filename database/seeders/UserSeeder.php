<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Usuario Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'wallet_balance' => 5000.00,
            'cvc' => '123',
            'total_donated' => 0,
        ]);

        User::create([
            'name' => 'Usuario Normal',
            'email' => 'usuario@test.com',
            'password' => Hash::make('12345678'),
            'role' => 'user',
            'wallet_balance' => 500.00,
            'cvc' => '999',
            'total_donated' => 0,
        ]);
        
        // Usuarios aleatorios
        User::factory(5)->create(); 
    }
}