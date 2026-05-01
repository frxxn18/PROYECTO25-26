@extends('layouts.app')
@section('titulo', 'Cursos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Cursos</h5>
    <a href="{{ route('cursos.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Nuevo curso
    </a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th class="text-center">Alumnos</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($cursos as $curso)
                <tr>
                    <td>{{ $curso->nombre }}</td>
                    <td class="text-center">{{ $curso->alumnos()->count() }}</td>
                    <td class="text-end">
                        <a href="{{ route('cursos.edit', $curso) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('cursos.destroy', $curso) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este curso?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted py-4">No hay cursos registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($cursos->hasPages())
    <div class="card-footer">{{ $cursos->links() }}</div>
    @endif
</div>
@endsection