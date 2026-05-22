<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Guardería - Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
        }

        /* sidebar */
        .sidebar {
            width: 220px;
            min-height: 100vh;
            background-color: #212529;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar .nav-link {
            color: #adb5bd;
            padding: 8px 16px;
            font-size: 14px;
        }

        .sidebar .nav-link:hover {
            color: #ffffff;
            background-color: #343a40;
        }

        .sidebar .nav-link.active {
            color: #ffffff;
            background-color: #0d6efd;
        }

        .sidebar-label {
            color: #6c757d;
            font-size: 11px;
            text-transform: uppercase;
            padding: 12px 16px 4px 16px;
            letter-spacing: 1px;
        }

        /* contenido principal */
        .main-content {
            margin-left: 220px;
        }

        /* navbar superior */
        .top-navbar {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
            padding: 10px 20px;
        }

        /* tarjetas de centros */
        .centro-card {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 16px;
        }

        .centro-card .titulo {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .badge-activo {
            background-color: #198754;
            color: white;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 4px;
        }

        .numero-grande {
            font-size: 28px;
            font-weight: bold;
            color: #212529;
        }

        .numero-dinero {
            font-size: 28px;
            font-weight: bold;
            color: #0d6efd;
        }

        .etiqueta {
            font-size: 12px;
            color: #6c757d;
        }

        /* tarjetas de estadisticas arriba */
        .stat-box {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 16px;
            text-align: center;
        }

        .stat-box .numero {
            font-size: 32px;
            font-weight: bold;
        }

        .stat-box .label {
            font-size: 13px;
            color: #6c757d;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar d-flex flex-column">

        <div class="p-3 border-bottom border-secondary">
            <h5 class="text-white mb-0">🏠 Guardería</h5>
            <small class="text-muted">Panel administrativo</small>
        </div>

        <div class="mt-2">
            <div class="sidebar-label">Principal</div>
            <a href="{{ route('vista_rapida.index') }}" class="nav-link active">
                📊 Inicio
            </a>

            <div class="sidebar-label">Administración</div>
            <a href="{{ route('abonos.index') }}" class="nav-link">💰 Abonos</a>
            <a href="{{ route('registro_cuentas.index') }}" class="nav-link">📋 Registro Cuentas</a>
            <a href="{{ route('centros.index') }}" class="nav-link">🏫 Centros</a>

            <div class="sidebar-label">Niños y Familias</div>
            <a href="{{ route('ninios.index') }}" class="nav-link">👦 Niños</a>
            <a href="{{ route('baja_ninios.index') }}" class="nav-link">📝 Baja Niños</a>
            <a href="{{ route('familiares.index') }}" class="nav-link">👪 Familiares</a>
            <a href="{{ route('personas.index') }}" class="nav-link">👤 Personas</a>
            <a href="{{ route('parentezcos.index') }}" class="nav-link">🔗 Parentescos</a>

            <div class="sidebar-label">Nutrición</div>
            <a href="{{ route('menus.index') }}" class="nav-link">📅 Menús</a>
            <a href="{{ route('platos.index') }}" class="nav-link">🍽️ Platos</a>
            <a href="{{ route('ingredientes.index') }}" class="nav-link">🥕 Ingredientes</a>
            <a href="{{ route('alergias.index') }}" class="nav-link">⚠️ Alergias</a>
            <a href="{{ route('registro_comidas.index') }}" class="nav-link">📒 Registro Comidas</a>
        </div>

        <div class="mt-auto p-3 border-top border-secondary">
            <small class="text-muted">Sistema Guardería v1.0</small>
        </div>

    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="main-content">

        <!-- NAVBAR SUPERIOR -->
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Panel de control</h5>
                <small class="text-muted">Sistema de gestión de guardería</small>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <input type="text" class="form-control form-control-sm" placeholder="Buscar..." style="width: 200px;">
                <button class="btn btn-primary btn-sm">Buscar</button>
                <span class="text-muted">|</span>
                <span>Gabriel ▼</span>
            </div>
        </div>

        <!-- PAGINA -->
        <div class="p-4">
            @yield('content')
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>