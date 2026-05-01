@extends('layouts.app')
@section('titulo', 'Libros')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Catálogo de libros</h5>
    <a href="{{ route('libros.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Nuevo libro
    </a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>ISBN</th>
                    <th class="text-center">Ejemplares</th>
                    <th class="text-center">Disponibles</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($libros as $libro)
                <tr>
                    <td>{{ $libro->titulo }}</td>
                    <td class="text-muted">{{ $libro->autor }}</td>
                    <td class="text-muted small">{{ $libro->isbn ?? '—' }}</td>
                    <td class="text-center">{{ $libro->ejemplares }}</td>
                    <td class="text-center">
                        <span class="badge {{ $libro->disponibles > 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ $libro->disponibles }}
                        </span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('libros.edit', $libro) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('libros.destroy', $libro) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este libro?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No hay libros registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($libros->hasPages())
    <div class="card-footer">
        {{ $libros->links() }}
    </div>
    @endif
</div>
@endsection