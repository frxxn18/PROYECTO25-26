<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BankBook</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="icon" href="{{ asset('assets/img/BankBook.png') }}" type="image/png">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 400px;">

        <div class="text-center mb-4">
            <img src="{{ asset('assets/img/logo.png') }}" alt="BankBook" style="height: 60px;" class="mb-3">
            <h4 class="fw-bold mb-0">BankBook</h4>
            <p class="text-muted small">Gestión de préstamos de libros</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
            <p class="text-center text-muted small mt-3">
                ¿Solo quieres consultar libros?
                <a href="{{ route('catalogo') }}">Ver catálogo público</a>
            </p>
        </form>
    </div>
</div>

</body>
</html>