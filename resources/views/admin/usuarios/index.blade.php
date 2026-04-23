<x-layouts.app header="Gestión de Usuarios">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
        <form method="GET" style="display:flex;gap:.5rem">
            <input type="text" name="buscar" class="form-control" placeholder="Buscar..." value="{{ request('buscar') }}" style="width:250px">
            <select name="estado" class="form-control" style="width:150px" onchange="this.form.submit()">
                <option value="">Todos</option>
                <option value="ACTIVO" {{ request('estado')==='ACTIVO'?'selected':'' }}>Activo</option>
                <option value="SUSPENDIDO" {{ request('estado')==='SUSPENDIDO'?'selected':'' }}>Suspendido</option>
                <option value="INACTIVO" {{ request('estado')==='INACTIVO'?'selected':'' }}>Inactivo</option>
            </select>
            <button type="submit" class="btn btn-outline btn-sm">Filtrar</button>
        </form>
        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">+ Nuevo Usuario</a>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th><th>DNI</th><th>Correo</th><th>Rol</th><th>Estado</th><th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $u)
                        <tr>
                            <td><strong>{{ $u->nombres }} {{ $u->apellidos }}</strong></td>
                            <td>{{ $u->documento_identidad }}</td>
                            <td>{{ $u->correo }}</td>
                            <td><span class="badge badge-purple">{{ $u->getRoleNames()->first() ?? '—' }}</span></td>
                            <td>
                                <span class="badge badge-{{ $u->estado==='ACTIVO'?'success':($u->estado==='SUSPENDIDO'?'warning':'gray') }}">{{ $u->estado }}</span>
                            </td>
                            <td style="display:flex;gap:.35rem">
                                <a href="{{ route('admin.usuarios.edit', $u) }}" class="btn btn-outline btn-sm">Editar</a>
                                @if($u->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.usuarios.destroy', $u) }}" onsubmit="return confirm('¿Desactivar este usuario?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Desactivar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center;color:var(--text-muted)">No se encontraron usuarios.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="pagination">{{ $usuarios->withQueryString()->links() }}</div>
</x-layouts.app>
