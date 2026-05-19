<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Alumno;
use App\Models\Libro;
use App\Http\Requests\PrestamoRequest;
use Carbon\Carbon;
use App\Helpers\LogHelper;

class PrestamoController extends Controller
{
    public function index()
    {
        $prestamos = Prestamo::with(['alumno', 'libro'])
            ->whereNull('fecha_devolucion')
            ->orderBy('fecha_prestamo', 'desc')
            ->paginate(15);

        return view('prestamos.index', compact('prestamos'));
    }

    public function create()
    {
        $alumnos = Alumno::orderBy('apellidos')->get();
        $libros = Libro::all()->filter(fn($l) => $l->disponibles > 0)->sortBy('titulo');

        //Se da un año el libro y sino es un moroso
        $maxFecha = now()->addYear()->format('Y-m-d');

        return view('prestamos.create', compact('alumnos', 'libros', 'maxFecha'));
    }

    public function store(PrestamoRequest $request)
    {
        $libro = Libro::findOrFail($request->libro_id);

        if ($libro->disponibles <= 0) {
            return back()->withInput()
                ->with('error', 'No hay ejemplares disponibles de este libro.');
        }

        Prestamo::create([
            'alumno_id'        => $request->alumno_id,
            'libro_id'         => $request->libro_id,
            'fecha_prestamo'   => $request->fecha_prestamo ?? Carbon::today(),
            'fecha_devolucion_prevista' => $request->fecha_devolucion_prevista,
            'fecha_devolucion' => null,
            'observaciones'    => $request->observaciones,
        ]);
        LogHelper::registrar('prestar', 'Préstamos', 'Préstamo registrado: ' . $request->alumno_id . ' → libro ' . $request->libro_id);

        return redirect()->route('prestamos.index')
            ->with('success', 'Préstamo registrado correctamente.');
    }

    public function devolucion(Prestamo $prestamo)
    {
        if (! $prestamo->estaActivo()) {
            return redirect()->route('prestamos.index')
                ->with('error', 'Este préstamo ya fue devuelto.');
        }

        return view('prestamos.devolucion', compact('prestamo'));
    }

    public function devolver(Prestamo $prestamo)
    {
        if (! $prestamo->estaActivo()) {
            return redirect()->route('prestamos.index')
                ->with('error', 'Este préstamo ya fue devuelto.');
        }

        $prestamo->update([
            'fecha_devolucion' => Carbon::today(),
        ]);
        LogHelper::registrar('devolver', 'Préstamos', 'Devolución registrada: ' . $prestamo->alumno->nombre . ' → ' . $prestamo->libro->titulo);

        return redirect()->route('prestamos.index')
            ->with('success', 'Devolución registrada correctamente.');
    }

    public function contrato(Prestamo $prestamo)
    {
        return view('prestamos.contrato', compact('prestamo'));
    }

    public function destroy(Prestamo $prestamo)
    {
        $prestamo->delete();
        LogHelper::registrar('eliminar', 'Préstamos', 'Préstamo eliminado: id ' . $prestamo->id);

        return redirect()->route('prestamos.index')
            ->with('success', 'Préstamo eliminado correctamente.');
    }
}