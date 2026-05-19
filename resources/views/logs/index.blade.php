@extends('layouts.app')

@section('titulo', 'Historial de auditoría')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Historial de auditoría</h5>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Fecha y hora</th>
                    <th>Usuario</th>
                    <th>Módulo</th>
                    <th>Acción</th>
                    <th>Descripción</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td class="text-muted small">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $log->user->name ?? 'Sistema' }}</td>
                    <td>
                        <span class="badge bg-secondary">{{ $log->modulo }}</span>
                    </td>
                    <td>
                        @php
                            $colores = [
                                'crear'    => 'bg-success',
                                'editar'   => 'bg-primary',
                                'eliminar' => 'bg-danger',
                                'login'    => 'bg-info',
                                'logout'   => 'bg-secondary',
                                'prestar'  => 'bg-warning text-dark',
                                'devolver' => 'bg-success',
                            ];
                            $color = $colores[$log->accion] ?? 'bg-secondary';
                        @endphp
                        <span class="badge {{ $color }}">{{ ucfirst($log->accion) }}</span>
                    </td>
                    <td>{{ $log->descripcion }}</td>
                    <td class="text-muted small">{{ $log->ip }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="bi bi-clock-history fs-1 d-block mb-2"></i>
                        No hay registros todavía.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
    <div class="card-footer bg-white">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection