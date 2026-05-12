@extends('layouts.app')
@section('titulo', 'Nuevo préstamo')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header">Registrar préstamo</div>
            <div class="card-body">

                <form action="{{ route('prestamos.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Alumno <span class="text-danger">*</span></label>
                        <select name="alumno_id"
                                class="form-select @error('alumno_id') is-invalid @enderror">
                            <option value="">— Selecciona alumno —</option>
                            @foreach($alumnos as $alumno)
                                <option value="{{ $alumno->id }}"
                                    {{ old('alumno_id') == $alumno->id ? 'selected' : '' }}>
                                    {{ $alumno->apellidos }}, {{ $alumno->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('alumno_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Libro <span class="text-danger">*</span></label>
                        <select name="libro_id"
                                class="form-select @error('libro_id') is-invalid @enderror">
                            <option value="">— Selecciona libro —</option>
                            @foreach($libros as $libro)
                                <option value="{{ $libro->id }}"
                                    {{ old('libro_id') == $libro->id ? 'selected' : '' }}>
                                    {{ $libro->titulo }} — {{ $libro->autor }}
                                    ({{ $libro->disponibles }} disponibles)
                                </option>
                            @endforeach
                        </select>
                        @error('libro_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Fecha de préstamo
                            <span class="text-muted small">(opcional, por defecto hoy)</span>
                        </label>
                        <input type="date" name="fecha_prestamo"
                               class="form-control @error('fecha_prestamo') is-invalid @enderror"
                               value="{{ old('fecha_prestamo') }}"
                               max="{{ date('Y-m-d') }}">
                        @error('fecha_prestamo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Fecha prevista de devolución <span class="text-danger">*</span>
                        </label>
                        <input type="date"
                                name="fecha_devolucion_prevista"
                                class="form-control @error('fecha_devolucion_prevista') is-invalid @enderror"
                                value="{{ old('fecha_devolucion_prevista') }}"
                                min="{{ date('Y-m-d') }}"
                                max="{{ $maxFecha }}">
                        <div class="form-text">Máximo 1 año desde hoy ({{ now()->addYear()->format('d/m/Y') }})</div>
                        @error('fecha_devolucion_prevista')
                                    <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Observaciones</label>
                        <textarea name="observaciones"
                                  class="form-control @error('observaciones') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Notas adicionales sobre el estado del libro, acuerdos especiales...">{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('prestamos.index') }}"
                           class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Registrar préstamo
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection