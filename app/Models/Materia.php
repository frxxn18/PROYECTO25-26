<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Curso;

class Materia extends Model
{
    protected $fillable = ['nombre'];

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }
}