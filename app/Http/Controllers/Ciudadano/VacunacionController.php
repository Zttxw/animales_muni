<?php

namespace App\Http\Controllers\Ciudadano;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Vacunacion;
use App\Models\VacunaCatalogo;
use Illuminate\Http\Request;

class VacunacionController extends Controller
{
    public function index(Animal $animal)
    {
        if ($animal->usuario_id !== auth()->id() && !auth()->user()->hasRole('ADMIN')) {
            abort(403);
        }
        $vacunaciones = $animal->vacunaciones()->with('vacunaCatalogo')->get();
        return view('ciudadano.vacunaciones.index', compact('animal', 'vacunaciones'));
    }

    public function create(Animal $animal)
    {
        if ($animal->usuario_id !== auth()->id()) abort(403);
        $catalogo = VacunaCatalogo::activo()->porEspecie($animal->especie_id)->get();
        return view('ciudadano.vacunaciones.create', compact('animal', 'catalogo'));
    }

    public function store(Request $request, Animal $animal)
    {
        if ($animal->usuario_id !== auth()->id()) abort(403);
        $data = $request->validate([
            'vacuna_id'        => 'nullable|exists:vacunas_catalogo,id',
            'nombre_vacuna'    => 'required|string|max:100',
            'fecha_aplicacion' => 'required|date|before_or_equal:today',
            'proxima_fecha'    => 'nullable|date|after:fecha_aplicacion',
            'observaciones'    => 'nullable|string',
        ]);
        $data['animal_id'] = $animal->id;
        $data['registrado_por'] = auth()->id();
        Vacunacion::create($data);
        $animal->registrarHistorial('VACUNA', "Vacuna: {$data['nombre_vacuna']}");
        return redirect()->route('ciudadano.animales.show', $animal)
            ->with('success', 'Vacunación registrada correctamente.');
    }
}
