<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si no está loggeado, al login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        //dd(Auth::user()->role); para pruebas 
        
        // Si es admin no debería estar en rutas de usuario, lo mandamos a su dashboard
        if (Auth::user()->role === 'admin') {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}