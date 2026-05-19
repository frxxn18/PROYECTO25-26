<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Prestamo;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
    public function index()
    {
        return view('exportacion.index');
    }

    public function exportAlumnos()
    {
        $alumnos = Alumno::with('curso')->orderBy('apellidos')->get();

        $csv = "DNI;Apellidos;Nombre;Curso;Teléfono;Email;Cuenta activa\n";

        foreach ($alumnos as $alumno) {
            $csv .= implode(';', [
                $alumno->dni ?? '-',
                $alumno->apellidos,
                $alumno->nombre,
                $alumno->curso->nombre ?? '-',
                $alumno->telefono ?? '-',
                $alumno->email ?? '-',
                $alumno->user_id ? 'Sí' : 'No',
            ]) . "\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="alumnos_' . now()->format('Y-m-d') . '.csv"');
    }

    public function exportPrestamos()
    {
        $prestamos = Prestamo::with(['alumno', 'libro'])
            ->orderBy('fecha_prestamo', 'desc')
            ->get();

        $csv = "Alumno;Libro;ISBN;Fecha préstamo;Devolución prevista;Fecha devolución;Estado\n";

        foreach ($prestamos as $prestamo) {
            $csv .= implode(';', [
                $prestamo->alumno->apellidos . ' ' . $prestamo->alumno->nombre,
                $prestamo->libro->titulo,
                $prestamo->libro->isbn ?? '-',
                $prestamo->fecha_prestamo->format('d/m/Y'),
                $prestamo->fecha_devolucion_prevista?->format('d/m/Y') ?? '-',
                $prestamo->fecha_devolucion?->format('d/m/Y') ?? '-',
                is_null($prestamo->fecha_devolucion)
                    ? ($prestamo->estaVencido() ? 'Vencido' : 'Activo')
                    : 'Devuelto',
            ]) . "\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="prestamos_' . now()->format('Y-m-d') . '.csv"');
    }

    public function backup()
    {
        $tablas = ['materias', 'cursos', 'libros', 'alumnos', 'prestamos', 'users'];
        $sql  = "-- Backup generado el " . now()->format('Y-m-d H:i:s') . "\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tablas as $tabla) {
            $sql .= "-- Tabla: $tabla\n";
            $sql .= "TRUNCATE TABLE `$tabla`;\n";

            $filas = DB::table($tabla)->get();
            foreach ($filas as $fila) {
                $valores = array_map(function ($v) {
                    return is_null($v) ? 'NULL' : "'" . addslashes($v) . "'";
                }, (array) $fila);

                $sql .= "INSERT INTO `$tabla` VALUES (" . implode(', ', $valores) . ");\n";
            }
            $sql .= "\n";
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        return response($sql)
            ->header('Content-Type', 'application/sql')
            ->header('Content-Disposition', 'attachment; filename="backup_' . now()->format('Y-m-d') . '.sql"');
    }
}