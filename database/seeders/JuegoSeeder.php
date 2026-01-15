<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Juego;
use App\Models\Consola;

class JuegoSeeder extends Seeder
{
    public function run(): void {
        $crearJuego = function ($nombreConsola, $titulo, $anio, $imagen, $desc) {
            $consola = Consola::where('nombre', $nombreConsola)->first();
            if ($consola) {
                jUEGO::create([
                    'titulo' => $titulo,
                    'anio_lanzamiento' => $anio,
                    'imagen' => $imagen,
                    'descripcion' => $desc,
                    'consola_id' => $consola->id
                ]);
            }
        };

        $crearJuego('NES', 'Super Mario Bros', 1985, 'juegos/nes_mario.jpg', 'El juego que salvó la industria.');
        $crearJuego('NES', 'The Legend of Zelda', 1986, 'juegos/nes_zelda.jpg', 'El inicio de una leyenda épica.');

        $crearJuego('Super Nintendo', 'Super Mario World', 1990, 'juegos/snes_mario.jpg', 'Mario con capa y Yoshi.');
        $crearJuego('Super Nintendo', 'Donkey Kong Country', 1994, 'juegos/snes_dk.jpg', 'Gráficos renderizados revolucionarios.');

        $crearJuego('Nintendo 64', 'Super Mario 64', 1996, 'juegos/n64_mario.jpg', 'El paso al 3D definitivo.');
        $crearJuego('Nintendo 64', 'The Legend of Zelda: Ocarina of Time', 1998, 'juegos/n64_zelda.jpg', 'Considerado el mejor juego de la historia.');

        $crearJuego('GameCube', 'Super Smash Bros Melee', 2001, 'juegos/gc_smash.jpg', 'El juego de lucha competitivo por excelencia.');
        $crearJuego('GameCube', 'Metroid Prime', 2002, 'juegos/gc_metroid.jpg', 'Samus Aran en primera persona.');

        $crearJuego('Master System', 'Alex Kidd in Miracle World', 1986, 'juegos/ms_alex.jpg', 'Piedra, papel o tijera.');
        $crearJuego('Master System', 'Sonic the Hedgehog', 1991, 'juegos/ms_sonic.jpg', 'La versión de 8 bits del clásico.');

        $crearJuego('Mega Drive', 'Sonic the Hedgehog 2', 1992, 'juegos/md_sonic2.jpg', 'Introducción de Tails y el Spin Dash.');
        $crearJuego('Mega Drive', 'Streets of Rage 2', 1992, 'juegos/md_streets.jpg', 'El mejor beat em up de la generación.');

        $crearJuego('Dreamcast', 'Sonic Adventure', 1998, 'juegos/dc_sonic.jpg', 'Sonic a la velocidad del sonido en 3D.');
        $crearJuego('Dreamcast', 'Shenmue', 1999, 'juegos/dc_shenmue.jpg', 'Una historia de venganza y mundo abierto.');

        $crearJuego('PlayStation', 'Crash Bandicoot', 1996, 'juegos/ps1_crash.jpg', 'La mascota no oficial de Sony.');
        $crearJuego('PlayStation', 'Metal Gear Solid', 1998, 'juegos/ps1_mgs.jpg', 'Espionaje táctico de Hideo Kojima.');

        $crearJuego('PlayStation 2', 'Grand Theft Auto: San Andreas', 2004, 'juegos/ps2_gta.jpg', 'Ah shit, here we go again.');
        $crearJuego('PlayStation 2', 'God of War II', 2007, 'juegos/ps2_gow.jpg', 'Kratos desafiando al Olimpo.');

        $crearJuego('Xbox', 'Halo: Combat Evolved', 2001, 'juegos/xbox_halo.jpg', 'El shooter que definió las consolas.');
        $crearJuego('Xbox', 'Fable', 2004, 'juegos/xbox_fable.jpg', 'Por cada elección, una consecuencia.');
    }
}