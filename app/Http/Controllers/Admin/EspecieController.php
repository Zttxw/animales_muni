<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Especie;
use App\Models\Raza;
use Illuminate\Http\Request;

class EspecieController extends Controller
{
    public function index()
    {
        $especies = Especie::withCount(['razas', 'animales'])->get();
        return view('admin.especies.index', compact('especies'));
    }

    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:50|unique:especies']);
        Especie::create($request->only('nombre'));

        return back()->with('success', 'Especie creada correctamente.');
    }

    public function update(Request $request, Especie $especie)
    {
        $request->validate([
            'nombre' => "required|string|max:50|unique:especies,nombre,{$especie->id}",
            'activo' => 'boolean',
        ]);
        $especie->update($request->only('nombre', 'activo'));

        return back()->with('success', 'Especie actualizada.');
    }

    // ── Razas (sub-recurso) ──────────────────────────────────
    public function razas(Especie $especie)
    {
        $razas = $especie->razas()->orderBy('nombre')->get();
        return view('admin.especies.razas', compact('especie', 'razas'));
    }

    public function storeRaza(Request $request, Especie $especie)
    {
        $request->validate(['nombre' => 'required|string|max:100']);
        $especie->razas()->firstOrCreate(['nombre' => $request->nombre]);

        return back()->with('success', 'Raza agregada.');
    }

    public function updateRaza(Request $request, Raza $raza)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'activo' => 'boolean',
        ]);
        $raza->update($request->only('nombre', 'activo'));

        return back()->with('success', 'Raza actualizada.');
    }
}
