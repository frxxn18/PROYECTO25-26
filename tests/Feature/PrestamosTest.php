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

class PrestamosTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Materia $materia;
    private Curso $curso;
    private Alumno $alumno;
    private Libro $libro;

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

        $this->alumno = Alumno::create([
            'nombre'    => 'Juan',
            'apellidos' => 'García',
            'dni'       => '11111111A',
            'curso_id'  => $this->curso->id,
        ]);

        $this->libro = Libro::create([
            'titulo'     => 'Libro de Prueba',
            'autor'      => 'Autor Test',
            'isbn'       => '000-1111111-00',
            'stock'      => 3,
            'materia_id' => $this->materia->id,
        ]);
    }

    // =========================================================
    // LISTADO DE PRÉSTAMOS
    // =========================================================

    /** @test */
    public function admin_puede_ver_el_listado_de_prestamos()
    {
        $response = $this->actingAs($this->admin)->get('/prestamos');

        $response->assertStatus(200);
    }

    /** @test */
    public function usuario_no_autenticado_no_puede_ver_prestamos()
    {
        $response = $this->get('/prestamos');

        $response->assertRedirect('/login');
    }

    // =========================================================
    // CREAR PRÉSTAMO
    // =========================================================

    /** @test */
    public function admin_puede_registrar_un_nuevo_prestamo()
    {
        $response = $this->actingAs($this->admin)->post('/prestamos', [
            'alumno_id'                 => $this->alumno->id,
            'libro_id'                  => $this->libro->id,
            'fecha_prestamo'            => Carbon::today()->format('Y-m-d'),
            'fecha_devolucion_prevista' => Carbon::today()->addDays(15)->format('Y-m-d'),
        ]);

        $response->assertRedirect('/prestamos');
        $this->assertDatabaseHas('prestamos', [
            'alumno_id' => $this->alumno->id,
            'libro_id'  => $this->libro->id,
        ]);
    }

    /** @test */
    public function no_se_puede_prestar_un_libro_sin_stock()
    {
        // Agotar el stock del libro (stock = 3, hacemos 3 préstamos activos)
        for ($i = 0; $i < 3; $i++) {
            Prestamo::create([
                'alumno_id'      => $this->alumno->id,
                'libro_id'       => $this->libro->id,
                'fecha_prestamo' => Carbon::today(),
            ]);
        }

        $response = $this->actingAs($this->admin)->post('/prestamos', [
            'alumno_id'      => $this->alumno->id,
            'libro_id'       => $this->libro->id,
            'fecha_prestamo' => Carbon::today()->format('Y-m-d'),
        ]);

        // Debe redirigir con error, no crear el préstamo
        $response->assertSessionHas('error');
        $this->assertCount(3, Prestamo::all()); // No se creó el 4º
    }

    /** @test */
    public function crear_prestamo_requiere_alumno_y_libro()
    {
        $response = $this->actingAs($this->admin)->post('/prestamos', []);

        $response->assertSessionHasErrors(['alumno_id', 'libro_id']);
    }

    // =========================================================
    // DEVOLUCIÓN
    // =========================================================

    /** @test */
    public function admin_puede_registrar_la_devolucion_de_un_prestamo()
    {
        $prestamo = Prestamo::create([
            'alumno_id'      => $this->alumno->id,
            'libro_id'       => $this->libro->id,
            'fecha_prestamo' => Carbon::today()->subDays(5),
        ]);

        $response = $this->actingAs($this->admin)
            ->put("/prestamos/{$prestamo->id}/devolver");

        $response->assertRedirect('/prestamos');
        $this->assertNotNull($prestamo->fresh()->fecha_devolucion);
    }

    /** @test */
    public function no_se_puede_devolver_un_prestamo_ya_devuelto()
    {
        $prestamo = Prestamo::create([
            'alumno_id'        => $this->alumno->id,
            'libro_id'         => $this->libro->id,
            'fecha_prestamo'   => Carbon::today()->subDays(5),
            'fecha_devolucion' => Carbon::today(),
        ]);

        $response = $this->actingAs($this->admin)
            ->put("/prestamos/{$prestamo->id}/devolver");

        $response->assertRedirect('/prestamos');
        $response->assertSessionHas('error');
    }

    // =========================================================
    // ELIMINAR PRÉSTAMO
    // =========================================================

    /** @test */
    public function admin_puede_eliminar_un_prestamo()
    {
        $prestamo = Prestamo::create([
            'alumno_id'      => $this->alumno->id,
            'libro_id'       => $this->libro->id,
            'fecha_prestamo' => Carbon::today(),
        ]);

        $response = $this->actingAs($this->admin)
            ->delete("/prestamos/{$prestamo->id}");

        $response->assertRedirect('/prestamos');
        $this->assertDatabaseMissing('prestamos', ['id' => $prestamo->id]);
    }
}