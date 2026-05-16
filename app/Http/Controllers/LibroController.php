<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Http\Requests\LibroRequest;

class LibroController extends Controller
{
    public function index()
    {
        $libros = Libro::orderBy('titulo')->paginate(15);
        return view('libros.index', compact('libros'));
    }

    public function create()
    {
        return view('libros.create');
    }

    public function store(LibroRequest $request)
    {
        Libro::create($request->validated());
        return redirect()->route('libros.index')
            ->with('success', 'Libro añadido correctamente.');
    }

    public function edit(Libro $libro)
    {
        return view('libros.edit', compact('libro'));
    }

    public function update(LibroRequest $request, Libro $libro)
    {
        $libro->update($request->validated());
        return redirect()->route('libros.index')
            ->with('success', 'Libro actualizado correctamente.');
    }

    public function destroy(Libro $libro)
    {
        if ($libro->prestamos()->whereNull('fecha_devolucion')->exists()) {
            return back()->with('error', 'No se puede eliminar: el libro tiene préstamos activos.');
        }
        $libro->delete();
        return redirect()->route('libros.index')
            ->with('success', 'Libro eliminado correctamente.');
    }
}