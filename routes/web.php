<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\ListadoController;
use App\Http\Controllers\ExportController;

// Redirigir raíz al login
Route::get('/', function () {
    return redirect('/login');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas
Route::middleware('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Alumnos
    Route::resource('alumnos', AlumnoController::class);

    // Libros
    Route::resource('libros', LibroController::class);

    // Cursos
    Route::resource('cursos', CursoController::class);

    // Materias
    Route::resource('materias', MateriaController::class);

    // Préstamos
    Route::resource('prestamos', PrestamoController::class);
    Route::get('/prestamos/{prestamo}/devolucion', [PrestamoController::class, 'devolucion'])->name('prestamos.devolucion');
    Route::put('/prestamos/{prestamo}/devolver', [PrestamoController::class, 'devolver'])->name('prestamos.devolver');
    Route::get('/prestamos/{prestamo}/contrato', [PrestamoController::class, 'contrato'])->name('prestamos.contrato');

    // Listados
    Route::get('/listados', [ListadoController::class, 'index'])->name('listados.index');
    Route::get('/listados/por-curso', [ListadoController::class, 'porCurso'])->name('listados.porCurso');
    Route::get('/listados/por-alumno', [ListadoController::class, 'porAlumno'])->name('listados.porAlumno');
    Route::get('/listados/por-estado', [ListadoController::class, 'porEstado'])->name('listados.porEstado');

    // Exportación
    Route::get('/exportacion', [ExportController::class, 'index'])->name('exportacion.index');
    Route::get('/exportacion/alumnos', [ExportController::class, 'exportAlumnos'])->name('exportacion.alumnos');
    Route::get('/exportacion/prestamos', [ExportController::class, 'exportPrestamos'])->name('exportacion.prestamos');
    Route::get('/exportacion/backup', [ExportController::class, 'backup'])->name('exportacion.backup');
});