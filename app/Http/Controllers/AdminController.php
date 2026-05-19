<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\LogHelper;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->orderBy('name')->get();
        return view('admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin',
        ]);
        LogHelper::registrar('crear', 'Administradores', 'Administrador creado: ' . $request->email);

        return redirect()->route('admins.index')
            ->with('success', 'Administrador creado correctamente.');
    }

    public function edit(User $admin)
    {
        if ($admin->role !== 'admin') {
            return redirect()->route('admins.index')
                ->with('error', 'Usuario no encontrado.');
        }

        return view('admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $admin->name  = $request->name;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();
        LogHelper::registrar('editar', 'Administradores', 'Administrador editado: ' . $admin->email);

        return redirect()->route('admins.index')
            ->with('success', 'Administrador actualizado correctamente.');
    }

    public function destroy(User $admin)
    {
        // Evitar que el admin se elimine a sí mismo
        if ($admin->id === auth()->id()) {
            return redirect()->route('admins.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $admin->delete();
        LogHelper::registrar('eliminar', 'Administradores', 'Administrador eliminado: ' . $admin->email);

        return redirect()->route('admins.index')
            ->with('success', 'Administrador eliminado correctamente.');
    }
}