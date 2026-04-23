<x-layouts.app header="Crear Usuario">
    <div class="card" style="max-width:600px">
        <div class="card-header">Nuevo Usuario</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.usuarios.store') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label>Nombres *</label>
                        <input type="text" name="nombres" class="form-control" value="{{ old('nombres') }}" required>
                        @error('nombres') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label>Apellidos *</label>
                        <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos') }}" required>
                        @error('apellidos') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>DNI *</label>
                        <input type="text" name="documento_identidad" class="form-control" value="{{ old('documento_identidad') }}" required>
                        @error('documento_identidad') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>Correo *</label>
                    <input type="email" name="correo" class="form-control" value="{{ old('correo') }}" required>
                    @error('correo') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Contraseña *</label>
                        <input type="password" name="password" class="form-control" required>
                        @error('password') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label>Rol *</label>
                        <select name="rol" class="form-control" required>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div style="display:flex;gap:.75rem;margin-top:1rem">
                    <button type="submit" class="btn btn-primary">Crear Usuario</button>
                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
