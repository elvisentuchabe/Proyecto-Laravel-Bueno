<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Consola;

class ConsolaSeeder extends Seeder
{
    public function run(): void
    {
        $consolas = [
            ['nombre' => 'Atari 2600', 'fabricante' => 'Atari', 'anio_publicacion' => 1977, 'logo' => 'logos/atari2600.png'],
            ['nombre' => 'Commodore 64', 'fabricante' => 'Commodore', 'anio_publicacion' => 1982, 'logo' => 'logos/c64.png'],
            
            ['nombre' => 'NES', 'fabricante' => 'Nintendo', 'anio_publicacion' => 1983, 'logo' => 'logos/nes.png'],
            ['nombre' => 'Master System', 'fabricante' => 'SEGA', 'anio_publicacion' => 1985, 'logo' => 'logos/mastersystem.png'],
            
            ['nombre' => 'Game Boy', 'fabricante' => 'Nintendo', 'anio_publicacion' => 1989, 'logo' => 'logos/gameboy.png'],
            ['nombre' => 'Game Gear', 'fabricante' => 'SEGA', 'anio_publicacion' => 1990, 'logo' => 'logos/gamegear.png'],

            ['nombre' => 'Super Nintendo', 'fabricante' => 'Nintendo', 'anio_publicacion' => 1990, 'logo' => 'logos/snes.png'],
            ['nombre' => 'Mega Drive', 'fabricante' => 'SEGA', 'anio_publicacion' => 1988, 'logo' => 'logos/megadrive.png'],

            ['nombre' => 'PlayStation', 'fabricante' => 'Sony', 'anio_publicacion' => 1994, 'logo' => 'logos/ps1.png'],
            ['nombre' => 'Nintendo 64', 'fabricante' => 'Nintendo', 'anio_publicacion' => 1996, 'logo' => 'logos/n64.png'],
        ];

        foreach ($consolas as $c) {
            Consola::create($c);
        }
    }
}