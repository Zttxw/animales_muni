<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Usuario;
use App\Models\Campana;
use App\Models\AnimalCallejero;
use App\Models\Adopcion;
use App\Models\Vacunacion;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_usuarios'    => Usuario::count(),
            'total_animales'    => Animal::count(),
            'animales_activos'  => Animal::activo()->count(),
            'animales_perdidos' => Animal::perdido()->count(),
            'en_adopcion'       => Adopcion::where('estado', 'DISPONIBLE')->count(),
            'callejeros'        => AnimalCallejero::count(),
            'campanas_activas'  => Campana::whereIn('estado', ['PUBLICADA', 'EN_CURSO'])->count(),
            'vacunas_mes'       => Vacunacion::whereMonth('fecha_aplicacion', now()->month)
                                             ->whereYear('fecha_aplicacion', now()->year)->count(),
        ];

        $ultimosAnimales = Animal::with(['especie', 'usuario'])
            ->latest()->take(5)->get();

        $proximasCampanas = Campana::with('tipoCampana')
            ->proximas()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'ultimosAnimales', 'proximasCampanas'));
    }
}
