<x-layouts.app header="{{ $animal->nombre }}">
    <div style="margin-bottom:1rem">
        <a href="{{ route('ciudadano.animales.index') }}" class="btn btn-outline btn-sm">← Volver</a>
    </div>

    <div class="grid-2">
        {{-- Info principal --}}
        <div class="card">
            <div class="card-header">
                Información del Animal
                <a href="{{ route('ciudadano.animales.edit', $animal) }}" class="btn btn-outline btn-sm">Editar</a>
            </div>
            <div class="card-body">
                <div style="text-align:center;margin-bottom:1rem">
                    <div style="width:120px;height:120px;border-radius:50%;background:linear-gradient(135deg,#dbeafe,#ede9fe);margin:0 auto;display:flex;align-items:center;justify-content:center;font-size:3rem;">
                        @if($animal->fotoPortada)
                            <img src="{{ Storage::url($animal->fotoPortada->url) }}" style="width:100%;height:100%;border-radius:50%;object-fit:cover">
                        @else
                            🐾
                        @endif
                    </div>
                    <h2 style="margin-top:.75rem;font-size:1.2rem">{{ $animal->nombre }}</h2>
                    <p style="color:var(--text-muted);font-size:.85rem">{{ $animal->codigo_municipal }}</p>
                    <span class="badge badge-{{ $animal->estado === 'ACTIVO' ? 'success' : ($animal->estado === 'PERDIDO' ? 'danger' : 'warning') }}">{{ $animal->estado }}</span>
                </div>

                <table style="width:100%;font-size:.85rem">
                    <tr><td style="padding:.4rem 0;color:var(--text-muted);width:40%">Especie</td><td style="padding:.4rem 0">{{ $animal->especie->nombre }}</td></tr>
                    <tr><td style="padding:.4rem 0;color:var(--text-muted)">Raza</td><td style="padding:.4rem 0">{{ $animal->raza?->nombre ?? 'No especificada' }}</td></tr>
                    <tr><td style="padding:.4rem 0;color:var(--text-muted)">Sexo</td><td style="padding:.4rem 0">{{ $animal->sexo === 'M' ? 'Macho' : ($animal->sexo === 'H' ? 'Hembra' : 'Desconocido') }}</td></tr>
                    <tr><td style="padding:.4rem 0;color:var(--text-muted)">Color</td><td style="padding:.4rem 0">{{ $animal->color ?? '—' }}</td></tr>
                    <tr><td style="padding:.4rem 0;color:var(--text-muted)">Tamaño</td><td style="padding:.4rem 0">{{ $animal->tamano ?? '—' }}</td></tr>
                    <tr><td style="padding:.4rem 0;color:var(--text-muted)">Reproductivo</td><td style="padding:.4rem 0">{{ $animal->estado_reproductivo ?? '—' }}</td></tr>
                    <tr><td style="padding:.4rem 0;color:var(--text-muted)">Nacimiento</td><td style="padding:.4rem 0">{{ $animal->fecha_nacimiento?->format('d/m/Y') ?? $animal->edad_aproximada ?? '—' }}</td></tr>
                    <tr><td style="padding:.4rem 0;color:var(--text-muted)">Propietario</td><td style="padding:.4rem 0">{{ $animal->usuario->nombre_completo }}</td></tr>
                </table>

                @if($animal->senas_particulares)
                    <div style="margin-top:1rem;padding:.75rem;background:#f8fafc;border-radius:6px">
                        <strong style="font-size:.8rem">Señas particulares:</strong>
                        <p style="font-size:.82rem;margin-top:.25rem">{{ $animal->senas_particulares }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Salud --}}
        <div>
            <div class="card" style="margin-bottom:1rem">
                <div class="card-header">
                    Vacunaciones
                    <a href="{{ route('ciudadano.animales.vacunaciones.create', $animal) }}" class="btn btn-success btn-sm">+ Agregar</a>
                </div>
                <div class="card-body">
                    @forelse($animal->vacunaciones as $vac)
                        <div style="padding:.5rem 0;border-bottom:1px solid var(--border);font-size:.83rem">
                            <div style="display:flex;justify-content:space-between">
                                <strong>{{ $vac->nombre_vacuna }}</strong>
                                <span>{{ $vac->fecha_aplicacion->format('d/m/Y') }}</span>
                            </div>
                            @if($vac->proxima_fecha)
                                <div style="font-size:.75rem;color:var(--text-muted)">Próxima: {{ $vac->proxima_fecha->format('d/m/Y') }}</div>
                            @endif
                        </div>
                    @empty
                        <p style="font-size:.83rem;color:var(--text-muted)">Sin vacunaciones registradas.</p>
                    @endforelse
                </div>
            </div>

            <div class="card" style="margin-bottom:1rem">
                <div class="card-header">Procedimientos</div>
                <div class="card-body">
                    @forelse($animal->procedimientos as $proc)
                        <div style="padding:.5rem 0;border-bottom:1px solid var(--border);font-size:.83rem">
                            <div style="display:flex;justify-content:space-between">
                                <strong>{{ $proc->tipoProcedimiento->nombre }}</strong>
                                <span>{{ $proc->fecha->format('d/m/Y') }}</span>
                            </div>
                            @if($proc->descripcion)
                                <div style="font-size:.75rem;color:var(--text-muted)">{{ Str::limit($proc->descripcion, 80) }}</div>
                            @endif
                        </div>
                    @empty
                        <p style="font-size:.83rem;color:var(--text-muted)">Sin procedimientos registrados.</p>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <div class="card-header">Historial</div>
                <div class="card-body" style="max-height:250px;overflow-y:auto">
                    @forelse($animal->historial as $h)
                        <div style="padding:.4rem 0;border-bottom:1px solid var(--border);font-size:.8rem">
                            <span class="badge badge-info" style="font-size:.65rem">{{ $h->tipo_cambio }}</span>
                            {{ $h->descripcion ?? '—' }}
                            <span style="color:var(--text-muted);font-size:.7rem">{{ $h->created_at?->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p style="font-size:.83rem;color:var(--text-muted)">Sin historial.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
