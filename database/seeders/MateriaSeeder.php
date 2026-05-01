<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materia;

class MateriaSeeder extends Seeder
{
    public function run(): void
    {
        $materias = [
            'Matemáticas',
            'Lengua Castellana',
            'Historia',
            'Física y Química',
            'Inglés',
            'Biología',
            'Filosofía',
            'Informática',
        ];

        foreach ($materias as $nombre) {
            Materia::create(['nombre' => $nombre]);
        }
    }
}