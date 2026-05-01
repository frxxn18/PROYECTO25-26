@extends('layouts.app')
@section('titulo', 'Listado por alumno')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Préstamos activos por alumno</h5>
    <a href="{{ route('listados.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

@forelse($alumnos as $alumno)
<div class="card shadow-sm mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-semibold">
            <i class="bi bi-person me-1"></i>
            {{ $alumno->apellidos }}, {{ $alumno->nombre }}
        </span>
        <div class="d-flex align-items-center gap-2">
            @if($alumno->curso)
                <span class="badge bg-light text-dark border">{{ $alumno->curso->nombre }}</span>
            @endif
            <span class="badge bg-primary">
                {{ $alumno->prestamos->count() }} libro(s)
            </span>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-sm mb-0">
            <thead class="table-light">
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Fecha préstamo</th>
                    <th class="text-center">Días</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumno->prestamos as $prestamo)
                <tr>
                    <td>{{ $prestamo->libro->titulo }}</td>
                    <td class="text-muted small">{{ $prestamo->libro->autor }}</td>
                    <td>{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <span class="badge {{ $prestamo->estaVencido() ? 'bg-danger' : 'bg-secondary' }}">
                            {{ $prestamo->diasEnPrestamo() }}
                        </span>
                    </td>
                    <td class="text-end">
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
@empty
    <div class="text-center text-muted py-5">
        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
        No hay alumnos con préstamos activos.
    </div>
@endforelse
@endsection