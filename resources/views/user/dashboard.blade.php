<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis préstamos</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container py-5">

    {{-- Cabecera --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">📚 Mis préstamos</h4>
            <span class="text-muted small">{{ Auth::user()->name }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-box-arrow-right"></i> Salir
            </button>
        </form>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Sin alumno vinculado --}}
    @if($prestamos->isEmpty())
        <div class="card shadow-sm">
            <div class="card-body text-center text-muted py-5">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                No tienes préstamos activos en este momento.
            </div>
        </div>
    @else
        {{-- Resumen --}}
        @php
            $activos  = $prestamos->filter(fn($p) => is_null($p->fecha_devolucion));
            $vencidos = $activos->filter(fn($p) => $p->estaVencido());
        @endphp

        <div class="row g-3 mb-4">
            <div class="col-sm-4">
                <div class="card border-0 shadow-sm text-center py-3">
                    <div class="fs-2 fw-bold text-primary">{{ $prestamos->count() }}</div>
                    <div class="text-muted small">Total préstamos</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card border-0 shadow-sm text-center py-3">
                    <div class="fs-2 fw-bold text-warning">{{ $activos->count() }}</div>
                    <div class="text-muted small">Activos</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card border-0 shadow-sm text-center py-3">
                    <div class="fs-2 fw-bold text-danger">{{ $vencidos->count() }}</div>
                    <div class="text-muted small">Vencidos</div>
                </div>
            </div>
        </div>

        {{-- Tabla de préstamos --}}
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Libro</th>
                            <th>Fecha préstamo</th>
                            <th>Devolución prevista</th>
                            <th class="text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prestamos as $prestamo)
                        <tr>
                            <td>{{ $prestamo->libro->titulo }}</td>
                            <td>{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                            <td>{{ $prestamo->fecha_devolucion_prevista?->format('d/m/Y') ?? '—' }}</td>
                            <td class="text-center">
                                @if(is_null($prestamo->fecha_devolucion))
                                    @if($prestamo->estaVencido())
                                        <span class="badge bg-danger">Vencido</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Activo</span>
                                    @endif
                                @else
                                    <span class="badge bg-success">Devuelto</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>