<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Prestamo;

class Libro extends Model
{
    protected $fillable = ['titulo', 'autor', 'isbn', 'stock'];

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
}