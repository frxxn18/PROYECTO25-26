@extends('layouts.app')
@section('titulo', 'Registrar devolución')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header">Confirmar devolución</div>
            <div class="card-body">

                <dl class="row mb-4">
                    <dt class="col-sm-5">Alumno</dt>
                    <dd class="col-sm-7">
                        {{ $prestamo->alumno->apellidos }}, {{ $prestamo->alumno->nombre }}
                    </dd>

                    <dt class="col-sm-5">Libro</dt>
                    <dd class="col-sm-7">{{ $prestamo->libro->titulo }}</dd>

                    <dt class="col-sm-5">Fecha préstamo</dt>
                    <dd class="col-sm-7">{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</dd>

                    <dt class="col-sm-5">Días en préstamo</dt>
                    <dd class="col-sm-7">
                        <span class="badge {{ $prestamo->estaVencido() ? 'bg-danger' : 'bg-secondary' }}">
                            {{ $prestamo->diasEnPrestamo() }} días
                        </span>
                        @if($prestamo->estaVencido())
                            <span class="text-danger small ms-1">
                                <i class="bi bi-exclamation-triangle"></i> Vencido
                            </span>
                        @endif
                    </dd>

                    @if($prestamo->observaciones)
                    <dt class="col-sm-5">Observaciones</dt>
                    <dd class="col-sm-7">{{ $prestamo->observaciones }}</dd>
                    @endif
                </dl>

                <form action="{{ route('prestamos.devolver', $prestamo) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('prestamos.index') }}"
                           class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-arrow-return-left"></i> Confirmar devolución
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection