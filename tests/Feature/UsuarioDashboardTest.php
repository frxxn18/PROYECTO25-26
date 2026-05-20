<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Alumno;
use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\Curso;
use App\Models\Materia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsuarioDashboardTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Materia $materia;
    private Curso $curso;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@test.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        $this->materia = Materia::create(['nombre' => 'Ciencias']);
        $this->curso   = Curso::create(['nombre' => '1ºA', 'materia_id' => $this->materia->id]);
    }

    // =========================================================
    // DASHBOARD USUARIO NORMAL
    // =========================================================

    /** @test */
    public function usuario_con_alumno_ve_sus_prestamos_en_el_dashboard()
    {
        $user = User::create([
            'name'     => 'Alumno Test',
            'email'    => 'alumno@test.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        $alumno = Alumno::create([
            'nombre'    => 'Alumno',
            'apellidos' => 'Test',
            'curso_id'  => $this->curso->id,
            'user_id'   => $user->id,
        ]);

        $libro = Libro::create([
            'titulo'     => 'Libro Test',
            'autor'      => 'Autor',
            'isbn'       => '000-0000000-00',
            'stock'      => 2,
            'materia_id' => $this->materia->id,
        ]);

        Prestamo::create([
            'alumno_id'      => $alumno->id,
            'libro_id'       => $libro->id,
            'fecha_prestamo' => Carbon::today(),
        ]);

        $response = $this->actingAs($user)->get('/mis-prestamos');

        $response->assertStatus(200);
        $response->assertViewHas('prestamos');
        $this->assertCount(1, $response->viewData('prestamos'));
    }

    /** @test */
    public function usuario_sin_alumno_vinculado_ve_dashboard_vacio()
    {
        $user = User::create([
            'name'     => 'Sin Alumno',
            'email'    => 'sinalumno@test.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        $response = $this->actingAs($user)->get('/mis-prestamos');

        $response->assertStatus(200);
        $response->assertViewHas('prestamos');
        $this->assertCount(0, $response->viewData('prestamos'));
    }

    // =========================================================
    // CREAR USUARIO PARA ALUMNO (admin)
    // =========================================================

    /** @test */
    public function admin_puede_crear_un_usuario_para_un_alumno()
    {
        $alumno = Alumno::create([
            'nombre'    => 'María',
            'apellidos' => 'López',
            'dni'       => '22222222B',
            'curso_id'  => $this->curso->id,
        ]);

        $response = $this->actingAs($this->admin)->post(
            "/alumnos/{$alumno->id}/crear-usuario",
            [
                'email'                 => 'maria@test.com',
                'password'              => 'password123',
                'password_confirmation' => 'password123',
            ]
        );

        $response->assertRedirect("/alumnos/{$alumno->id}");
        $this->assertDatabaseHas('users', ['email' => 'maria@test.com']);
        $this->assertNotNull($alumno->fresh()->user_id);
    }

    /** @test */
    public function no_se_puede_crear_usuario_si_el_alumno_ya_tiene_uno()
    {
        $user = User::create([
            'name'     => 'Existente',
            'email'    => 'existente@test.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        $alumno = Alumno::create([
            'nombre'    => 'Pedro',
            'apellidos' => 'Pérez',
            'curso_id'  => $this->curso->id,
            'user_id'   => $user->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get("/alumnos/{$alumno->id}/crear-usuario");

        $response->assertRedirect("/alumnos/{$alumno->id}");
        $response->assertSessionHas('error');
    }

    /** @test */
    public function admin_puede_eliminar_la_cuenta_de_un_alumno()
    {
        $user = User::create([
            'name'     => 'A Eliminar',
            'email'    => 'eliminar@test.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        $alumno = Alumno::create([
            'nombre'    => 'Test',
            'apellidos' => 'Borrar',
            'curso_id'  => $this->curso->id,
            'user_id'   => $user->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->delete("/alumnos/{$alumno->id}/eliminar-usuario");

        $response->assertRedirect("/alumnos/{$alumno->id}");
        $this->assertNull($alumno->fresh()->user_id);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}