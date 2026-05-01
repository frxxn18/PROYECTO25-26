@extends('layouts.app')
@section('titulo', 'Editar libro')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header">Editar libro</div>
            <div class="card-body">
                <form action="{{ route('libros.update', $libro) }}" method="POST">
                    @csrf @method('PUT')
                    @include('libros._form')
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('libros.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection