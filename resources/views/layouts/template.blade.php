<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Guardería - KiddoSpace</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #f0f4fa;
            color: #3d4b6c;
        }

        /* SIDEBAR ESTILO PREMIUM */
        .sidebar {
            width: 270px;
            min-height: 100vh;
            background-color: #2e5bff;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            box-shadow: 4px 0 24px rgba(46, 91, 255, 0.15);
        }

        .sidebar-brand {
            padding: 24px 20px;
            background-color: rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* ENLACES DEL MENÚ ESTILO CÁPSULA */
        .sidebar .nav-link {
            color: #ffffff;
            opacity: 0.85;
            padding: 10px 16px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            border-radius: 14px;
            margin: 6px 15px;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link i.icon-container {
            width: 32px;
            height: 32px;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #ffffff;
            transition: all 0.2s;
        }

        /* Colores pastel de las burbujas del menú */
        .icon-blue   { background-color: rgba(255, 255, 255, 0.2); }
        .icon-pink   { background-color: #ff5c93; }
        .icon-orange { background-color: #ff7a32; }
        .icon-green  { background-color: #10b981; }
        .icon-purple { background-color: #8b5cf6; }

        .sidebar .nav-link:hover {
            opacity: 1;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(2px);
        }

        .sidebar .nav-link.active {
            color: #2e5bff !important;
            background-color: #ffffff !important;
            opacity: 1;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.06);
        }
        
        .sidebar .nav-link.active i.icon-container {
            background-color: #2e5bff !important;
            color: #ffffff !important;
        }

        .sidebar-label {
            color: #8fa7ff;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 16px 20px 2px 25px;
            letter-spacing: 0.8px;
        }

        .submenu {
            background-color: rgba(0, 0, 0, 0.08);
            border-radius: 14px;
            margin: 2px 15px;
            padding: 4px 0;
        }

        .submenu .nav-link {
            padding-left: 18px;
            font-size: 13px;
            color: #e2e8f0;
            opacity: 0.9;
            margin: 2px 10px;
        }

        /* CONTENIDO PRINCIPAL */
        .main-content {
            margin-left: 270px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .top-navbar {
            background-color: #ffffff;
            padding: 15px 30px;
            border-bottom: 1px solid #e1e8f5;
        }

        /* CLASES DE BURBUJAS PARA LAS TARJETAS */
        .bubble-blue   { background-color: #e8eeff; color: #2e5bff; }
        .bubble-pink   { background-color: #ffeef4; color: #ff5c93; }
        .bubble-orange { background-color: #fff3ec; color: #ff7a32; }
        .bubble-green  { background-color: #e6f9f0; color: #10b981; }
        .bubble-purple { background-color: #f3ebff; color: #8b5cf6; }
    </style>
</head>
<body>

    <div class="sidebar d-flex flex-column">

        <div class="sidebar-brand text-center text-md-start">
            <h4 class="text-white mb-0 d-flex align-items-center justify-content-center justify-content-md-start gap-2 fw-bold">
                <i class="fa-solid fa-shapes"></i> KiddoSpace
            </h4>
            <small class="text-white-50 fw-medium" style="font-size: 11px; letter-spacing: 0.5px;">Panel de Control</small>
        </div>

        <div class="mt-2 flex-grow-1 overflow-y-auto" style="max-height: calc(100vh - 120px);">
            <div class="sidebar-label">Resumen</div>
            <a href="{{ route('vista_rapida.index') }}" class="nav-link active">
                <i class="fa-solid fa-chart-simple icon-container icon-blue"></i> Inicio
            </a>

            <div class="sidebar-label">Finanzas</div>
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#menuAdmin" aria-expanded="false">
                <i class="fa-solid fa-wallet icon-container icon-pink"></i> Operaciones
            </a>
            <div class="collapse submenu" id="menuAdmin">
                <a href="{{ route('abonos.index') }}" class="nav-link"><i class="fa-solid fa-money-bill-wave me-2"></i> Abonos</a>
                <a href="{{ route('registro_cuentas.index') }}" class="nav-link"><i class="fa-solid fa-file-invoice-dollar me-2"></i> Cuentas</a>
                <a href="{{ route('centros.index') }}" class="nav-link"><i class="fa-solid fa-school me-2"></i> Centros</a>
            </div>

            <div class="sidebar-label">Alumnos</div>
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#menuFamilias" aria-expanded="false">
                <i class="fa-solid fa-children icon-container icon-green"></i> Control Escolar
            </a>
            <div class="collapse submenu" id="menuFamilias">
                <a href="{{ route('ninios.index') }}" class="nav-link"><i class="fa-solid fa-child me-2"></i> Niños</a>
                <a href="{{ route('baja_ninios.index') }}" class="nav-link"><i class="fa-solid fa-user-minus"></i> Bajas</a>
                <a href="{{ route('familiares.index') }}" class="nav-link"><i class="fa-solid fa-users me-2"></i> Familiares</a>
                <a href="{{ route('personas.index') }}" class="nav-link"><i class="fa-solid fa-id-card me-2"></i> Personas</a>
                <a href="{{ route('parentezcos.index') }}" class="nav-link"><i class="fa-solid fa-people-arrows me-2"></i> Parentescos</a>
            </div>

            <div class="sidebar-label">Comedor</div>
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#menuNutricion" aria-expanded="false">
                <i class="fa-solid fa-apple-whole icon-container icon-orange"></i> Alimentación
            </a>
            <div class="collapse submenu" id="menuNutricion">
                <a href="{{ route('menus.index') }}" class="nav-link"><i class="fa-solid fa-calendar-days"></i> Menús</a>
                <a href="{{ route('platos.index') }}" class="nav-link"><i class="fa-solid fa-utensils me-2"></i> Platos</a>
                <a href="{{ route('ingredientes.index') }}" class="nav-link"><i class="fa-solid fa-carrot me-2"></i> Ingredientes</a>
                <a href="{{ route('alergias.index') }}" class="nav-link"><i class="fa-solid fa-triangle-exclamation me-2"></i> Alergias</a>
                <a href="{{ route('registro_comidas.index') }}" class="nav-link"><i class="fa-solid fa-book me-2"></i> Bitácora</a>
            </div>
        </div>

        <div class="p-3 text-center bg-black bg-opacity-10">
            <small class="text-white-50" style="font-size: 11px; font-weight: 600;">KiddoSpace v2.5 🌟</small>
        </div>
    </div>

    <div class="main-content">

        <div class="top-navbar d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold mb-0 text-dark" style="letter-spacing: -0.5px;">Panel de Control</h5>
                <small class="text-muted fw-medium" style="font-size: 12px;">¡Hola de nuevo, {{ explode(' ', Auth::user()->name ?? 'Usuario')[0] }}! ✨</small>
            </div>
            
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <a href="#" class="text-decoration-none text-dark fw-bold dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-primary" style="width: 36px; height: 36px; font-size: 13px; background-color: #e8eeff;">
                            @php
                                $name = Auth::user()->name ?? 'Admin';
                                $words = explode(' ', $name);
                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                            @endphp
                            {{ $initials }}
                        </div>
                        <span class="d-none d-md-inline" style="font-size: 13px; color: #475569;">
                            {{ Auth::user()->name ?? 'Administrador' }}
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2 rounded-3" style="font-size: 14px;">
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger py-2 fw-medium" href="#" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Salir
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="p-4 flex-grow-1">
            @yield('content')
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>