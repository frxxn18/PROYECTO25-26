<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::orderBy('nombre')->paginate(15);
        return view('materias.index', compact('materias'));
    }

    public function create()
    {
        return view('materias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:materias,nombre',
        ], [
            'nombre.required' => 'El nombre de la materia es obligatorio.',
            'nombre.unique'   => 'Ya existe una materia con ese nombre.',
        ]);

        Materia::create($request->only('nombre'));
        return redirect()->route('materias.index')
            ->with('success', 'Materia creada correctamente.');
    }

    public function edit(Materia $materia)
    {
        return view('materias.edit', compact('materia'));
    }

    public function update(Request $request, Materia $materia)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:materias,nombre,' . $materia->id,
        ], [
            'nombre.required' => 'El nombre de la materia es obligatorio.',
            'nombre.unique'   => 'Ya existe una materia con ese nombre.',
        ]);

        $materia->update($request->only('nombre'));
        return redirect()->route('materias.index')
            ->with('success', 'Materia actualizada correctamente.');
    }

    public function destroy(Materia $materia)
    {
        if ($materia->libros()->exists()) {
            return back()->with('error', 'No se puede eliminar: hay libros asignados a esta materia.');
        }
        $materia->delete();
        return redirect()->route('materias.index')
            ->with('success', 'Materia eliminada correctamente.');
    }
}