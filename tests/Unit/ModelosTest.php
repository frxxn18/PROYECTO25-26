<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Alumno;
use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\Curso;
use App\Models\Materia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class ModelosTest extends TestCase
{
    use RefreshDatabase;

    // =========================================================
    // USER
    // =========================================================

    /** @test */
    public function usuario_admin_devuelve_true_en_isAdmin()
    {
        $user = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@test.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        $this->assertTrue($user->isAdmin());
    }

    /** @test */
    public function usuario_normal_devuelve_false_en_isAdmin()
    {
        $user = User::create([
            'name'     => 'Alumno',
            'email'    => 'alumno@test.com',
            'password' => bcrypt('password'),
            'role'     => 'user',
        ]);

        $this->assertFalse($user->isAdmin());
    }

    /** @test */
    public function user_tiene_relacion_hasOne_con_alumno()
    {
        $user = User::create([
            'name'     => 'Juan García',
            'email'    => 'juan@test.com',
            'password' => bcrypt('password'),
            'role'     => 'user',
        ]);

        $materia = Materia::create(['nombre' => 'Matemáticas']);
        $curso   = Curso::create(['nombre' => '1ºA', 'materia_id' => $materia->id]);

        $alumno = Alumno::create([
            'nombre'    => 'Juan',
            'apellidos' => 'García',
            'dni'       => '12345678A',
            'curso_id'  => $curso->id,
            'user_id'   => $user->id,
        ]);

        $this->assertInstanceOf(Alumno::class, $user->alumno);
        $this->assertEquals($alumno->id, $user->alumno->id);
    }

    // =========================================================
    // ALUMNO
    // =========================================================

    /** @test */
    public function alumno_pertenece_a_curso()
    {
        $materia = Materia::create(['nombre' => 'Lengua']);
        $curso   = Curso::create(['nombre' => '2ºB', 'materia_id' => $materia->id]);

        $alumno = Alumno::create([
            'nombre'    => 'Ana',
            'apellidos' => 'López',
            'curso_id'  => $curso->id,
        ]);

        $this->assertInstanceOf(Curso::class, $alumno->curso);
        $this->assertEquals($curso->id, $alumno->curso->id);
    }

    /** @test */
    public function alumno_puede_tener_prestamos()
    {
        $materia = Materia::create(['nombre' => 'Historia']);
        $curso   = Curso::create(['nombre' => '3ºC', 'materia_id' => $materia->id]);

        $alumno = Alumno::create([
            'nombre'    => 'Pedro',
            'apellidos' => 'Martínez',
            'curso_id'  => $curso->id,
        ]);

        $libro = Libro::create([
            'titulo'     => 'Historia Universal',
            'autor'      => 'Autor Test',
            'isbn'       => '111-2222222-33',
            'stock'      => 3,
            'materia_id' => $materia->id,
        ]);

        Prestamo::create([
            'alumno_id'      => $alumno->id,
            'libro_id'       => $libro->id,
            'fecha_prestamo' => Carbon::today(),
        ]);

        $this->assertCount(1, $alumno->prestamos);
    }

    // =========================================================
    // LIBRO
    // =========================================================

    /** @test */
    public function libro_disponibles_descuenta_prestamos_activos()
    {
        $materia = Materia::create(['nombre' => 'Física']);
        $curso   = Curso::create(['nombre' => '4ºA', 'materia_id' => $materia->id]);

        $libro = Libro::create([
            'titulo'     => 'Física Cuántica',
            'autor'      => 'Autor',
            'isbn'       => '000-1111111-22',
            'stock'      => 5,
            'materia_id' => $materia->id,
        ]);

        $alumno = Alumno::create([
            'nombre'    => 'Luis',
            'apellidos' => 'Fernández',
            'curso_id'  => $curso->id,
        ]);

        // 2 préstamos activos (sin fecha_devolucion)
        Prestamo::create([
            'alumno_id'      => $alumno->id,
            'libro_id'       => $libro->id,
            'fecha_prestamo' => Carbon::today(),
        ]);
        Prestamo::create([
            'alumno_id'      => $alumno->id,
            'libro_id'       => $libro->id,
            'fecha_prestamo' => Carbon::today(),
        ]);

        // 1 préstamo devuelto (no debe contar)
        Prestamo::create([
            'alumno_id'        => $alumno->id,
            'libro_id'         => $libro->id,
            'fecha_prestamo'   => Carbon::yesterday(),
            'fecha_devolucion' => Carbon::today(),
        ]);

        $this->assertEquals(3, $libro->disponibles); // 5 - 2 activos
    }

    /** @test */
    public function libro_disponibles_es_igual_al_stock_sin_prestamos()
    {
        $materia = Materia::create(['nombre' => 'Química']);
        $libro   = Libro::create([
            'titulo'     => 'Química Orgánica',
            'autor'      => 'Autor',
            'isbn'       => '999-8888888-77',
            'stock'      => 4,
            'materia_id' => $materia->id,
        ]);

        $this->assertEquals(4, $libro->disponibles);
    }

    // =========================================================
    // PRESTAMO
    // =========================================================

    /** @test */
    public function prestamo_activo_si_no_tiene_fecha_devolucion()
    {
        $materia = Materia::create(['nombre' => 'Bio']);
        $curso   = Curso::create(['nombre' => '1ºB', 'materia_id' => $materia->id]);

        $alumno = Alumno::create([
            'nombre'    => 'Carlos',
            'apellidos' => 'Ruiz',
            'curso_id'  => $curso->id,
        ]);
        $libro = Libro::create([
            'titulo'     => 'Biología',
            'autor'      => 'Autor',
            'isbn'       => '123-4567890-12',
            'stock'      => 2,
            'materia_id' => $materia->id,
        ]);

        $prestamo = Prestamo::create([
            'alumno_id'      => $alumno->id,
            'libro_id'       => $libro->id,
            'fecha_prestamo' => Carbon::today(),
        ]);

        $this->assertTrue($prestamo->estaActivo());
    }

    /** @test */
    public function prestamo_no_activo_si_tiene_fecha_devolucion()
    {
        $materia = Materia::create(['nombre' => 'Geo']);
        $curso   = Curso::create(['nombre' => '2ºA', 'materia_id' => $materia->id]);

        $alumno = Alumno::create([
            'nombre'    => 'Sara',
            'apellidos' => 'González',
            'curso_id'  => $curso->id,
        ]);
        $libro = Libro::create([
            'titulo'     => 'Geografía',
            'autor'      => 'Autor',
            'isbn'       => '321-9876543-21',
            'stock'      => 2,
            'materia_id' => $materia->id,
        ]);

        $prestamo = Prestamo::create([
            'alumno_id'        => $alumno->id,
            'libro_id'         => $libro->id,
            'fecha_prestamo'   => Carbon::today()->subDays(5),
            'fecha_devolucion' => Carbon::today(),
        ]);

        $this->assertFalse($prestamo->estaActivo());
    }

    /** @test */
    public function prestamo_vencido_si_supera_fecha_devolucion_prevista()
    {
        $materia = Materia::create(['nombre' => 'Arte']);
        $curso   = Curso::create(['nombre' => '3ºA', 'materia_id' => $materia->id]);

        $alumno = Alumno::create([
            'nombre'    => 'María',
            'apellidos' => 'Sánchez',
            'curso_id'  => $curso->id,
        ]);
        $libro = Libro::create([
            'titulo'     => 'Arte Moderno',
            'autor'      => 'Autor',
            'isbn'       => '456-7891234-56',
            'stock'      => 1,
            'materia_id' => $materia->id,
        ]);

        $prestamo = Prestamo::create([
            'alumno_id'                  => $alumno->id,
            'libro_id'                   => $libro->id,
            'fecha_prestamo'             => Carbon::today()->subDays(30),
            'fecha_devolucion_prevista'  => Carbon::today()->subDays(10),
        ]);

        $this->assertTrue($prestamo->estaVencido());
    }

    /** @test */
    public function prestamo_no_vencido_si_devolucion_prevista_en_el_futuro()
    {
        $materia = Materia::create(['nombre' => 'Música']);
        $curso   = Curso::create(['nombre' => '1ºC', 'materia_id' => $materia->id]);

        $alumno = Alumno::create([
            'nombre'    => 'Tomás',
            'apellidos' => 'Díaz',
            'curso_id'  => $curso->id,
        ]);
        $libro = Libro::create([
            'titulo'     => 'Teoría Musical',
            'autor'      => 'Autor',
            'isbn'       => '789-1234567-89',
            'stock'      => 2,
            'materia_id' => $materia->id,
        ]);

        $prestamo = Prestamo::create([
            'alumno_id'                 => $alumno->id,
            'libro_id'                  => $libro->id,
            'fecha_prestamo'            => Carbon::today()->subDays(2),
            'fecha_devolucion_prevista' => Carbon::today()->addDays(10),
        ]);

        $this->assertFalse($prestamo->estaVencido());
    }

    /** @test */
    public function prestamo_calcula_dias_en_prestamo_correctamente()
    {
        $materia = Materia::create(['nombre' => 'Ed. Física']);
        $curso   = Curso::create(['nombre' => '2ºC', 'materia_id' => $materia->id]);

        $alumno = Alumno::create([
            'nombre'    => 'Lucía',
            'apellidos' => 'Moreno',
            'curso_id'  => $curso->id,
        ]);
        $libro = Libro::create([
            'titulo'     => 'Deportes',
            'autor'      => 'Autor',
            'isbn'       => '147-2583691-47',
            'stock'      => 3,
            'materia_id' => $materia->id,
        ]);

        $prestamo = Prestamo::create([
            'alumno_id'        => $alumno->id,
            'libro_id'         => $libro->id,
            'fecha_prestamo'   => Carbon::today()->subDays(7),
            'fecha_devolucion' => Carbon::today(),
        ]);

        $this->assertEquals(7, $prestamo->diasEnPrestamo());
    }
}