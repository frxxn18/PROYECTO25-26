@extends('layouts.app')

@section('titulo', 'Detalle alumno')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">{{ $alumno->apellidos }}, {{ $alumno->nombre }}</h5>
    <div class="d-flex gap-2">
        <a href="{{ route('alumnos.edit', $alumno) }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <a href="{{ route('alumnos.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Datos del alumno</div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr>
                        <th>NIA</th>
                        <td>{{ $alumno->nia }}</td>
                    </tr>
                    <tr>
                        <th>Nombre</th>
                        <td>{{ $alumno->nombre }}</td>
                    </tr>
                    <tr>
                        <th>Apellidos</th>
                        <td>{{ $alumno->apellidos }}</td>
                    </tr>
                    <tr>
                        <th>Curso</th>
                        <td>{{ $alumno->curso->nombre ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Teléfono</th>
                        <td>{{ $alumno->telefono ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $alumno->email ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Préstamos</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Libro</th>
                            <th>Fecha préstamo</th>
                            <th>Fecha devolución</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($alumno->prestamos as $prestamo)
                        <tr>
                            <td>{{ $prestamo->libro->titulo ?? '-' }}</td>
                            <td>{{ $prestamo->fecha_prestamo }}</td>
                            <td>{{ $prestamo->fecha_devolucion ?? '-' }}</td>
                            <td>
                                @if($prestamo->estado === 'P')
                                    <span class="badge bg-warning text-dark">Prestado</span>
                                @else
                                    <span class="badge bg-success">Devuelto</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">Sin préstamos registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection