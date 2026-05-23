@extends('layouts.template')

@section('content')
<div class="container-fluid">

    <!-- ENCABEZADO -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-muted mb-0">Resumen operativo y financiero de las estancias</p>
        </div>
        <a href="{{ url('/centros/create') }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
            <i class="fa-solid fa-plus me-1"></i> Nuevo Centro
        </a>
    </div>

    <!-- FILA DE TARJETAS INFORMATIVAS (KPIS) -->
    <div class="row g-3 mb-4">
        <!-- KPI: Centros Totales -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Estancias Activas</small>
                        <h3 class="fw-bold mb-0 mt-1 text-dark">{{ $centros->count() }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="fa-solid fa-school fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI: Niños Totales (Simulado o adaptado si tienes la variable global) -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Matrícula Total</small>
                        <h3 class="fw-bold mb-0 mt-1 text-dark">
                            {{ $centros->sum(function($c) { return $c->cantidad() ?? 0; }) }}
                        </h3>
                    </div>
                    <div class="bg-info bg-opacity-10 text-info rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="fa-solid fa-child fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI: Ingresos Globales -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Recaudación Global</small>
                        <h3 class="fw-bold mb-0 mt-1 text-success">
                            ${{ number_format($centros->sum(function($c) { return $c->sumaTotal() ?? 0; }), 2) }}
                        </h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="fa-solid fa-wallet fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI: Alertas Críticas (Placeholder elegante) -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Alertas de Hoy</small>
                        <h3 class="fw-bold mb-0 mt-1 text-danger">2 Activas</h3>
                    </div>
                    <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="fa-solid fa-triangle-exclamation fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECCIÓN DIVIDIDA: PRINCIPAL Y LATERAL -->
    <div class="row g-4">
        
        <!-- COLUMNA IZQUIERDA: RESUMEN DE CENTROS (75% / col-lg-8) -->
        <div class="col-12 col-lg-8">
            <div class="d-flex align-items-center mb-3">
                <h5 class="fw-bold mb-0 text-secondary"><i class="fa-solid fa-city me-2"></i>Monitoreo de Sedes</h5>
            </div>
            
            <div class="row g-3">
                @forelse($centros as $centro)
                    <div class="col-12 col-md-6">
                        <div class="card border-0 shadow-sm h-100 rounded-3">
                            <div class="card-body p-3">
                                
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-1 text-dark" style="font-size: 16px;">
                                            {{ $centro->nom }}
                                        </h6>
                                        <span class="badge bg-success-subtle text-success border border-success border-opacity-10 rounded-pill px-2" style="font-size: 10px;">
                                            <i class="fa-solid fa-circle fa-2xs me-1"></i> Operando
                                        </span>
                                    </div>
                                    <div class="text-muted bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        <i class="fa-solid fa-house-chimney-window"></i>
                                    </div>
                                </div>

                                <div class="row text-center bg-light rounded-3 g-0 p-2 mt-3">
                                    <div class="col-6 border-end border-secondary border-opacity-10">
                                        <span class="text-primary fw-bold d-block" style="font-size: 20px;">
                                            {{ $centro->cantidad() ?? 0 }}
                                        </span>
                                        <small class="text-muted" style="font-size: 11px;">Niños Inscritos</small>
                                    </div>

                                    <div class="col-6">
                                        <span class="text-success fw-bold d-block" style="font-size: 20px;">
                                            ${{ number_format($centro->sumaTotal() ?? 0, 2) }}
                                        </span>
                                        <small class="text-muted" style="font-size: 11px;">Total Abonos</small>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card border-0 shadow-sm text-center p-4">
                            <div class="text-muted mb-2"><i class="fa-solid fa-folder-open fa-2xl"></i></div>
                            <span class="text-muted">No hay estancias dadas de alta en la base de datos.</span>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- COLUMNA DERECHA: ALERTAS Y NUTRICIÓN (25% / col-lg-4) -->
        <div class="col-12 col-lg-4">
            
            <!-- PANEL 1: NUTRICIÓN DEL DÍA -->
            <div class="mb-4">
                <h5 class="fw-bold mb-3 text-secondary"><i class="fa-solid fa-utensils me-2"></i>Menú Escolar de Hoy</h5>
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center gap-2 pb-2 mb-3 border-bottom border-light">
                            <span class="badge bg-info text-white rounded-pill"><i class="fa-solid fa-calendar-day"></i> Hoy</span>
                            <span class="text-muted small fw-medium">Viernes de Nutrición</span>
                        </div>
                        
                        <div class="mb-2">
                            <strong class="text-dark d-block" style="font-size: 13px;"><i class="fa-solid fa-egg text-warning me-2"></i>Desayuno</strong>
                            <span class="text-muted small ps-4 d-block">Omelet de espinacas con pan integral</span>
                        </div>
                        
                        <div class="mb-2 mt-3">
                            <strong class="text-dark d-block" style="font-size: 13px;"><i class="fa-solid fa-bowl-rice text-danger me-2"></i>Comida</strong>
                            <span class="text-muted small ps-4 d-block">Crema de zanahoria y pechuga asada</span>
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('menus.index') }}" class="btn btn-light btn-sm w-100 rounded-pill border fw-medium text-secondary">
                                Ver programación semanal
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANEL 2: ALERTAS CRÍTICAS -->
            <div>
                <h5 class="fw-bold mb-3 text-secondary"><i class="fa-solid fa-shield-halved me-2"></i>Alertas Médicas</h5>
                <div class="card border-0 shadow-sm rounded-3 bg-danger bg-opacity-10 border border-danger border-opacity-10">
                    <div class="card-body p-3">
                        <div class="d-flex gap-2 align-items-start mb-3">
                            <i class="fa-solid fa-triangle-exclamation text-danger mt-1"></i>
                            <div>
                                <strong class="text-danger d-block" style="font-size: 14px;">Restricciones Alimentarias</strong>
                                <small class="text-muted">Evitar estos ingredientes en el comedor hoy:</small>
                            </div>
                        </div>

                        <div class="bg-white rounded-3 p-2 mb-2 shadow-sm border-start border-danger border-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold text-dark small">Mateo Pérez</span>
                                <span class="badge bg-danger-subtle text-danger" style="font-size: 10px;">Lactosa</span>
                            </div>
                        </div>

                        <div class="bg-white rounded-3 p-2 shadow-sm border-start border-danger border-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold text-dark small">Sofía Lara</span>
                                <span class="badge bg-danger-subtle text-danger" style="font-size: 10px;">Zanahoria</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection