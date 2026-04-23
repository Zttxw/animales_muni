<x-layouts.guest title="Iniciar Sesión">
    <div class="auth-card">
        <h2 style="font-size:1.15rem;font-weight:600;margin-bottom:1.5rem;text-align:center;">Iniciar Sesión</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" class="form-control"
                       value="{{ old('correo') }}" required autofocus placeholder="tu@correo.com">
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" class="form-control"
                       required placeholder="••••••••">
            </div>

            <div class="remember-row">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Recordarme</label>
            </div>

            <button type="submit" class="btn-primary">Ingresar</button>
        </form>
    </div>

    <div class="auth-footer">
        ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
    </div>
</x-layouts.guest>
