<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            MateriaSeeder::class,
            CursoSeeder::class,
            LibroSeeder::class,
            AlumnoSeeder::class,
            UsuarioSeeder::class,
        ]);
    }
}