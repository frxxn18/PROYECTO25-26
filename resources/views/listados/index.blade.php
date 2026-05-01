@extends('layouts.app')
@section('titulo', 'Listados')

@section('content')
<h5 class="mb-4">Listados</h5>

<div class="row g-3">

    <div class="col-md-4">
        <a href="{{ route('listados.porCurso') }}" class="text-decoration-none">
            <div class="card shadow-sm h-100 border-0 listado-card">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="listado-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-semibold text-dark">Por curso</h6>
                        <p class="mb-0 text-muted small">
                            Alumnos con préstamos activos agrupados por curso.
                        </p>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('listados.porAlumno') }}" class="text-decoration-none">
            <div class="card shadow-sm h-100 border-0 listado-card">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="listado-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-person-lines-fill fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-semibold text-dark">Por alumno</h6>
                        <p class="mb-0 text-muted small">
                            Préstamos activos detallados por alumno.
                        </p>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('listados.porEstado') }}" class="text-decoration-none">
            <div class="card shadow-sm h-100 border-0 listado-card">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="listado-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-funnel fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-semibold text-dark">Por estado</h6>
                        <p class="mb-0 text-muted small">
                            Filtra entre préstamos activos y devueltos.
                        </p>
                    </div>
                </div>
            </div>
        </a>
    </div>

</div>

<style>
.listado-card { transition: transform .15s, box-shadow .15s; cursor: pointer; }
.listado-card:hover { transform: translateY(-2px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.1) !important; }
.listado-icon { width: 52px; height: 52px; border-radius: 12px;
                display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
</style>
@endsection