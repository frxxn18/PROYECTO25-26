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
        'observaciones',
    ];

    protected $casts = [
        'fecha_prestamo'   => 'date',
        'fecha_devolucion' => 'date',
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
        return $this->estaActivo() && $this->diasEnPrestamo() > 15;
    }
}