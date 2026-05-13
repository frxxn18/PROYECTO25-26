<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Muestra el formulario para crear cuenta de usuario a un alumno
    public function create(Alumno $alumno)
    {
        // Si el alumno ya tiene cuenta no dejamos crear otra
        if ($alumno->user_id) {
            return redirect()->route('alumnos.show', $alumno)
                ->with('error', 'Este alumno ya tiene una cuenta de usuario.');
        }

        return view('user.create', compact('alumno'));
    }

    // Guarda el nuevo usuario y lo vincula al alumno
    public function store(Request $request, Alumno $alumno)
    {
        $request->validate([
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $alumno->nombre . ' ' . $alumno->apellidos,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        $alumno->update(['user_id' => $user->id]);

        return redirect()->route('alumnos.show', $alumno)
            ->with('success', 'Cuenta de usuario creada correctamente.');
    }

    // Dashboard del usuario normal — solo sus préstamos
    public function dashboard()
    {
        $alumno = auth()->user()->alumno;

        if (!$alumno) {
            return view('user.dashboard', ['prestamos' => collect()]);
        }

        $prestamos = $alumno->prestamos()
            ->with('libro')
            ->orderBy('fecha_prestamo', 'desc')
            ->get();

        return view('user.dashboard', compact('prestamos'));
    }
}