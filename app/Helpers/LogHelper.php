<?php

namespace App\Helpers;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LogHelper
{
    public static function registrar(string $accion, string $modulo, string $descripcion = ''): void
    {
        Log::create([
            'user_id'     => Auth::id(),
            'accion'      => $accion,
            'modulo'      => $modulo,
            'descripcion' => $descripcion,
            'ip'          => Request::ip(),
        ]);
    }
}