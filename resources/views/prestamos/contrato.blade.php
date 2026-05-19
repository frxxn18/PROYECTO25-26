@extends('layouts.app')
@section('titulo', 'Contrato de préstamo')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm" id="contrato">
            <div class="card-body p-5">

                <div class="text-center mb-4">
                    <h4 class="fw-bold">CONTRATO DE PRÉSTAMO DE LIBRO</h4>
                    <p class="text-muted small">{{ config('app.name') }}</p>
                </div>

                <p>En fecha <strong>{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</strong>,
                se formaliza el préstamo del siguiente libro:</p>

                <table class="table table-bordered my-4">
                    <tr>
                        <th class="w-25 table-light">Título</th>
                        <td>{{ $prestamo->libro->titulo }}</td>
                    </tr>
                    <tr>
                        <th class="table-light">Autor</th>
                        <td>{{ $prestamo->libro->autor }}</td>
                    </tr>
                    <tr>
                        <th class="table-light">ISBN</th>
                        <td>{{ $prestamo->libro->isbn ?? '—' }}</td>
                    </tr>
                </table>

                <p>El alumno/a
                    <strong>{{ $prestamo->alumno->nombre }} {{ $prestamo->alumno->apellidos }}</strong>
                   se compromete a devolver el libro en buen estado antes del
                   <strong>{{ $prestamo->fecha_devolucion_prevista?->format('d/m/Y') ?? 'plazo acordado' }}</strong>.
                </p>

                @if($prestamo->observaciones)
                <p><strong>Observaciones:</strong> {{ $prestamo->observaciones }}</p>
                @endif

                <div class="row mt-5">
                    <div class="col text-center">
                        <div class="border-top pt-2 mt-5 mx-4">Firma del alumno/a</div>
                    </div>
                    <div class="col text-center">
                        <div class="border-top pt-2 mt-5 mx-4">Firma del responsable</div>
                    </div>
                </div>

            </div>
        </div>

        <div class="mt-3 d-flex gap-2">
            <a href="{{ route('prestamos.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer"></i> Imprimir
            </button>
        </div>
    </div>
</div>
@section('scripts')
<style>
    @media print {
        #sidebar,
        #topbar,
        .mt-3.d-flex {
            display: none !important;
        }

        #content {
            margin-left: 0 !important;
            padding: 0 !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
        }

        body {
            background: white !important;
        }
    }
</style>
@endsection
@endsection