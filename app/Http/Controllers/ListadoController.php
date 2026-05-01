<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Alumno;
use App\Models\Curso;

class ListadoController extends Controller
{
    public function index()
    {
        return view('listados.index');
    }

    public function porCurso()
    {
        $cursos = Curso::with(['alumnos.prestamos' => function ($q) {
            $q->whereNull('fecha_devolucion')->with('libro');
        }])->orderBy('nombre')->get();

        return view('listados.por_curso', compact('cursos'));
    }

    public function porAlumno()
    {
        $alumnos = Alumno::with(['prestamos' => function ($q) {
            $q->whereNull('fecha_devolucion')->with('libro');
        }])
        ->whereHas('prestamos', function ($q) {
            $q->whereNull('fecha_devolucion');
        })
        ->orderBy('apellidos')
        ->get();

        return view('listados.por_alumno', compact('alumnos'));
    }

    public function porEstado()
    {
        $prestados = Prestamo::with(['alumno', 'libro'])
            ->whereNull('fecha_devolucion')
            ->orderBy('fecha_prestamo', 'desc')
            ->get();

        $devueltos = Prestamo::with(['alumno', 'libro'])
            ->whereNotNull('fecha_devolucion')
            ->orderBy('fecha_devolucion', 'desc')
            ->paginate(20);

        return view('listados.por_estado', compact('prestados', 'devueltos'));
    }
}