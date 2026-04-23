<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Usuario::with('roles');

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombres', 'like', "%{$buscar}%")
                  ->orWhere('apellidos', 'like', "%{$buscar}%")
                  ->orWhere('documento_identidad', 'like', "%{$buscar}%")
                  ->orWhere('correo', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $usuarios = $query->latest()->paginate(15);
        $roles    = Role::all();

        return view('admin.usuarios.index', compact('usuarios', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombres'             => 'required|string|max:100',
            'apellidos'           => 'required|string|max:100',
            'documento_identidad' => 'required|string|max:20|unique:usuarios',
            'correo'              => 'required|email|max:150|unique:usuarios',
            'telefono'            => 'nullable|string|max:20',
            'password'            => 'required|min:8',
            'rol'                 => 'required|exists:roles,name',
        ]);

        $usuario = Usuario::create($data);
        $usuario->assignRole($request->rol);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit(Usuario $usuario)
    {
        $roles = Role::all();
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $data = $request->validate([
            'nombres'             => 'required|string|max:100',
            'apellidos'           => 'required|string|max:100',
            'documento_identidad' => "required|string|max:20|unique:usuarios,documento_identidad,{$usuario->id}",
            'correo'              => "required|email|max:150|unique:usuarios,correo,{$usuario->id}",
            'telefono'            => 'nullable|string|max:20',
            'estado'              => 'required|in:ACTIVO,SUSPENDIDO,INACTIVO',
            'rol'                 => 'required|exists:roles,name',
        ]);

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $usuario->update($data);
        $usuario->syncRoles([$request->rol]);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(Usuario $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario->update(['estado' => 'INACTIVO']);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario desactivado correctamente.');
    }
}
