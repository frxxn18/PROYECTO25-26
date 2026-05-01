<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Libro;

class LibroSeeder extends Seeder
{
    public function run(): void
    {
        $libros = [
            ['titulo' => 'Matemáticas 1º ESO',         'autor' => 'Anaya',     'isbn' => '978-8469816001', 'stock' => 5],
            ['titulo' => 'Lengua Castellana 3º ESO',   'autor' => 'Santillana','isbn' => '978-8468013001', 'stock' => 4],
            ['titulo' => 'Historia del Mundo',         'autor' => 'SM',        'isbn' => '978-8467592001', 'stock' => 3],
            ['titulo' => 'Física y Química 4º ESO',    'autor' => 'Oxford',    'isbn' => '978-8467394001', 'stock' => 6],
            ['titulo' => 'Inglés Intermediate B1',     'autor' => 'Burlington','isbn' => '978-9963489001', 'stock' => 4],
            ['titulo' => 'Biología 2º Bachiller',      'autor' => 'Anaya',     'isbn' => '978-8469852001', 'stock' => 3],
            ['titulo' => 'Filosofía 1º Bachiller',     'autor' => 'Edebé',     'isbn' => '978-8468332001', 'stock' => 2],
            ['titulo' => 'Programación en Python',     'autor' => 'Ra-Ma',     'isbn' => '978-8499647001', 'stock' => 5],
        ];

        foreach ($libros as $libro) {
            Libro::create($libro);
        }
    }
}