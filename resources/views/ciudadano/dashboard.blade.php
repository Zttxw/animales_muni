<x-layouts.app header="Mi Panel">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">🐾</div>
            <div><div class="stat-value">{{ $stats['mis_animales'] }}</div><div class="stat-label">Mis Animales</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">✅</div>
            <div><div class="stat-value">{{ $stats['animales_activos'] }}</div><div class="stat-label">Activos</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber">💉</div>
            <div><div class="stat-value">{{ $stats['vacunas_pendientes'] }}</div><div class="stat-label">Vacunas Próximas (30 días)</div></div>
        </div>
    </div>

    <div class="card" style="margin-bottom:1.5rem">
        <div class="card-header">
            Mis Animales
            <a href="{{ route('ciudadano.animales.create') }}" class="btn btn-primary btn-sm">+ Registrar Animal</a>
        </div>
        <div class="card-body">
            @if($misAnimales->count())
                <div class="grid-3">
                    @foreach($misAnimales as $animal)
                        <a href="{{ route('ciudadano.animales.show', $animal) }}" class="animal-card" style="text-decoration:none;color:inherit">
                            <div class="animal-card-img">
                                @if($animal->fotoPortada)
                                    <img src="{{ Storage::url($animal->fotoPortada->url) }}" style="width:100%;height:100%;object-fit:cover" alt="{{ $animal->nombre }}">
                                @else
                                    {{ $animal->especie->nombre === 'Gato' ? '🐱' : '🐶' }}
                                @endif
                            </div>
                            <div class="animal-card-body">
                                <h3>{{ $animal->nombre }}</h3>
                                <p>{{ $animal->especie->nombre }} {{ $animal->raza ? '· '.$animal->raza->nombre : '' }}</p>
                                <p style="margin-top:.25rem"><span class="badge badge-{{ $animal->estado === 'ACTIVO' ? 'success' : ($animal->estado === 'PERDIDO' ? 'danger' : 'warning') }}">{{ $animal->estado }}</span></p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="icon">🐾</div>
                    <h3>No tienes animales registrados</h3>
                    <p style="margin-bottom:1rem">Registra tu primera mascota para comenzar</p>
                    <a href="{{ route('ciudadano.animales.create') }}" class="btn btn-primary">Registrar Animal</a>
                </div>
            @endif
        </div>
    </div>

    @if($proximasCampanas->count())
        <div class="card">
            <div class="card-header">Próximas Campañas</div>
            <div class="card-body">
                @foreach($proximasCampanas as $campana)
                    <div style="padding:.6rem 0;border-bottom:1px solid var(--border)">
                        <div style="font-weight:500;font-size:.85rem">{{ $campana->tipoCampana->icono ?? '📢' }} {{ $campana->titulo }}</div>
                        <div style="font-size:.78rem;color:var(--text-muted)">{{ $campana->fecha->format('d/m/Y') }} @if($campana->lugar) · {{ $campana->lugar }} @endif</div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</x-layouts.app>
