<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Curso;
use App\Http\Requests\AlumnoRequest;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumno::with('curso');

        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%')
                  ->orWhere('apellidos', 'like', '%' . $request->buscar . '%')
                  ->orWhere('dni', 'like', '%' . $request->buscar . '%');
        }

        if ($request->filled('curso_id')) {
            $query->where('curso_id', $request->curso_id);
        }

        $alumnos = $query->orderBy('apellidos')->paginate(15);
        $cursos = Curso::orderBy('nombre')->get();

        return view('alumnos.index', compact('alumnos', 'cursos'));
    }

    public function create()
    {
        $cursos = Curso::orderBy('nombre')->get();
        return view('alumnos.create', compact('cursos'));
    }

    public function store(AlumnoRequest $request)
    {
        Alumno::create($request->validated());
        return redirect()->route('alumnos.index')->with('success', 'Alumno creado correctamente.');
    }

    public function show(Alumno $alumno)
    {
        $alumno->load('prestamos.libro');
        return view('alumnos.show', compact('alumno'));
    }

    public function edit(Alumno $alumno)
    {
        $cursos = Curso::orderBy('nombre')->get();
        return view('alumnos.edit', compact('alumno', 'cursos'));
    }

    public function update(AlumnoRequest $request, Alumno $alumno)
    {
        $alumno->update($request->validated());
        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado correctamente.');
    }

    public function destroy(Alumno $alumno)
    {
        if ($alumno->prestamos()->whereNull('fecha_devolucion')->exists()) {
            return redirect()->route('alumnos.index')->with('error', 'No se puede eliminar un alumno con préstamos activos.');
        }

        $alumno->delete();
        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado correctamente.');
    }
}