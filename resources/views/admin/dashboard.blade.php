<x-layouts.app header="Dashboard Administrativo">
    {{-- KPIs --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">👥</div>
            <div><div class="stat-value">{{ $stats['total_usuarios'] }}</div><div class="stat-label">Usuarios</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">🐾</div>
            <div><div class="stat-value">{{ $stats['total_animales'] }}</div><div class="stat-label">Animales Registrados</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber">🔍</div>
            <div><div class="stat-value">{{ $stats['animales_perdidos'] }}</div><div class="stat-label">Animales Perdidos</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">💜</div>
            <div><div class="stat-value">{{ $stats['en_adopcion'] }}</div><div class="stat-label">En Adopción</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">🐕</div>
            <div><div class="stat-value">{{ $stats['callejeros'] }}</div><div class="stat-label">Callejeros</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">📢</div>
            <div><div class="stat-value">{{ $stats['campanas_activas'] }}</div><div class="stat-label">Campañas Activas</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">💉</div>
            <div><div class="stat-value">{{ $stats['vacunas_mes'] }}</div><div class="stat-label">Vacunas este Mes</div></div>
        </div>
    </div>

    <div class="grid-2">
        {{-- Últimos animales --}}
        <div class="card">
            <div class="card-header">
                Últimos Animales Registrados
            </div>
            <div class="card-body">
                @forelse($ultimosAnimales as $animal)
                    <div style="display:flex;align-items:center;gap:.75rem;padding:.5rem 0;border-bottom:1px solid var(--border);">
                        <div style="width:36px;height:36px;border-radius:8px;background:var(--primary-light);display:flex;align-items:center;justify-content:center;">🐾</div>
                        <div style="flex:1">
                            <div style="font-weight:500;font-size:.85rem">{{ $animal->nombre }}</div>
                            <div style="font-size:.75rem;color:var(--text-muted)">{{ $animal->especie->nombre }} · {{ $animal->codigo_municipal }}</div>
                        </div>
                        <span class="badge badge-success">{{ $animal->estado }}</span>
                    </div>
                @empty
                    <p style="color:var(--text-muted);font-size:.85rem">No hay animales registrados aún.</p>
                @endforelse
            </div>
        </div>

        {{-- Próximas campañas --}}
        <div class="card">
            <div class="card-header">
                Próximas Campañas
                <a href="{{ route('admin.campanas.create') }}" class="btn btn-primary btn-sm">+ Nueva</a>
            </div>
            <div class="card-body">
                @forelse($proximasCampanas as $campana)
                    <div style="padding:.5rem 0;border-bottom:1px solid var(--border);">
                        <div style="font-weight:500;font-size:.85rem">{{ $campana->titulo }}</div>
                        <div style="font-size:.75rem;color:var(--text-muted)">
                            {{ $campana->tipoCampana->nombre }} · {{ $campana->fecha->format('d/m/Y') }}
                            @if($campana->lugar) · {{ $campana->lugar }} @endif
                        </div>
                    </div>
                @empty
                    <p style="color:var(--text-muted);font-size:.85rem">No hay campañas próximas.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
