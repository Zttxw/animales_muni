<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campana;
use App\Models\TipoCampana;
use Illuminate\Http\Request;

class CampanaController extends Controller
{
    public function index(Request $request)
    {
        $query = Campana::with(['tipoCampana', 'creadoPor'])
            ->withCount('participaciones');

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $campanas = $query->latest('fecha')->paginate(15);
        return view('admin.campanas.index', compact('campanas'));
    }

    public function create()
    {
        $tipos = TipoCampana::activo()->get();
        return view('admin.campanas.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'          => 'required|string|max:150',
            'tipo_campana_id' => 'required|exists:tipos_campana,id',
            'descripcion'     => 'nullable|string',
            'fecha'           => 'required|date|after_or_equal:today',
            'hora'            => 'nullable|date_format:H:i',
            'lugar'           => 'nullable|string|max:200',
            'capacidad'       => 'nullable|integer|min:1',
            'publico_objetivo'=> 'nullable|string',
            'requisitos'      => 'nullable|string',
            'estado'          => 'required|in:BORRADOR,PUBLICADA',
        ]);

        $data['creado_por'] = auth()->id();
        Campana::create($data);

        return redirect()->route('admin.campanas.index')
            ->with('success', 'Campaña creada correctamente.');
    }

    public function show(Campana $campana)
    {
        $campana->load(['tipoCampana', 'creadoPor', 'participaciones.usuario', 'participaciones.animal', 'acciones']);
        return view('admin.campanas.show', compact('campana'));
    }

    public function edit(Campana $campana)
    {
        $tipos = TipoCampana::activo()->get();
        return view('admin.campanas.edit', compact('campana', 'tipos'));
    }

    public function update(Request $request, Campana $campana)
    {
        $data = $request->validate([
            'titulo'          => 'required|string|max:150',
            'tipo_campana_id' => 'required|exists:tipos_campana,id',
            'descripcion'     => 'nullable|string',
            'fecha'           => 'required|date',
            'hora'            => 'nullable|date_format:H:i',
            'lugar'           => 'nullable|string|max:200',
            'capacidad'       => 'nullable|integer|min:1',
            'publico_objetivo'=> 'nullable|string',
            'requisitos'      => 'nullable|string',
            'estado'          => 'required|in:BORRADOR,PUBLICADA,EN_CURSO,FINALIZADA,CANCELADA',
        ]);

        $campana->update($data);

        return redirect()->route('admin.campanas.index')
            ->with('success', 'Campaña actualizada.');
    }

    public function destroy(Campana $campana)
    {
        $campana->delete();
        return redirect()->route('admin.campanas.index')
            ->with('success', 'Campaña eliminada.');
    }
}
