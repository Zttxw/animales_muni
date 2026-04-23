<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SIRACOM' }} — Sistema Municipal de Registro Animal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary: #2563eb; --primary-dark: #1d4ed8; --primary-light: #dbeafe;
            --accent: #10b981; --accent-dark: #059669;
            --danger: #ef4444; --warning: #f59e0b; --info: #3b82f6;
            --bg: #f1f5f9; --surface: #ffffff; --sidebar: #0f172a;
            --text: #1e293b; --text-muted: #64748b; --border: #e2e8f0;
            --radius: 8px; --shadow: 0 1px 3px rgba(0,0,0,.1), 0 1px 2px rgba(0,0,0,.06);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,.1), 0 4px 6px -2px rgba(0,0,0,.05);
        }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; display: flex; }

        /* ── Sidebar ───────────────────────────────── */
        .sidebar {
            width: 260px; background: var(--sidebar); color: #cbd5e1;
            display: flex; flex-direction: column; position: fixed;
            top: 0; left: 0; bottom: 0; z-index: 40;
            transition: transform .3s ease;
        }
        .sidebar-header {
            padding: 1.25rem 1rem; border-bottom: 1px solid rgba(255,255,255,.1);
            display: flex; align-items: center; gap: .75rem;
        }
        .sidebar-header .logo { font-size: 1.5rem; }
        .sidebar-header h1 { font-size: .95rem; font-weight: 700; color: #f8fafc; line-height: 1.2; }
        .sidebar-header small { font-size: .7rem; color: #94a3b8; }

        .sidebar-nav { flex: 1; padding: .75rem 0; overflow-y: auto; }
        .nav-section { padding: .5rem 1rem; font-size: .65rem; text-transform: uppercase; letter-spacing: .08em; color: #475569; font-weight: 600; margin-top: .5rem; }
        .nav-link {
            display: flex; align-items: center; gap: .75rem;
            padding: .6rem 1rem; color: #94a3b8; text-decoration: none;
            font-size: .85rem; border-left: 3px solid transparent;
            transition: all .15s ease;
        }
        .nav-link:hover { color: #e2e8f0; background: rgba(255,255,255,.05); }
        .nav-link.active { color: #fff; background: rgba(37,99,235,.2); border-left-color: var(--primary); }
        .nav-link .icon { font-size: 1.1rem; width: 1.5rem; text-align: center; }

        .sidebar-footer { padding: 1rem; border-top: 1px solid rgba(255,255,255,.1); }
        .user-info { display: flex; align-items: center; gap: .6rem; }
        .user-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: var(--primary); color: #fff; display: flex;
            align-items: center; justify-content: center; font-weight: 600; font-size: .8rem;
        }
        .user-info .name { font-size: .8rem; color: #e2e8f0; font-weight: 500; }
        .user-info .role { font-size: .65rem; color: #64748b; }

        /* ── Main ──────────────────────────────────── */
        .main { margin-left: 260px; flex: 1; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar {
            background: var(--surface); border-bottom: 1px solid var(--border);
            padding: .75rem 1.5rem; display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 30;
        }
        .topbar h2 { font-size: 1.1rem; font-weight: 600; }
        .content { padding: 1.5rem; flex: 1; }

        /* ── Cards ─────────────────────────────────── */
        .card {
            background: var(--surface); border-radius: var(--radius);
            box-shadow: var(--shadow); border: 1px solid var(--border);
        }
        .card-header { padding: 1rem 1.25rem; border-bottom: 1px solid var(--border); font-weight: 600; display: flex; align-items: center; justify-content: space-between; }
        .card-body { padding: 1.25rem; }

        /* ── Stats ─────────────────────────────────── */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .stat-card {
            background: var(--surface); border-radius: var(--radius); padding: 1.25rem;
            box-shadow: var(--shadow); border: 1px solid var(--border);
            display: flex; align-items: center; gap: 1rem;
        }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 1.4rem;
        }
        .stat-icon.blue { background: #dbeafe; }
        .stat-icon.green { background: #d1fae5; }
        .stat-icon.amber { background: #fef3c7; }
        .stat-icon.red { background: #fee2e2; }
        .stat-icon.purple { background: #ede9fe; }
        .stat-value { font-size: 1.5rem; font-weight: 700; line-height: 1; }
        .stat-label { font-size: .75rem; color: var(--text-muted); margin-top: .15rem; }

        /* ── Table ─────────────────────────────────── */
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: .85rem; }
        th { text-align: left; padding: .65rem .75rem; background: #f8fafc; color: var(--text-muted); font-weight: 600; font-size: .75rem; text-transform: uppercase; letter-spacing: .04em; border-bottom: 2px solid var(--border); }
        td { padding: .65rem .75rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
        tr:hover td { background: #f8fafc; }

        /* ── Buttons ───────────────────────────────── */
        .btn {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .5rem 1rem; border-radius: var(--radius); border: none;
            font-size: .85rem; font-weight: 500; cursor: pointer;
            text-decoration: none; transition: all .15s ease;
        }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-success { background: var(--accent); color: #fff; }
        .btn-success:hover { background: var(--accent-dark); }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-danger:hover { background: #dc2626; }
        .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text); }
        .btn-outline:hover { background: #f8fafc; }
        .btn-sm { padding: .35rem .75rem; font-size: .78rem; }

        /* ── Forms ─────────────────────────────────── */
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; font-size: .8rem; font-weight: 500; color: var(--text); margin-bottom: .35rem; }
        .form-control {
            width: 100%; padding: .55rem .75rem; border: 1px solid var(--border);
            border-radius: var(--radius); font-size: .85rem; font-family: inherit;
            transition: border-color .15s ease;
        }
        .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,.1); }
        select.form-control { appearance: none; background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10z'/%3E%3C/svg%3E") no-repeat right .75rem center; padding-right: 2rem; }
        textarea.form-control { resize: vertical; min-height: 80px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .form-error { color: var(--danger); font-size: .75rem; margin-top: .25rem; }

        /* ── Badge ─────────────────────────────────── */
        .badge {
            display: inline-block; padding: .2rem .6rem; border-radius: 999px;
            font-size: .7rem; font-weight: 600; text-transform: uppercase; letter-spacing: .03em;
        }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-info { background: #dbeafe; color: #1e40af; }
        .badge-purple { background: #ede9fe; color: #5b21b6; }
        .badge-gray { background: #f1f5f9; color: #475569; }

        /* ── Alert ─────────────────────────────────── */
        .alert {
            padding: .75rem 1rem; border-radius: var(--radius); margin-bottom: 1rem;
            font-size: .85rem; display: flex; align-items: center; gap: .5rem;
        }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-warning { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }

        /* ── Pagination ────────────────────────────── */
        .pagination { display: flex; gap: .25rem; justify-content: center; margin-top: 1.5rem; }
        .pagination a, .pagination span {
            padding: .4rem .75rem; border-radius: var(--radius); font-size: .8rem;
            border: 1px solid var(--border); text-decoration: none; color: var(--text);
        }
        .pagination span.current { background: var(--primary); color: #fff; border-color: var(--primary); }
        .pagination a:hover { background: #f8fafc; }

        /* ── Grid ──────────────────────────────────── */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }

        /* ── Animal Card ───────────────────────────── */
        .animal-card {
            background: var(--surface); border-radius: var(--radius); overflow: hidden;
            box-shadow: var(--shadow); border: 1px solid var(--border);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .animal-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }
        .animal-card-img {
            height: 160px; background: linear-gradient(135deg, #dbeafe 0%, #ede9fe 100%);
            display: flex; align-items: center; justify-content: center; font-size: 3rem;
        }
        .animal-card-body { padding: 1rem; }
        .animal-card-body h3 { font-size: .95rem; font-weight: 600; margin-bottom: .25rem; }
        .animal-card-body p { font-size: .78rem; color: var(--text-muted); }

        /* ── Empty State ───────────────────────────── */
        .empty-state { text-align: center; padding: 3rem 1rem; color: var(--text-muted); }
        .empty-state .icon { font-size: 3rem; margin-bottom: 1rem; }
        .empty-state h3 { font-size: 1.1rem; color: var(--text); margin-bottom: .5rem; }

        /* ── Responsive ────────────────────────────── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .form-row { grid-template-columns: 1fr; }
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <span class="logo">🐾</span>
            <div>
                <h1>SIRACOM</h1>
                <small>Municipalidad San Jerónimo</small>
            </div>
        </div>

        <nav class="sidebar-nav">
            @if(auth()->user()->hasRole('ADMIN'))
                <div class="nav-section">Administración</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="icon">📊</span> Dashboard
                </a>
                <a href="{{ route('admin.usuarios.index') }}" class="nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
                    <span class="icon">👥</span> Usuarios
                </a>
                <a href="{{ route('admin.especies.index') }}" class="nav-link {{ request()->routeIs('admin.especies.*') ? 'active' : '' }}">
                    <span class="icon">🐕</span> Especies y Razas
                </a>
                <a href="{{ route('admin.campanas.index') }}" class="nav-link {{ request()->routeIs('admin.campanas.*') ? 'active' : '' }}">
                    <span class="icon">📢</span> Campañas
                </a>
            @endif

            <div class="nav-section">Mi Cuenta</div>
            <a href="{{ route('ciudadano.dashboard') }}" class="nav-link {{ request()->routeIs('ciudadano.dashboard') ? 'active' : '' }}">
                <span class="icon">🏠</span> Mi Panel
            </a>
            <a href="{{ route('ciudadano.animales.index') }}" class="nav-link {{ request()->routeIs('ciudadano.animales.*') ? 'active' : '' }}">
                <span class="icon">🐾</span> Mis Animales
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->nombres, 0, 1)) }}</div>
                <div>
                    <div class="name">{{ auth()->user()->nombre_completo }}</div>
                    <div class="role">{{ auth()->user()->getRoleNames()->first() ?? 'CIUDADANO' }}</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main">
        <header class="topbar">
            <h2>{{ $header ?? 'Dashboard' }}</h2>
            <form action="{{ route('logout') }}" method="POST" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-outline btn-sm">Cerrar Sesión</button>
            </form>
        </header>

        <main class="content">
            @if(session('success'))
                <div class="alert alert-success">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">❌ {{ session('error') }}</div>
            @endif

            {{ $slot }}
        </main>
    </div>

    @stack('scripts')
</body>
</html>
