<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ── Formulario de Login ──────────────────────────────────
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'correo'   => 'required|email',
            'password' => 'required',
        ]);

        // Buscar usuario por correo
        $usuario = Usuario::where('correo', $credentials['correo'])->first();

        if (!$usuario || !Hash::check($credentials['password'], $usuario->password)) {
            return back()->withErrors([
                'correo' => 'Las credenciales no coinciden con nuestros registros.',
            ])->onlyInput('correo');
        }

        if ($usuario->estado !== 'ACTIVO') {
            return back()->withErrors([
                'correo' => 'Tu cuenta está suspendida o inactiva.',
            ])->onlyInput('correo');
        }

        Auth::login($usuario, $request->boolean('remember'));
        $usuario->update(['ultimo_acceso' => now()]);
        $request->session()->regenerate();

        // Redirigir según rol
        if ($usuario->hasRole('ADMIN')) {
            return redirect()->intended(route('admin.dashboard'));
        }
        return redirect()->intended(route('ciudadano.dashboard'));
    }

    // ── Formulario de Registro ───────────────────────────────
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nombres'             => 'required|string|max:100',
            'apellidos'           => 'required|string|max:100',
            'documento_identidad' => 'required|string|max:20|unique:usuarios,documento_identidad',
            'telefono'            => 'nullable|string|max:20',
            'correo'              => 'required|email|max:150|unique:usuarios,correo',
            'password'            => ['required', 'confirmed', Password::min(8)],
        ]);

        $usuario = Usuario::create($data);
        $usuario->assignRole('CIUDADANO');

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('ciudadano.dashboard');
    }

    // ── Logout ───────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
