@extends('layouts.app')
@section('titulo', 'Materias')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Materias</h5>
    <a href="{{ route('materias.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Nueva materia
    </a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($materias as $materia)
                <tr>
                    <td>{{ $materia->nombre }}</td>
                    <td class="text-end">
                        <a href="{{ route('materias.edit', $materia) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('materias.destroy', $materia) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta materia?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center text-muted py-4">No hay materias registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($materias->hasPages())
    <div class="card-footer">{{ $materias->links() }}</div>
    @endif
</div>
@endsection