@extends('layouts.app')
@section('titulo', 'Listado por estado')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Préstamos por estado</h5>
    <a href="{{ route('listados.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

{{-- Tabs --}}
<ul class="nav nav-tabs mb-4" id="estadoTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="activos-tab" data-bs-toggle="tab"
                data-bs-target="#activos" type="button" role="tab">
            <i class="bi bi-clock me-1"></i>
            Activos
            <span class="badge bg-primary ms-1">{{ $prestados->count() }}</span>
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="devueltos-tab" data-bs-toggle="tab"
                data-bs-target="#devueltos" type="button" role="tab">
            <i class="bi bi-check-circle me-1"></i>
            Devueltos
            <span class="badge bg-secondary ms-1">{{ $devueltos->total() }}</span>
        </button>
    </li>
</ul>

<div class="tab-content">

    {{-- Tab: Activos --}}
    <div class="tab-pane fade show active" id="activos" role="tabpanel">
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Alumno</th>
                            <th>Libro</th>
                            <th>Fecha préstamo</th>
                            <th class="text-center">Días</th>
                            <th class="text-center">Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestados as $prestamo)
                        <tr>
                            <td>{{ $prestamo->alumno->apellidos }}, {{ $prestamo->alumno->nombre }}</td>
                            <td>{{ $prestamo->libro->titulo }}</td>
                            <td>{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <span class="badge {{ $prestamo->estaVencido() ? 'bg-danger' : 'bg-secondary' }}">
                                    {{ $prestamo->diasEnPrestamo() }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($prestamo->estaVencido())
                                    <span class="badge bg-danger">Vencido</span>
                                @else
                                    <span class="badge bg-success">En plazo</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('prestamos.devolucion', $prestamo) }}"
                                   class="btn btn-sm btn-outline-success" title="Devolver">
                                    <i class="bi bi-arrow-return-left"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No hay préstamos activos.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Tab: Devueltos --}}
    <div class="tab-pane fade" id="devueltos" role="tabpanel">
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Alumno</th>
                            <th>Libro</th>
                            <th>Fecha préstamo</th>
                            <th>Fecha devolución</th>
                            <th class="text-center">Días</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($devueltos as $prestamo)
                        <tr>
                            <td>{{ $prestamo->alumno->apellidos }}, {{ $prestamo->alumno->nombre }}</td>
                            <td>{{ $prestamo->libro->titulo }}</td>
                            <td>{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                            <td>{{ $prestamo->fecha_devolucion->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary">
                                    {{ $prestamo->diasEnPrestamo() }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No hay préstamos devueltos.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($devueltos->hasPages())
            <div class="card-footer">
                {{ $devueltos->links() }}
            </div>
            @endif
        </div>
    </div>

</div>
@endsection