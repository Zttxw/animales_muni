<x-layouts.app header="Especies y Razas">
    <div class="grid-2">
        {{-- Lista de especies --}}
        <div class="card">
            <div class="card-header">Especies</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.especies.store') }}" style="display:flex;gap:.5rem;margin-bottom:1rem">
                    @csrf
                    <input type="text" name="nombre" class="form-control" placeholder="Nueva especie..." required>
                    <button class="btn btn-primary btn-sm">Agregar</button>
                </form>

                @foreach($especies as $esp)
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:.5rem 0;border-bottom:1px solid var(--border)">
                        <div>
                            <strong style="font-size:.85rem">{{ $esp->nombre }}</strong>
                            <span style="font-size:.75rem;color:var(--text-muted);margin-left:.5rem">{{ $esp->razas_count }} razas · {{ $esp->animales_count }} animales</span>
                        </div>
                        <div style="display:flex;gap:.35rem">
                            <a href="{{ route('admin.especies.razas', $esp) }}" class="btn btn-outline btn-sm">Razas</a>
                            <form method="POST" action="{{ route('admin.especies.update', $esp) }}" style="display:inline">
                                @csrf @method('PUT')
                                <input type="hidden" name="nombre" value="{{ $esp->nombre }}">
                                <input type="hidden" name="activo" value="{{ $esp->activo ? 0 : 1 }}">
                                <button class="btn btn-sm {{ $esp->activo ? 'btn-outline' : 'btn-success' }}">
                                    {{ $esp->activo ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Info --}}
        <div class="card">
            <div class="card-header">ℹ️ Información</div>
            <div class="card-body" style="font-size:.85rem;color:var(--text-muted)">
                <p>Las especies y razas son catálogos base del sistema.</p>
                <ul style="margin-top:.75rem;padding-left:1.25rem;line-height:1.8">
                    <li>Cada especie puede tener múltiples razas.</li>
                    <li>Al desactivar una especie, no aparecerá en los formularios de registro.</li>
                    <li>Los animales ya registrados no se ven afectados.</li>
                </ul>
            </div>
        </div>
    </div>
</x-layouts.app>
