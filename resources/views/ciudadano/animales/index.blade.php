<x-layouts.app header="Mis Animales">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
        <p style="color:var(--text-muted);font-size:.85rem">{{ $animales->total() }} animales registrados</p>
        <a href="{{ route('ciudadano.animales.create') }}" class="btn btn-primary">+ Registrar Animal</a>
    </div>

    @if($animales->count())
        <div class="grid-3">
            @foreach($animales as $animal)
                <a href="{{ route('ciudadano.animales.show', $animal) }}" class="animal-card" style="text-decoration:none;color:inherit">
                    <div class="animal-card-img">
                        @if($animal->fotoPortada)
                            <img src="{{ Storage::url($animal->fotoPortada->url) }}" style="width:100%;height:100%;object-fit:cover">
                        @else
                            {{ $animal->especie->nombre === 'Gato' ? '🐱' : '🐶' }}
                        @endif
                    </div>
                    <div class="animal-card-body">
                        <h3>{{ $animal->nombre }}</h3>
                        <p>{{ $animal->especie->nombre }} {{ $animal->raza ? '· '.$animal->raza->nombre : '' }}</p>
                        <p><small>{{ $animal->codigo_municipal }}</small></p>
                        <span class="badge badge-{{ $animal->estado === 'ACTIVO' ? 'success' : ($animal->estado === 'PERDIDO' ? 'danger' : 'warning') }}">{{ $animal->estado }}</span>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="pagination">{{ $animales->links('vendor.pagination.simple') }}</div>
    @else
        <div class="empty-state">
            <div class="icon">🐾</div>
            <h3>No tienes animales registrados</h3>
            <p>Registra tu primera mascota</p>
        </div>
    @endif
</x-layouts.app>
