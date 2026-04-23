<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEstadoUsuario
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->estado !== 'ACTIVO') {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['correo' => 'Tu cuenta está suspendida o inactiva. Contacta al administrador.']);
        }

        return $next($request);
    }
}
