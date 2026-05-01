@extends('layouts.app')

@section('titulo', 'Editar alumno')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Editar alumno</h5>
    <a href="{{ route('alumnos.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('alumnos.update', $alumno) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">NIA *</label>
                    <input type="text" name="nia" class="form-control @error('nia') is-invalid @enderror"
                        value="{{ old('nia', $alumno->nia) }}">
                    @error('nia')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                        value="{{ old('nombre', $alumno->nombre) }}">
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Apellidos *</label>
                    <input type="text" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror"
                        value="{{ old('apellidos', $alumno->apellidos) }}">
                    @error('apellidos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Curso *</label>
                    <select name="curso_id" class="form-select @error('curso_id') is-invalid @enderror">
                        <option value="">Selecciona un curso</option>
                        @foreach($cursos as $curso)
                            <option value="{{ $curso->id }}" {{ old('curso_id', $alumno->curso_id) == $curso->id ? 'selected' : '' }}>
                                {{ $curso->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('curso_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                        value="{{ old('telefono', $alumno->telefono) }}">
                    @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $alumno->email) }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Actualizar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection