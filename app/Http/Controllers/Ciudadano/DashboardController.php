<?php

namespace App\Http\Controllers\Ciudadano;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Campana;
use App\Models\Vacunacion;

class DashboardController extends Controller
{
    public function index()
    {
        $usuario = auth()->user();

        $stats = [
            'mis_animales'    => Animal::where('usuario_id', $usuario->id)->count(),
            'animales_activos'=> Animal::where('usuario_id', $usuario->id)->activo()->count(),
            'vacunas_pendientes' => Vacunacion::whereHas('animal', fn($q) => $q->where('usuario_id', $usuario->id))
                ->whereNotNull('proxima_fecha')
                ->where('proxima_fecha', '<=', now()->addDays(30))
                ->count(),
        ];

        $misAnimales = Animal::with(['especie', 'raza', 'fotoPortada'])
            ->where('usuario_id', $usuario->id)
            ->latest()->take(6)->get();

        $proximasCampanas = Campana::with('tipoCampana')
            ->proximas()->take(3)->get();

        return view('ciudadano.dashboard', compact('stats', 'misAnimales', 'proximasCampanas'));
    }
}
