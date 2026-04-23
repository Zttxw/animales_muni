<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SIRACOM' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary: #2563eb; --primary-dark: #1d4ed8;
            --bg: #0f172a; --surface: #1e293b;
            --text: #f8fafc; --text-muted: #94a3b8; --border: #334155;
        }
        body {
            font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text);
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            background-image: radial-gradient(ellipse at top, #1e3a5f 0%, #0f172a 60%);
        }
        .auth-container { width: 100%; max-width: 420px; padding: 1.5rem; }
        .auth-header { text-align: center; margin-bottom: 2rem; }
        .auth-header .logo { font-size: 3rem; margin-bottom: .5rem; }
        .auth-header h1 { font-size: 1.4rem; font-weight: 700; }
        .auth-header p { font-size: .85rem; color: var(--text-muted); margin-top: .5rem; }
        .auth-card {
            background: var(--surface); border-radius: 12px; padding: 2rem;
            border: 1px solid var(--border);
            box-shadow: 0 25px 50px -12px rgba(0,0,0,.5);
        }
        .form-group { margin-bottom: 1.15rem; }
        .form-group label { display: block; font-size: .8rem; font-weight: 500; margin-bottom: .4rem; color: var(--text-muted); }
        .form-control {
            width: 100%; padding: .65rem .85rem; background: #0f172a; border: 1px solid var(--border);
            border-radius: 8px; color: var(--text); font-size: .85rem; font-family: inherit;
        }
        .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,.2); }
        .form-error { color: #f87171; font-size: .75rem; margin-top: .25rem; }
        .btn-primary {
            width: 100%; padding: .7rem; background: var(--primary); color: #fff;
            border: none; border-radius: 8px; font-size: .9rem; font-weight: 600;
            cursor: pointer; transition: background .15s;
        }
        .btn-primary:hover { background: var(--primary-dark); }
        .auth-footer { text-align: center; margin-top: 1.5rem; font-size: .8rem; color: var(--text-muted); }
        .auth-footer a { color: var(--primary); text-decoration: none; font-weight: 500; }
        .auth-footer a:hover { text-decoration: underline; }
        .remember-row { display: flex; align-items: center; gap: .5rem; margin-bottom: 1.25rem; }
        .remember-row input[type="checkbox"] { accent-color: var(--primary); }
        .remember-row label { font-size: .8rem; color: var(--text-muted); margin: 0; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        @media (max-width: 500px) { .form-row { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <div class="logo">🐾</div>
            <h1>SIRACOM</h1>
            <p>Sistema Municipal de Registro de Animales</p>
        </div>

        @if($errors->any())
            <div style="background:#451a1a;border:1px solid #7f1d1d;border-radius:8px;padding:.75rem 1rem;margin-bottom:1rem;font-size:.8rem;color:#fca5a5;">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{ $slot }}
    </div>
</body>
</html>
