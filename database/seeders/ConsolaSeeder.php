<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Consola;

class ConsolaSeeder extends Seeder
{
    public function run(): void
    {
        $consolas = [
            ['nombre' => 'Atari 2600', 'fabricante' => 'Atari', 'anio_publicacion' => 1977, 'logo' => 'consolas/atari2600.png', 'licencia_logo' => 'By <a href="//commons.wikimedia.org/wiki/User:Evan-Amos" title="User:Evan-Amos">Evan-Amos</a> - <span class="int-own-work" lang="en">Own work</span>, Public Domain, <a href="https://commons.wikimedia.org/w/index.php?curid=18549124">Link</a>'],
            ['nombre' => 'Commodore 64', 'fabricante' => 'Commodore', 'anio_publicacion' => 1982, 'logo' => 'consolas/c64.png', 'licencia_logo' => 'By <a href="//commons.wikimedia.org/wiki/User:Evan-Amos" title="User:Evan-Amos">Evan-Amos</a> - <span class="int-own-work" lang="en">Own work</span>, <a href="https://creativecommons.org/licenses/by-sa/3.0" title="Creative Commons Attribution-Share Alike 3.0">CC BY-SA 3.0</a>, <a href="https://commons.wikimedia.org/w/index.php?curid=18290751">Link</a>'],
            
            ['nombre' => 'NES', 'fabricante' => 'Nintendo', 'anio_publicacion' => 1983, 'logo' => 'consolas/nes.png', 'licencia_logo' => 'By <a href="//commons.wikimedia.org/wiki/User:Evan-Amos" title="User:Evan-Amos">Evan-Amos</a> - <span class="int-own-work" lang="en">Own work</span>, Public Domain, <a href="https://commons.wikimedia.org/w/index.php?curid=11408666">Link</a>'],
            ['nombre' => 'Master System', 'fabricante' => 'SEGA', 'anio_publicacion' => 1985, 'logo' => 'consolas/mastersystem.png', 'licencia_logo' => 'By <a href="//commons.wikimedia.org/wiki/User:Evan-Amos" title="User:Evan-Amos">Evan-Amos</a> - <span class="int-own-work" lang="en">Own work</span>, Public Domain, <a href="https://commons.wikimedia.org/w/index.php?curid=14249084">Link</a>'],
            
            ['nombre' => 'Game Boy', 'fabricante' => 'Nintendo', 'anio_publicacion' => 1989, 'logo' => 'consolas/gameboy.png', 'licencia_logo' => 'By <a href="//commons.wikimedia.org/wiki/User:Evan-Amos" title="User:Evan-Amos">Evan-Amos</a> - <span class="int-own-work" lang="en">Own work</span>, Public Domain, <a href="https://commons.wikimedia.org/w/index.php?curid=36853230">Link</a>'],
            ['nombre' => 'Game Gear', 'fabricante' => 'SEGA', 'anio_publicacion' => 1990, 'logo' => 'consolas/gamegear.png', 'licencia_logo' => 'By <a href="//commons.wikimedia.org/wiki/User:Evan-Amos" title="User:Evan-Amos">Evan-Amos</a> - <span class="int-own-work" lang="en">Own work</span>, Public Domain, <a href="https://commons.wikimedia.org/w/index.php?curid=12172585">Link</a>'],

            ['nombre' => 'Super Nintendo', 'fabricante' => 'Nintendo', 'anio_publicacion' => 1990, 'logo' => 'consolas/snes.png', 'licencia_logo' => 'By <a href="//commons.wikimedia.org/wiki/User:Evan-Amos" class="mw-userlink" title="User:Evan-Amos">Evan-Amos</a> - <span class="int-own-work" lang="en">Own work</span>, Public Domain, <a href="https://commons.wikimedia.org/w/index.php?curid=17748368">Link</a>'],
            ['nombre' => 'Mega Drive', 'fabricante' => 'SEGA', 'anio_publicacion' => 1988, 'logo' => 'consolas/megadrive.png', 'licencia_logo' => 'By <a href="//commons.wikimedia.org/wiki/User:Evan-Amos" title="User:Evan-Amos">Evan-Amos</a> - <span class="int-own-work" lang="en">Own work</span>, Public Domain, <a href="https://commons.wikimedia.org/w/index.php?curid=50627512">Link</a>'],

            ['nombre' => 'PlayStation', 'fabricante' => 'Sony', 'anio_publicacion' => 1994, 'logo' => 'consolas/ps1.png', 'licencia_logo' => '<a href="http://creativecommons.org/licenses/by-sa/3.0/" title="Creative Commons Attribution-Share Alike 3.0">CC BY-SA 3.0</a>, <a href="https://commons.wikimedia.org/w/index.php?curid=101987862">Link</a>'],
            ['nombre' => 'Nintendo 64', 'fabricante' => 'Nintendo', 'anio_publicacion' => 1996, 'logo' => 'consolas/n64.png', 'licencia_logo' => 'By Larry D. Moore, <a href="https://creativecommons.org/licenses/by/4.0" title="Creative Commons Attribution 4.0">CC BY 4.0</a>, <a href="https://commons.wikimedia.org/w/index.php?curid=784356">Link</a>'],
        ];

        foreach ($consolas as $c) {
            Consola::create($c);
        }
    }
}