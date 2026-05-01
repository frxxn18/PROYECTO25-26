@extends('layouts.app')
@section('titulo', 'Listado por curso')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Préstamos activos por curso</h5>
    <a href="{{ route('listados.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

@forelse($cursos as $curso)
    @php
        $alumnosConPrestamo = $curso->alumnos->filter(fn($a) => $a->prestamos->isNotEmpty());
    @endphp
    @if($alumnosConPrestamo->isNotEmpty())
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-semibold">{{ $curso->nombre }}</span>
            <span class="badge bg-primary">
                {{ $alumnosConPrestamo->sum(fn($a) => $a->prestamos->count()) }} préstamo(s)
            </span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Alumno</th>
                        <th>Libro</th>
                        <th>Fecha préstamo</th>
                        <th class="text-center">Días</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alumnosConPrestamo as $alumno)
                        @foreach($alumno->prestamos as $prestamo)
                        <tr>
                            <td>{{ $alumno->apellidos }}, {{ $alumno->nombre }}</td>
                            <td>{{ $prestamo->libro->titulo }}</td>
                            <td>{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <span class="badge {{ $prestamo->estaVencido() ? 'bg-danger' : 'bg-secondary' }}">
                                    {{ $prestamo->diasEnPrestamo() }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
@empty
    <div class="text-center text-muted py-5">
        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
        No hay cursos con préstamos activos.
    </div>
@endforelse
@endsection