<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::orderBy('nombre')->paginate(15);
        return view('cursos.index', compact('cursos'));
    }

    public function create()
    {
        return view('cursos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:cursos,nombre',
        ], [
            'nombre.required' => 'El nombre del curso es obligatorio.',
            'nombre.unique'   => 'Ya existe un curso con ese nombre.',
        ]);

        Curso::create($request->only('nombre'));
        return redirect()->route('cursos.index')
            ->with('success', 'Curso creado correctamente.');
    }

    public function edit(Curso $curso)
    {
        return view('cursos.edit', compact('curso'));
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:cursos,nombre,' . $curso->id,
        ], [
            'nombre.required' => 'El nombre del curso es obligatorio.',
            'nombre.unique'   => 'Ya existe un curso con ese nombre.',
        ]);

        $curso->update($request->only('nombre'));
        return redirect()->route('cursos.index')
            ->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Curso $curso)
    {
        if ($curso->alumnos()->exists()) {
            return back()->with('error', 'No se puede eliminar: hay alumnos asignados a este curso.');
        }
        $curso->delete();
        return redirect()->route('cursos.index')
            ->with('success', 'Curso eliminado correctamente.');
    }
}