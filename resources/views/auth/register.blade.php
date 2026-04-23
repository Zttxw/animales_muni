<x-layouts.guest title="Registro">
    <div class="auth-card">
        <h2 style="font-size:1.15rem;font-weight:600;margin-bottom:1.5rem;text-align:center;">Crear Cuenta</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label for="nombres">Nombres</label>
                    <input type="text" id="nombres" name="nombres" class="form-control"
                           value="{{ old('nombres') }}" required>
                    @error('nombres') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos" class="form-control"
                           value="{{ old('apellidos') }}" required>
                    @error('apellidos') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="documento_identidad">DNI / Documento</label>
                <input type="text" id="documento_identidad" name="documento_identidad" class="form-control"
                       value="{{ old('documento_identidad') }}" required maxlength="20">
                @error('documento_identidad') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono (opcional)</label>
                <input type="text" id="telefono" name="telefono" class="form-control"
                       value="{{ old('telefono') }}">
            </div>

            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" class="form-control"
                       value="{{ old('correo') }}" required>
                @error('correo') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    @error('password') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirmar</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>
            </div>

            <button type="submit" class="btn-primary" style="margin-top:.5rem">Registrarme</button>
        </form>
    </div>

    <div class="auth-footer">
        ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
    </div>
</x-layouts.guest>
