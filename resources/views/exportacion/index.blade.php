@extends('layouts.app')

@section('titulo', 'Exportación')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Exportación y backup</h5>
</div>

<div class="row g-4">

    {{-- Exportar alumnos --}}
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center py-4">
                <i class="bi bi-people fs-1 text-primary mb-3 d-block"></i>
                <h6 class="fw-semibold">Exportar alumnos</h6>
                <p class="text-muted small">Descarga un CSV con todos los alumnos registrados, su curso, teléfono, email y si tienen cuenta activa.</p>
                <a href="{{ route('exportacion.alumnos') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-download"></i> Descargar CSV
                </a>
            </div>
        </div>
    </div>

    {{-- Exportar préstamos --}}
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center py-4">
                <i class="bi bi-arrow-left-right fs-1 text-success mb-3 d-block"></i>
                <h6 class="fw-semibold">Exportar préstamos</h6>
                <p class="text-muted small">Descarga un CSV con el historial completo de préstamos, incluyendo fechas y estados.</p>
                <a href="{{ route('exportacion.prestamos') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-download"></i> Descargar CSV
                </a>
            </div>
        </div>
    </div>

    {{-- Backup base de datos --}}
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center py-4">
                <i class="bi bi-database fs-1 text-warning mb-3 d-block"></i>
                <h6 class="fw-semibold">Backup de base de datos</h6>
                <p class="text-muted small">Descarga un fichero SQL con toda la base de datos para hacer una copia de seguridad completa.</p>
                <a href="{{ route('exportacion.backup') }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-download"></i> Descargar SQL
                </a>
            </div>
        </div>
    </div>

</div>
@endsection