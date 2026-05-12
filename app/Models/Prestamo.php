<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumno_id',
        'libro_id',
        'fecha_prestamo',
        'fecha_devolucion',
        'fecha_devolucion_prevista',
        'observaciones',
    ];

    protected $casts = [
        'fecha_prestamo'   => 'date',
        'fecha_devolucion' => 'date',
        'fecha_devolucion_prevista' => 'date',
    ];

    // Relaciones
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }

    // Helpers
    public function estaActivo(): bool
    {
        return is_null($this->fecha_devolucion);
    }

    public function diasEnPrestamo(): int
    {
        $hasta = $this->fecha_devolucion ?? now();
        return $this->fecha_prestamo->diffInDays($hasta);
    }

    public function estaVencido(): bool
    {
        if (!$this->estaActivo()) return False;
        if($this->fecha_devolucion_prevista) {
            return now()->gt($this->fecha_devolucion_pervista);
        }
        return $this->diasEnPrestamo() > 15;
    }
}