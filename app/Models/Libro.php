<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Prestamo;

class Libro extends Model
{
    protected $fillable = ['titulo', 'autor', 'isbn', 'stock', 'materia_id'];

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class); //[cite: 16]
    }

    
     /* Calcula cuántos ejemplares están libres para préstamo*/
     
    public function getDisponiblesAttribute()
    {
        // Al stock total le restamos los préstamos que NO tienen fecha de devolución (están activos)
        $prestados = $this->prestamos()->whereNull('fecha_devolucion')->count();
        
        return $this->stock - $prestados;
    }

    public function materia()
    {
        //Para añadir la relacion con materia
        return $this->belongsTo(Materia::class);
    }
}