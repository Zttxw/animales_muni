<x-layouts.app header="Campañas">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
        <form method="GET" style="display:flex;gap:.5rem">
            <select name="estado" class="form-control" style="width:180px" onchange="this.form.submit()">
                <option value="">Todos los estados</option>
                @foreach(['BORRADOR','PUBLICADA','EN_CURSO','FINALIZADA','CANCELADA'] as $e)
                    <option value="{{ $e }}" {{ request('estado')===$e?'selected':'' }}>{{ $e }}</option>
                @endforeach
            </select>
        </form>
        <a href="{{ route('admin.campanas.create') }}" class="btn btn-primary">+ Nueva Campaña</a>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead><tr><th>Título</th><th>Tipo</th><th>Fecha</th><th>Lugar</th><th>Inscritos</th><th>Estado</th><th>Acciones</th></tr></thead>
                <tbody>
                    @forelse($campanas as $c)
                        <tr>
                            <td><strong>{{ $c->titulo }}</strong></td>
                            <td>{{ $c->tipoCampana->nombre }}</td>
                            <td>{{ $c->fecha->format('d/m/Y') }}</td>
                            <td>{{ $c->lugar ?? '—' }}</td>
                            <td>{{ $c->participaciones_count }}{{ $c->capacidad ? '/'.$c->capacidad : '' }}</td>
                            <td><span class="badge badge-{{ in_array($c->estado,['PUBLICADA','EN_CURSO'])?'success':($c->estado==='CANCELADA'?'danger':'gray') }}">{{ $c->estado }}</span></td>
                            <td style="display:flex;gap:.35rem">
                                <a href="{{ route('admin.campanas.show', $c) }}" class="btn btn-outline btn-sm">Ver</a>
                                <a href="{{ route('admin.campanas.edit', $c) }}" class="btn btn-outline btn-sm">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" style="text-align:center;color:var(--text-muted)">No hay campañas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="pagination">{{ $campanas->withQueryString()->links() }}</div>
</x-layouts.app>
