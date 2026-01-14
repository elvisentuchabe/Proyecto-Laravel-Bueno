<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Consola;


class ConsolaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Consola::create([
        'nombre' => 'Super Nintendo',
        'fabricante' => 'Nintendo',
        'anio_publicacion' => 1990,
        'logo' => 'logos/snes.png'
    ]);
}
}
