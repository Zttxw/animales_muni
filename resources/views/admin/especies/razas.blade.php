<x-layouts.app header="Razas de {{ $especie->nombre }}">
    <div style="margin-bottom:1rem">
        <a href="{{ route('admin.especies.index') }}" class="btn btn-outline btn-sm">← Volver a Especies</a>
    </div>

    <div class="card" style="max-width:600px">
        <div class="card-header">Razas de {{ $especie->nombre }}</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.especies.razas.store', $especie) }}" style="display:flex;gap:.5rem;margin-bottom:1rem">
                @csrf
                <input type="text" name="nombre" class="form-control" placeholder="Nueva raza..." required>
                <button class="btn btn-primary btn-sm">Agregar</button>
            </form>

            @forelse($razas as $raza)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:.45rem 0;border-bottom:1px solid var(--border)">
                    <span style="font-size:.85rem">{{ $raza->nombre }}</span>
                    <form method="POST" action="{{ route('admin.razas.update', $raza) }}" style="display:inline">
                        @csrf @method('PUT')
                        <input type="hidden" name="nombre" value="{{ $raza->nombre }}">
                        <input type="hidden" name="activo" value="{{ $raza->activo ? 0 : 1 }}">
                        <button class="btn btn-sm {{ $raza->activo ? 'btn-outline' : 'btn-success' }}">
                            {{ $raza->activo ? 'Desactivar' : 'Activar' }}
                        </button>
                    </form>
                </div>
            @empty
                <p style="color:var(--text-muted);font-size:.85rem">No hay razas registradas para esta especie.</p>
            @endforelse
        </div>
    </div>
</x-layouts.app>
