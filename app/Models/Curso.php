<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Materia;
use App\Models\Alumno;

class Curso extends Model
{
    protected $fillable = ['nombre', 'materia_id'];

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function alumnos()
    {
        return $this->hasMany(Alumno::class);
    }
}