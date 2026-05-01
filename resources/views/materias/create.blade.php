@extends('layouts.app')
@section('titulo', 'Nueva materia')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header">Nueva materia</div>
            <div class="card-body">
                <form action="{{ route('materias.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                               value="{{ old('nombre') }}">
                        @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('materias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection