<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\Materia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AutenticacionTest extends TestCase
{
    use RefreshDatabase;

    // =========================================================
    // LOGIN
    // =========================================================

    /** @test */
    public function la_pagina_de_login_carga_correctamente()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /** @test */
    public function redirige_al_login_si_no_autenticado()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function admin_puede_iniciar_sesion_y_va_al_dashboard()
    {
        $admin = User::create([
            'name'     => 'Admin Test',
            'email'    => 'admin@test.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);

        $response = $this->post('/login', [
            'email'    => 'admin@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($admin);
    }

    /** @test */
    public function usuario_normal_puede_iniciar_sesion_y_va_a_mis_prestamos()
    {
        $user = User::create([
            'name'     => 'Usuario Test',
            'email'    => 'usuario@test.com',
            'password' => Hash::make('password123'),
            'role'     => 'user',
        ]);

        $response = $this->post('/login', [
            'email'    => 'usuario@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/mis-prestamos');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function credenciales_incorrectas_no_permiten_login()
    {
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@test.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);

        $response = $this->post('/login', [
            'email'    => 'admin@test.com',
            'password' => 'contraseña_incorrecta',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function logout_cierra_la_sesion_correctamente()
    {
        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@test.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);

        $this->actingAs($admin);

        $response = $this->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    // =========================================================
    // MIDDLEWARE ADMIN
    // =========================================================

    /** @test */
    public function usuario_normal_no_puede_acceder_al_dashboard_de_admin()
    {
        $user = User::create([
            'name'     => 'Usuario',
            'email'    => 'user@test.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirect('/mis-prestamos');
    }

    /** @test */
    public function admin_puede_acceder_al_dashboard()
    {
        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@test.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertStatus(200);
    }

    /** @test */
    public function usuario_no_autenticado_no_puede_acceder_a_mis_prestamos()
    {
        $response = $this->get('/mis-prestamos');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function admin_es_redirigido_al_dashboard_si_intenta_acceder_a_mis_prestamos()
    {
        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@test.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/mis-prestamos');

        $response->assertRedirect('/dashboard');
    }

    // =========================================================
    // CATÁLOGO PÚBLICO
    // =========================================================

    /** @test */
    public function el_catalogo_es_accesible_sin_autenticacion()
    {
        $response = $this->get('/catalogo');

        $response->assertStatus(200);
    }
}