<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Http\Requests\LibroRequest;
use App\Helpers\LogHelper;
use App\Models\Materia;

class LibroController extends Controller
{
    public function index()
    {
        $libros = Libro::with('materia')->orderBy('titulo')->paginate(15);
        return view('libros.index', compact('libros'));
    }

    public function create()
    {
        $materias = Materia::orderBy('nombre')->get();
        return view('libros.create', compact('materias'));
    }

    public function store(LibroRequest $request)
    {
        Libro::create($request->validated());
        LogHelper::registrar('crear', 'Libros', 'Libro creado: ' . $request->titulo);
        return redirect()->route('libros.index')
            ->with('success', 'Libro añadido correctamente.');
    }

    public function edit(Libro $libro)
    {
        $materias = Materia::orderBy('nombre')->get();
        return view('libros.edit', compact('libro', 'materias'));
    }

    public function update(LibroRequest $request, Libro $libro)
    {
        $libro->update($request->validated());
        LogHelper::registrar('editar', 'Libros', 'Libro editado: ' . $libro->titulo);
        return redirect()->route('libros.index')
            ->with('success', 'Libro actualizado correctamente.');
    }

    public function destroy(Libro $libro)
    {
        if ($libro->prestamos()->whereNull('fecha_devolucion')->exists()) {
            return back()->with('error', 'No se puede eliminar: el libro tiene préstamos activos.');
        }
        $libro->delete();
        LogHelper::registrar('eliminar', 'Libros', 'Libro eliminado: ' . $libro->titulo);
        return redirect()->route('libros.index')
            ->with('success', 'Libro eliminado correctamente.');
    }
}