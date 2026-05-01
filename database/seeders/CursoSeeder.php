<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curso;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $cursos = [
            ['nombre' => '1º ESO',        'materia_id' => 1],
            ['nombre' => '2º ESO',        'materia_id' => 1],
            ['nombre' => '3º ESO',        'materia_id' => 2],
            ['nombre' => '4º ESO',        'materia_id' => 2],
            ['nombre' => '1º Bachiller',  'materia_id' => 3],
            ['nombre' => '2º Bachiller',  'materia_id' => 3],
            ['nombre' => 'CFGM DAM',      'materia_id' => 8],
            ['nombre' => 'CFGS DAW',      'materia_id' => 8],
        ];

        foreach ($cursos as $curso) {
            Curso::create($curso);
        }
    }
}