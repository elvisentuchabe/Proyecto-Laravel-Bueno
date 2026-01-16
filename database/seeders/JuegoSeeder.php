<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Juego;
use App\Models\Consola;

class JuegoSeeder extends Seeder
{
    public function run(): void
    {
        $crearJuego = function ($nombreConsola, $titulo, $anio, $imagen, $desc, $licencia_imagen) {
            $consola = Consola::where('nombre', $nombreConsola)->first();
            if ($consola) {
                Juego::create([
                    'titulo' => $titulo,
                    'anio_lanzamiento' => $anio,
                    'imagen' => $imagen,
                    'descripcion' => $desc,
                    'consola_id' => $consola->id,
                    'licencia_imagen' => $licencia_imagen
                ]);
            }
        };

        $crearJuego('Atari 2600', 'Pac-Man', 1982, 'storage/app/public/juegos/atari_pacman.jpg', 'El come-cocos original.', '');
        $crearJuego('Atari 2600', 'Space Invaders', 1980, 'storage/app/public/juegos/atari_space.jpg', 'Defiende la tierra de la invasión alienígena.', '');

        $crearJuego('Commodore 64', 'Maniac Mansion', 1987, 'storage/app/public/juegos/c64_maniac.jpg', 'La aventura gráfica que lo empezó todo.', '');
        $crearJuego('Commodore 64', 'Bubble Bobble', 1987, 'storage/app/public/juegos/c64_bubble.jpg', 'Dragones lanzando burbujas.', '');

        $crearJuego('NES', 'Super Mario Bros 3', 1988, 'storage/app/public/juegos/nes_mario3.jpg', 'Considerado el mejor plataformas de 8 bits.', '');
        $crearJuego('NES', 'The Legend of Zelda', 1986, 'storage/app/public/juegos/nes_zelda.jpg', 'Es peligroso ir solo, toma esto.', '');

        $crearJuego('Master System', 'Alex Kidd in Miracle World', 1986, 'storage/app/public/juegos/ms_alex.jpg', 'Piedra, papel o tijera y hamburguesas.', '');
        $crearJuego('Master System', 'Wonder Boy III', 1989, 'storage/app/public/juegos/ms_wonder.jpg', 'La trampa del dragón.', '');

        $crearJuego('Game Boy', 'Tetris', 1989, 'storage/app/public/juegos/gb_tetris.jpg', 'Desde Rusia con amor. El juego perfecto.', '');
        $crearJuego('Game Boy', 'Pokémon Rojo', 1996, 'storage/app/public/juegos/gb_pokemon.jpg', '¡Hazte con todos!', '');

        $crearJuego('Game Gear', 'Sonic Chaos', 1993, 'storage/app/public/juegos/gg_sonic.jpg', 'Sonic a todo color en tu mano.', '');
        $crearJuego('Game Gear', 'Columns', 1990, 'storage/app/public/juegos/gg_columns.jpg', 'La respuesta de Sega al Tetris.', '');

        $crearJuego('Super Nintendo', 'Chrono Trigger', 1995, 'storage/app/public/juegos/snes_chrono.jpg', 'Viajes en el tiempo y un diseño inolvidable.', '');
        $crearJuego('Super Nintendo', 'Street Fighter II Turbo', 1992, 'storage/app/public/juegos/snes_sf2.jpg', 'El rey de la lucha.', '');

        $crearJuego('Mega Drive', 'Sonic the Hedgehog 2', 1992, 'storage/app/public/juegos/md_sonic2.jpg', 'Más rápido y con Tails.', '');
        $crearJuego('Mega Drive', 'Streets of Rage 2', 1992, 'storage/app/public/juegos/md_sor2.jpg', 'Música techno y peleas callejeras.', '');

        $crearJuego('PlayStation', 'Final Fantasy VII', 1997, 'storage/app/public/juegos/ps1_ff7.jpg', 'La aventura de Cloud y Sephiroth.', '');
        $crearJuego('PlayStation', 'Metal Gear Solid', 1998, 'storage/app/public/juegos/ps1_mgs.jpg', 'Espionaje táctico de nueva generación.', '');

        $crearJuego('Nintendo 64', 'Super Mario 64', 1996, 'storage/app/public/juegos/n64_mario.jpg', 'La revolución del movimiento en 3D.', '');
        $crearJuego('Nintendo 64', 'GoldenEye 007', 1997, 'storage/app/public/juegos/n64_goldeneye.jpg', 'El shooter multijugador definitivo.', '');
    }
}