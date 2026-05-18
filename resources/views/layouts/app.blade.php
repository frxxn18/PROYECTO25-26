<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Préstamos</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/png">
</head>
<body>

{{-- Sidebar --}}
<div id="sidebar">
    <div class="sidebar-header">
        <i class="bi bi-book"></i> Préstamos
    </div>
    <nav>
        <div class="nav-section">Principal</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section">Gestión</div>
        <a href="{{ route('alumnos.index') }}" class="nav-link {{ request()->is('alumnos*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Alumnos
        </a>
        <a href="{{ route('libros.index') }}" class="nav-link {{ request()->is('libros*') ? 'active' : '' }}">
            <i class="bi bi-book"></i> Libros
        </a>
        <a href="{{ route('cursos.index') }}" class="nav-link {{ request()->is('cursos*') ? 'active' : '' }}">
            <i class="bi bi-mortarboard"></i> Cursos
        </a>
        <a href="{{ route('materias.index') }}" class="nav-link {{ request()->is('materias*') ? 'active' : '' }}">
            <i class="bi bi-journal"></i> Materias
        </a>
        <a href="{{ route('prestamos.index') }}" class="nav-link {{ request()->is('prestamos*') ? 'active' : '' }}">
            <i class="bi bi-arrow-left-right"></i> Préstamos
        </a>

        <div class="nav-section">Informes</div>
        <a href="{{ route('listados.index') }}" class="nav-link {{ request()->is('listados*') ? 'active' : '' }}">
            <i class="bi bi-list-ul"></i> Listados
        </a>
        <a href="{{ route('listados.morosos') }}" class="nav-link {{ request()->is('listados/morosos*') ? 'active' : '' }}">
            <i class="bi bi-exclamation-triangle text-danger"></i> Morosos
        </a>
        <a href="{{ route('exportacion.index') }}" class="nav-link {{ request()->is('exportacion*') ? 'active' : '' }}">
            <i class="bi bi-download"></i> Exportación
        </a>

        <div class="nav-section">Sistema</div>
        <a href="{{ route('admins.index') }}" class="nav-link {{ request()->is('admins*') ? 'active' : '' }}">
            <i class="bi bi-shield-lock"></i> Administradores
        </a>
    </nav>
</div>

{{-- Contenido principal --}}
<div id="content">
    {{-- Topbar --}}
    <div id="topbar">
        <span class="fw-semibold">@yield('titulo', 'Dashboard')</span>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small">
                {{ Auth::user()->name }}
                <span class="badge {{ Auth::user()->role === 'admin' ? 'bg-primary' : 'bg-secondary' }} ms-1">
                    {{ Auth::user()->role === 'admin' ? 'Administrador' : 'Usuario' }}
                </span>
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-box-arrow-right"></i> Salir
                </button>
            </form>
        </div>
    </div>

    {{-- Alertas --}}
    <div class="px-4 pt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    {{-- Contenido de cada vista --}}
    <div class="p-4">
        @yield('content')
    </div>
</div>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
@yield('scripts')
</body>
</html>