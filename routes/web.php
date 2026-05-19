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
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LogController;

// Redirigir raíz al login
Route::get('/', function () {
    return redirect('/login');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Ruta de catalogo (sin loggearse)
Route::get('/catalogo', function () {
    $buscar = request('buscar');
    $libros = \App\Models\Libro::when($buscar, fn($q) => $q->where('titulo', 'like', "%$buscar%")
            ->orWhere('autor', 'like', "%$buscar%")
            ->orWhere('isbn', 'like', "%$buscar%"))
        ->orderBy('titulo')
        ->paginate(15);

    return view('catalogo', compact('libros', 'buscar'));
})->name('catalogo');

// Rutas de administrador
Route::middleware('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $totalAlumnos      = \App\Models\Alumno::count();
        $totalLibros       = \App\Models\Libro::count();
        $prestamosActivos  = \App\Models\Prestamo::whereNull('fecha_devolucion')->count();
        $ultimosPrestamos  = \App\Models\Prestamo::with(['alumno', 'libro'])
                                ->latest()
                                ->take(8)
                                ->get();

        $prestamosVencidos = \App\Models\Prestamo::whereNull('fecha_devolucion')
                                ->where('fecha_devolucion_prevista', '<', now())
                                ->count();

        return view('dashboard', compact(
            'totalAlumnos',
            'totalLibros',
            'prestamosActivos',
            'prestamosVencidos',
            'ultimosPrestamos'
        ));
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
    Route::get('/listados/morosos', [ListadoController::class, 'morosos'])->name('listados.morosos');

    // Exportación
    Route::get('/exportacion', [ExportController::class, 'index'])->name('exportacion.index');
    Route::get('/exportacion/alumnos', [ExportController::class, 'exportAlumnos'])->name('exportacion.alumnos');
    Route::get('/exportacion/prestamos', [ExportController::class, 'exportPrestamos'])->name('exportacion.prestamos');
    Route::get('/exportacion/backup', [ExportController::class, 'backup'])->name('exportacion.backup');

    // Gestión de usuarios
    Route::get('/alumnos/{alumno}/crear-usuario', [UserController::class, 'create'])->name('user.create');
    Route::post('/alumnos/{alumno}/crear-usuario', [UserController::class, 'store'])->name('user.store');
    Route::get('/alumnos/{alumno}/editar-usuario', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/alumnos/{alumno}/editar-usuario', [UserController::class, 'update'])->name('user.update');
    Route::delete('/alumnos/{alumno}/eliminar-usuario', [UserController::class, 'destroy'])->name('user.destroy');

    // Administradores
    Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
    Route::get('/admins/crear', [AdminController::class, 'create'])->name('admins.create');
    Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
    Route::get('/admins/{admin}/editar', [AdminController::class, 'edit'])->name('admins.edit');
    Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('admins.update');
    Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy');

    // Logs
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');

});

// Rutas de usuario normal
Route::middleware('auth.user')->group(function () {
    Route::get('/mis-prestamos', [UserController::class, 'dashboard'])->name('user.dashboard');
});