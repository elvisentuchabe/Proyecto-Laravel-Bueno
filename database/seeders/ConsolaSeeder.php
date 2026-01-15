<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Consola;

class ConsolaSeeder extends Seeder
{
    public function run(): void
    {
        $consolas = [
            ['nombre' => 'NES', 'fabricante' => 'Nintendo', 'anio_publicacion' => 1983, 'logo' => 'logos/nes.png'],
            ['nombre' => 'Super Nintendo', 'fabricante' => 'Nintendo', 'anio_publicacion' => 1990, 'logo' => 'logos/snes.png'],
            ['nombre' => 'Nintendo 64', 'fabricante' => 'Nintendo', 'anio_publicacion' => 1996, 'logo' => 'logos/n64.png'],
            ['nombre' => 'GameCube', 'fabricante' => 'Nintendo', 'anio_publicacion' => 2001, 'logo' => 'logos/gamecube.png'],
            ['nombre' => 'Master System', 'fabricante' => 'SEGA', 'anio_publicacion' => 1985, 'logo' => 'logos/mastersystem.png'],
            ['nombre' => 'Mega Drive', 'fabricante' => 'SEGA', 'anio_publicacion' => 1988, 'logo' => 'logos/megadrive.png'],
            ['nombre' => 'Dreamcast', 'fabricante' => 'SEGA', 'anio_publicacion' => 1998, 'logo' => 'logos/dreamcast.png'],
            ['nombre' => 'PlayStation', 'fabricante' => 'Sony', 'anio_publicacion' => 1994, 'logo' => 'logos/ps1.png'],
            ['nombre' => 'PlayStation 2', 'fabricante' => 'Sony', 'anio_publicacion' => 2000, 'logo' => 'logos/ps2.png'],
            ['nombre' => 'Xbox', 'fabricante' => 'Microsoft', 'anio_publicacion' => 2001, 'logo' => 'logos/xbox.png'],
        ];

        foreach ($consolas as $c) {
            Consola::create($c);
        }
    }
}