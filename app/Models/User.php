<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ]; 

    
     /* Función para verificar si el usuario es administrador*/

    public function isAdmin(): bool
    {
        // Esto devolverá true si el campo role es exactamente 'admin'
        return $this->role === 'admin';
    }
}