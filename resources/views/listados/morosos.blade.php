@extends('layouts.app')

@section('titulo', 'Lista de morosos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">
        <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
        Lista de morosos
    </h5>
    <a href="{{ route('listados.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

@if($prestamos->isEmpty())
    <div class="card shadow-sm">
        <div class="card-body text-center text-muted py-5">
            <i class="bi bi-check-circle fs-1 d-block mb-2 text-success"></i>
            No hay morosos en este momento.
        </div>
    </div>
@else
    <div class="alert alert-danger">
        Hay <strong>{{ $prestamos->count() }}</strong> préstamo(s) con la fecha de devolución superada.
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Alumno</th>
                        <th>Libro</th>
                        <th>Fecha préstamo</th>
                        <th>Debía devolver</th>
                        <th class="text-center">Días de retraso</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prestamos as $prestamo)
                    <tr>
                        <td>{{ $prestamo->alumno->apellidos }}, {{ $prestamo->alumno->nombre }}</td>
                        <td>{{ $prestamo->libro->titulo }}</td>
                        <td>{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                        <td class="text-danger fw-semibold">
                            {{ $prestamo->fecha_devolucion_prevista->format('d/m/Y') }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-danger">
                                {{ now()->diffInDays($prestamo->fecha_devolucion_prevista) }} días
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('alumnos.show', $prestamo->alumno) }}"
                               class="btn btn-sm btn-outline-secondary" title="Ver alumno">
                                <i class="bi bi-person"></i>
                            </a>
                            <a href="{{ route('prestamos.devolucion', $prestamo) }}"
                               class="btn btn-sm btn-outline-success" title="Registrar devolución">
                                <i class="bi bi-arrow-return-left"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection