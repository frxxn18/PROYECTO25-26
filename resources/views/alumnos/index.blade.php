@extends('layouts.app')

@section('titulo', 'Alumnos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Listado de alumnos</h5>
    <a href="{{ route('alumnos.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Nuevo alumno
    </a>
</div>

{{-- Filtros --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('alumnos.index') }}" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="buscar" class="form-control form-control-sm"
                    placeholder="Buscar por nombre, apellidos o NIA..."
                    value="{{ request('buscar') }}">
            </div>
            <div class="col-md-4">
                <select name="curso_id" class="form-select form-select-sm">
                    <option value="">Todos los cursos</option>
                    @foreach($cursos as $curso)
                        <option value="{{ $curso->id }}" {{ request('curso_id') == $curso->id ? 'selected' : '' }}>
                            {{ $curso->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary btn-sm w-100">
                    <i class="bi bi-search"></i> Filtrar
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Tabla --}}
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>DNI</th>
                    <th>Apellidos</th>
                    <th>Nombre</th>
                    <th>Curso</th>
                    <th>Teléfono</th>
                    <th class="text-center">Cuenta</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($alumnos as $alumno)
                <tr>
                    <td>{{ $alumno->dni }}</td>
                    <td>{{ $alumno->apellidos }}</td>
                    <td>{{ $alumno->nombre }}</td>
                    <td>{{ $alumno->curso->nombre ?? '-' }}</td>
                    <td>{{ $alumno->telefono ?? '-' }}</td>
                    <td class="text-center">
                        @if($alumno->user_id)
                            <span class="badge bg-success">
                                <i class="bi bi-person-check"></i> Activa
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                <i class="bi bi-person-x"></i> Sin cuenta
                            </span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('alumnos.show', $alumno) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('alumnos.edit', $alumno) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('alumnos.destroy', $alumno) }}" class="d-inline"
                            onsubmit="return confirm('¿Eliminar este alumno?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No se encontraron alumnos.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Paginación --}}
<div class="mt-3">
    {{ $alumnos->withQueryString()->links() }}
</div>
@endsection