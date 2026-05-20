@extends('layouts.app')

@section('titulo', 'Dashboard')

@section('content')

<div class="row g-4 mb-4">

    {{-- Tarjeta Alumnos --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-primary bg-opacity-10">
                    <i class="bi bi-people-fill fs-3 text-primary"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ $totalAlumnos }}</div>
                    <div class="text-muted small">Alumnos registrados</div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="{{ route('alumnos.index') }}" class="text-primary small text-decoration-none">
                    Ver alumnos <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Tarjeta Libros --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-success bg-opacity-10">
                    <i class="bi bi-book-fill fs-3 text-success"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ $totalLibros }}</div>
                    <div class="text-muted small">Libros en catálogo</div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="{{ route('libros.index') }}" class="text-success small text-decoration-none">
                    Ver libros <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Tarjeta Préstamos activos --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-warning bg-opacity-10">
                    <i class="bi bi-arrow-left-right fs-3 text-warning"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ $prestamosActivos }}</div>
                    <div class="text-muted small">Préstamos activos</div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="{{ route('prestamos.index') }}" class="text-warning small text-decoration-none">
                    Ver préstamos <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Tarjeta Préstamos vencidos --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-danger bg-opacity-10">
                    <i class="bi bi-exclamation-triangle-fill fs-3 text-danger"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ $prestamosVencidos }}</div>
                    <div class="text-muted small">Préstamos vencidos</div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="{{ route('listados.morosos') }}" class="text-danger small text-decoration-none">
                    Ver listado <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

</div>

{{-- Últimos préstamos --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
        <span class="fw-semibold"><i class="bi bi-clock-history me-2"></i>Préstamos recientes</span>
        <a href="{{ route('prestamos.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg"></i> Nuevo préstamo
        </a>
    </div>
    <div class="card-body p-0">
        @if($ultimosPrestamos->isEmpty())
            <div class="text-center text-muted py-5">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                No hay préstamos registrados todavía.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Alumno</th>
                            <th>Libro</th>
                            <th>Fecha préstamo</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ultimosPrestamos as $prestamo)
                        <tr>
                            <td>{{ $prestamo->alumno->apellidos }}, {{ $prestamo->alumno->nombre }}</td>
                            <td>{{ $prestamo->libro->titulo }}</td>
                            <td>{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                            <td>
                                @if($prestamo->estaActivo())
                                    @if($prestamo->estaVencido())
                                        <span class="badge bg-danger">Vencido</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Activo</span>
                                    @endif
                                @else
                                    <span class="badge bg-success">Devuelto</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('alumnos.show', $prestamo->alumno_id) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection