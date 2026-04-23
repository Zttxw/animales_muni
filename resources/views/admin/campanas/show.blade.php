<x-layouts.app header="{{ $campana->titulo }}">
    <div style="margin-bottom:1rem">
        <a href="{{ route('admin.campanas.index') }}" class="btn btn-outline btn-sm">← Volver</a>
        <a href="{{ route('admin.campanas.edit', $campana) }}" class="btn btn-outline btn-sm">Editar</a>
    </div>

    <div class="grid-2">
        <div class="card">
            <div class="card-header">Información</div>
            <div class="card-body">
                <table style="width:100%;font-size:.85rem">
                    <tr><td style="padding:.4rem 0;color:var(--text-muted);width:35%">Tipo</td><td>{{ $campana->tipoCampana->icono }} {{ $campana->tipoCampana->nombre }}</td></tr>
                    <tr><td style="padding:.4rem 0;color:var(--text-muted)">Fecha</td><td>{{ $campana->fecha->format('d/m/Y') }}</td></tr>
                    <tr><td style="padding:.4rem 0;color:var(--text-muted)">Hora</td><td>{{ $campana->hora ?? '—' }}</td></tr>
                    <tr><td style="padding:.4rem 0;color:var(--text-muted)">Lugar</td><td>{{ $campana->lugar ?? '—' }}</td></tr>
                    <tr><td style="padding:.4rem 0;color:var(--text-muted)">Capacidad</td><td>{{ $campana->capacidad ?? 'Sin límite' }}</td></tr>
                    <tr><td style="padding:.4rem 0;color:var(--text-muted)">Estado</td><td><span class="badge badge-{{ in_array($campana->estado,['PUBLICADA','EN_CURSO'])?'success':'gray' }}">{{ $campana->estado }}</span></td></tr>
                    <tr><td style="padding:.4rem 0;color:var(--text-muted)">Creado por</td><td>{{ $campana->creadoPor?->nombre_completo ?? '—' }}</td></tr>
                </table>
                @if($campana->descripcion)
                    <div style="margin-top:1rem;padding:.75rem;background:#f8fafc;border-radius:6px;font-size:.83rem">{{ $campana->descripcion }}</div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">Participantes ({{ $campana->participaciones->count() }})</div>
            <div class="card-body" style="max-height:400px;overflow-y:auto">
                @forelse($campana->participaciones as $p)
                    <div style="padding:.45rem 0;border-bottom:1px solid var(--border);font-size:.83rem;display:flex;justify-content:space-between">
                        <span>{{ $p->usuario->nombre_completo }}</span>
                        <span class="badge {{ $p->asistencia ? 'badge-success' : 'badge-gray' }}">{{ $p->asistencia ? 'Asistió' : 'Inscrito' }}</span>
                    </div>
                @empty
                    <p style="color:var(--text-muted);font-size:.83rem">Sin participantes aún.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
