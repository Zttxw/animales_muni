<x-layouts.app header="Editar Usuario: {{ $usuario->nombre_completo }}">
    <div class="card" style="max-width:600px">
        <div class="card-header">Editar Usuario</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.usuarios.update', $usuario) }}">
                @csrf @method('PUT')
                <div class="form-row">
                    <div class="form-group">
                        <label>Nombres *</label>
                        <input type="text" name="nombres" class="form-control" value="{{ old('nombres', $usuario->nombres) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Apellidos *</label>
                        <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $usuario->apellidos) }}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>DNI *</label>
                        <input type="text" name="documento_identidad" class="form-control" value="{{ old('documento_identidad', $usuario->documento_identidad) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $usuario->telefono) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>Correo *</label>
                    <input type="email" name="correo" class="form-control" value="{{ old('correo', $usuario->correo) }}" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Nueva Contraseña (dejar vacío para mantener)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Rol *</label>
                        <select name="rol" class="form-control" required>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->name }}" {{ $usuario->hasRole($rol->name) ? 'selected' : '' }}>{{ $rol->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Estado *</label>
                    <select name="estado" class="form-control" required>
                        <option value="ACTIVO" {{ $usuario->estado==='ACTIVO'?'selected':'' }}>Activo</option>
                        <option value="SUSPENDIDO" {{ $usuario->estado==='SUSPENDIDO'?'selected':'' }}>Suspendido</option>
                        <option value="INACTIVO" {{ $usuario->estado==='INACTIVO'?'selected':'' }}>Inactivo</option>
                    </select>
                </div>
                <div style="display:flex;gap:.75rem;margin-top:1rem">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
