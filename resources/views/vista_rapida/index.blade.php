@extends('layouts.template')

@section('content')

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Centros</h2>
                <p class="text-muted mb-0">
                    Resumen general de centros registrados en el sistema
                </p>
            </div>

            <a href="{{ url('/centros/create') }}" class="btn btn-primary">
                + Nuevo centro
            </a>
        </div>

        <div class="row g-4">
            @forelse($centros as $centro)
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card border-0 shadow-sm h-100 centro-card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="fw-bold mb-1">
                                        {{ $centro->nom }}
                                    </h5>
                                    <span class="badge bg-primary-subtle text-primary">
                                    Centro activo
                                </span>
                                </div>

                                <div class="centro-icon">
                                    🏫
                                </div>
                            </div>

                            <div class="row text-center mt-4">
                                <div class="col-6 border-end">
                                    <h4 class="fw-bold text-primary mb-0">
                                        {{ $centro->cantidad() ?? 0 }}
                                    </h4>
                                    <small class="text-muted">Cantidad</small>
                                </div>

                                <div class="col-6">
                                    <h4 class="fw-bold text-success mb-0">
                                        ${{ number_format($centro->sumaTotal() ?? 0, 2) }}
                                    </h4>
                                    <small class="text-muted">Suma total</small>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info mb-0">
                        No hay centros registrados actualmente.
                    </div>
                </div>
            @endforelse
        </div>

    </div>



@endsection