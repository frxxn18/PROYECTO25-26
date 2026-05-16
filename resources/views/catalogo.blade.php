<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de libros</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container py-5">

    {{-- Cabecera --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0"><i class="bi bi-book me-2"></i>Catálogo de libros</h4>
            <span class="text-muted small">Consulta la disponibilidad de los libros</span>
        </div>
        <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
        </a>
    </div>

    {{-- Buscador --}}
    <form method="GET" action="{{ route('catalogo') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="buscar" class="form-control"
                   placeholder="Buscar por título, autor o ISBN..."
                   value="{{ $buscar }}">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Buscar
            </button>
            @if($buscar)
                <a href="{{ route('catalogo') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x"></i> Limpiar
                </a>
            @endif
        </div>
    </form>

    {{-- Resultados --}}
    @if($libros->isEmpty())
        <div class="card shadow-sm">
            <div class="card-body text-center text-muted py-5">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                No se encontraron libros.
            </div>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>ISBN</th>
                            <th class="text-center">Ejemplares</th>
                            <th class="text-center">Disponibles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($libros as $libro)
                        <tr>
                            <td>{{ $libro->titulo }}</td>
                            <td>{{ $libro->autor }}</td>
                            <td class="text-muted small">{{ $libro->isbn }}</td>
                            <td class="text-center">{{ $libro->stock }}</td>
                            <td class="text-center">
                                @if($libro->disponibles > 0)
                                    <span class="badge bg-success">
                                        {{ $libro->disponibles }} disponible(s)
                                    </span>
                                @else
                                    <span class="badge bg-danger">Sin existencias</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($libros->hasPages())
                <div class="card-footer bg-white">
                    {{ $libros->appends(['buscar' => $buscar])->links() }}
                </div>
            @endif
        </div>

        <p class="text-muted small text-center mt-3">
            Mostrando {{ $libros->count() }} de {{ $libros->total() }} libros
        </p>
    @endif

</div>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>