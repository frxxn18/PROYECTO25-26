<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumno;

class AlumnoSeeder extends Seeder
{
    public function run(): void
    {
        $alumnos = [
            ['nombre' => 'Carlos',   'apellidos' => 'García López',      'dni' => '12345678A', 'curso_id' => 1],
            ['nombre' => 'María',    'apellidos' => 'Martínez Sánchez',  'dni' => '23456789B', 'curso_id' => 1],
            ['nombre' => 'Pedro',    'apellidos' => 'Fernández Ruiz',    'dni' => '34567890C', 'curso_id' => 2],
            ['nombre' => 'Laura',    'apellidos' => 'González Torres',   'dni' => '45678901D', 'curso_id' => 3],
            ['nombre' => 'Javier',   'apellidos' => 'Rodríguez Díaz',    'dni' => '56789012E', 'curso_id' => 4],
            ['nombre' => 'Ana',      'apellidos' => 'López Moreno',      'dni' => '67890123F', 'curso_id' => 5],
            ['nombre' => 'Miguel',   'apellidos' => 'Sánchez Jiménez',   'dni' => '78901234G', 'curso_id' => 6],
            ['nombre' => 'Lucía',    'apellidos' => 'Pérez Romero',      'dni' => '89012345H', 'curso_id' => 7],
            ['nombre' => 'Sergio',   'apellidos' => 'Díaz Navarro',      'dni' => '90123456I', 'curso_id' => 8],
            ['nombre' => 'Elena',    'apellidos' => 'Ruiz Castillo',     'dni' => '01234567J', 'curso_id' => 8],
        ];

        foreach ($alumnos as $alumno) {
            Alumno::create($alumno);
        }
    }
}