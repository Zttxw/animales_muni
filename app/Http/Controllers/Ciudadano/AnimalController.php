<?php

namespace App\Http\Controllers\Ciudadano;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Especie;
use App\Models\Raza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{
    public function index()
    {
        $animales = Animal::with(['especie', 'raza', 'fotoPortada'])
            ->where('usuario_id', auth()->id())
            ->latest()->paginate(12);

        return view('ciudadano.animales.index', compact('animales'));
    }

    public function create()
    {
        $especies = Especie::activo()->get();
        return view('ciudadano.animales.create', compact('especies'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'              => 'required|string|max:100',
            'especie_id'          => 'required|exists:especies,id',
            'raza_id'             => 'nullable|exists:razas,id',
            'sexo'                => 'required|in:M,H,DESCONOCIDO',
            'fecha_nacimiento'    => 'nullable|date|before_or_equal:today',
            'edad_aproximada'     => 'nullable|string|max:30',
            'color'               => 'nullable|string|max:100',
            'tamano'              => 'nullable|in:PEQUEÑO,MEDIANO,GRANDE,GIGANTE',
            'estado_reproductivo' => 'nullable|in:ENTERO,ESTERILIZADO,CASTRADO,DESCONOCIDO',
            'senas_particulares'  => 'nullable|string',
            'observaciones'       => 'nullable|string',
            'foto'                => 'nullable|image|max:2048',
        ]);

        $data['usuario_id'] = auth()->id();
        $animal = Animal::create($data);

        // Subir foto
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('animales', 'public');
            $animal->fotos()->create([
                'url'        => $path,
                'es_portada' => true,
            ]);
        }

        $animal->registrarHistorial('DATOS', 'Animal registrado en el sistema');

        return redirect()->route('ciudadano.animales.show', $animal)
            ->with('success', "¡{$animal->nombre} ha sido registrado! Código: {$animal->codigo_municipal}");
    }

    public function show(Animal $animal)
    {
        $this->authorize($animal);

        $animal->load([
            'especie', 'raza', 'usuario', 'fotos',
            'vacunaciones.vacunaCatalogo',
            'procedimientos.tipoProcedimiento',
            'historial',
            'adopcion',
        ]);

        return view('ciudadano.animales.show', compact('animal'));
    }

    public function edit(Animal $animal)
    {
        $this->authorize($animal);

        $especies = Especie::activo()->get();
        $razas    = Raza::where('especie_id', $animal->especie_id)->activo()->get();

        return view('ciudadano.animales.edit', compact('animal', 'especies', 'razas'));
    }

    public function update(Request $request, Animal $animal)
    {
        $this->authorize($animal);

        $data = $request->validate([
            'nombre'              => 'required|string|max:100',
            'especie_id'          => 'required|exists:especies,id',
            'raza_id'             => 'nullable|exists:razas,id',
            'sexo'                => 'required|in:M,H,DESCONOCIDO',
            'fecha_nacimiento'    => 'nullable|date|before_or_equal:today',
            'edad_aproximada'     => 'nullable|string|max:30',
            'color'               => 'nullable|string|max:100',
            'tamano'              => 'nullable|in:PEQUEÑO,MEDIANO,GRANDE,GIGANTE',
            'estado_reproductivo' => 'nullable|in:ENTERO,ESTERILIZADO,CASTRADO,DESCONOCIDO',
            'senas_particulares'  => 'nullable|string',
            'observaciones'       => 'nullable|string',
        ]);

        $previos = $animal->only(array_keys($data));
        $animal->update($data);
        $animal->registrarHistorial('DATOS', 'Datos actualizados', $previos);

        return redirect()->route('ciudadano.animales.show', $animal)
            ->with('success', 'Datos actualizados correctamente.');
    }

    // ── API: razas por especie (para selects dinámicos) ──────
    public function razasPorEspecie(Especie $especie)
    {
        return response()->json(
            $especie->razas()->activo()->orderBy('nombre')->get(['id', 'nombre'])
        );
    }

    // ── Autorización simple ──────────────────────────────────
    private function authorize(Animal $animal): void
    {
        if ($animal->usuario_id !== auth()->id() && !auth()->user()->hasRole('ADMIN')) {
            abort(403, 'No tienes permiso para ver este animal.');
        }
    }
}
