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

    // Muestra el formulario para editar la cuenta de un alumno
    public function edit(Alumno $alumno)
    {
        if (!$alumno->user_id) {
            return redirect()->route('alumnos.show', $alumno)
                ->with('error', 'Este alumno no tiene cuenta de usuario.');
        }

        return view('user.edit', compact('alumno'));
    }

    // Guarda los cambios de la cuenta
    public function update(Request $request, Alumno $alumno)
    {
        $user = $alumno->user;

        $request->validate([
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('alumnos.show', $alumno)
            ->with('success', 'Cuenta actualizada correctamente.');
    }

    // Elimina la cuenta de usuario del alumno
    public function destroy(Alumno $alumno)
    {
        if (!$alumno->user_id) {
            return redirect()->route('alumnos.show', $alumno)
                ->with('error', 'Este alumno no tiene cuenta de usuario.');
        }

        $user = $alumno->user;
        $alumno->update(['user_id' => null]);
        $user->delete();

        return redirect()->route('alumnos.show', $alumno)
            ->with('success', 'Cuenta eliminada correctamente.');
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