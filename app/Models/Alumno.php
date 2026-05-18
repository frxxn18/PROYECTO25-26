<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Curso;
use App\Models\Prestamo;

class Alumno extends Model
{
    protected $fillable = ['nombre', 'apellidos', 'dni', 'curso_id', 'user_id', 'telefono', 'email'];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
}