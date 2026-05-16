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

        return view('listados.porCurso', compact('cursos'));
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

        return view('listados.porAlumno', compact('alumnos'));
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

        return view('listados.porEstado', compact('prestados', 'devueltos'));
    }

    public function morosos()
    {
        $prestamos = Prestamo::with(['alumno', 'libro'])
            ->whereNull('fecha_devolucion')
            ->where('fecha_devolucion_prevista', '<', now())
            ->orderBy('fecha_devolucion_prevista', 'asc')
            ->get();

        return view('listados.morosos', compact('prestamos'));
    }
}