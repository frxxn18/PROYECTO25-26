@extends('layouts.app')
@section('titulo', 'Nuevo libro')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header">Nuevo libro</div>
            <div class="card-body">
                <form action="{{ route('libros.store') }}" method="POST">
                    @csrf
                    @include('libros._form')
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('libros.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection