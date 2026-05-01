@extends('layouts.app')
@section('titulo', 'Préstamos activos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Préstamos activos</h5>
    <a href="{{ route('prestamos.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Nuevo préstamo
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Alumno</th>
                    <th>Libro</th>
                    <th>Fecha préstamo</th>
                    <th class="text-center">Días</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prestamos as $prestamo)
                <tr>
                    <td>{{ $prestamo->alumno->apellidos }}, {{ $prestamo->alumno->nombre }}</td>
                    <td>{{ $prestamo->libro->titulo }}</td>
                    <td>{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <span class="badge {{ $prestamo->estaVencido() ? 'bg-danger' : 'bg-secondary' }}">
                            {{ $prestamo->diasEnPrestamo() }}
                        </span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('prestamos.contrato', $prestamo) }}"
                           class="btn btn-sm btn-outline-secondary" title="Ver contrato">
                            <i class="bi bi-file-text"></i>
                        </a>
                        <a href="{{ route('prestamos.devolucion', $prestamo) }}"
                           class="btn btn-sm btn-outline-success" title="Registrar devolución">
                            <i class="bi bi-arrow-return-left"></i>
                        </a>
                        <form action="{{ route('prestamos.destroy', $prestamo) }}" method="POST"
                              class="d-inline" onsubmit="return confirm('¿Eliminar este préstamo?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                        No hay préstamos activos.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($prestamos->hasPages())
    <div class="card-footer">
        {{ $prestamos->links() }}
    </div>
    @endif
</div>
@endsection