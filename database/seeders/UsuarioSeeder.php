<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Alumno;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // Crear el usuario normal
        $user = User::firstOrCreate(
            ['email' => 'alumno@alumno.com'],
            [
                'name'     => 'Carlos García López',
                'password' => Hash::make('alumno1234'),
                'role'     => 'user',
            ]
        );

        // Vincularlo al primer alumno (Carlos García López)
        $alumno = Alumno::where('dni', '12345678A')->first();

        if ($alumno && !$alumno->user_id) {
            $alumno->update(['user_id' => $user->id]);
        }
    }
}