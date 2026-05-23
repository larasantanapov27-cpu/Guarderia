@extends("layouts.template")

@section("content")
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="bubble-blue rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                <i class="fa-solid fa-school fa-lg"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Lista de Centros</h4>
                <p class="text-muted small mb-0">Administración de planteles y costos mensuales base asignados</p>
            </div>
        </div>
        <a href="{{ url('centros/create') }}" class="btn btn-success rounded-3 px-3 shadow-sm fw-semibold btn-sm" style="background-color: #10b981; border: none; padding: 10px 16px;">
            <i class="fa-solid fa-plus me-1"></i> Registrar Centro
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 fw-bold small text-success bg-success bg-opacity-10 py-3">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 bg-white">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle" style="border-color: #f4f7fc;">
                    <thead>
                        <tr class="text-muted small uppercase" style="font-size: 11px; letter-spacing: 0.8px;">
                            <th class="ps-3" style="width: 80px;">No.</th>
                            <th>Nombre del Plantel</th>
                            <th>Costo Mensual Base</th>
                            <th class="text-end pe-3" style="width: 180px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($centros as $centro)
                            <tr style="transition: all 0.2s;">
                                <td class="ps-3 fw-bold text-secondary" style="font-size: 14px;">
                                    #{{ $loop->index + 1 }}
                                </td>

                                <td class="text-dark fw-bold" style="font-size: 14px; letter-spacing: -0.3px;">
                                    {{ $centro->nom }}
                                </td>

                                <td>
                                    <span class="badge bubble-green rounded-pill px-3 py-2 fw-bold" style="font-size: 13px; border: 1px solid rgba(16, 185, 129, 0.1);">
                                        ${{ number_format($centro->costo, 2) }}
                                    </span>
                                </td>

                                <td class="text-end pe-3">
                                    <div class="d-flex gap-2 justify-content-end align-items-center">
                                        <a href="{{ route('centros.edit', $centro) }}" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-secondary" style="background-color: #f4f7fc; padding: 6px 12px; font-size: 12px;" title="Editar Plantel">
                                            <i class="fa-solid fa-pen-to-square me-1 text-warning"></i> Editar
                                        </a>

                                        <form action="{{ route('centros.destroy', $centro) }}" method="post" class="d-inline form-eliminar-centro m-0">
                                            @csrf
                                            @method('DELETE')
                                            {{-- Nota: Dependiendo de tu SQL la PK puede ser id_centro, la pasamos completa en el dataset --}}
                                            <button type="submit" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-danger btn-trigger-delete" style="background-color: #ffeef4; padding: 6px 12px; font-size: 12px;" data-nombre="{{ $centro->nom }}">
                                                <i class="fa-solid fa-trash-can me-1"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center p-5">
                                    <div class="text-muted mb-3"><i class="fa-solid fa-school-flag fa-3x opacity-20"></i></div>
                                    <span class="text-muted fw-medium">No se han registrado planteles o centros escolares actualmente.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.form-eliminar-centro').forEach(function(formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault(); // Pausar submit nativo

            // Capturar el nombre dinámico del plantel
            const botonInterno = this.querySelector('.btn-trigger-delete');
            const nombreCentro = botonInterno.getAttribute('data-nombre');

            // Configuramos los botones basándonos en tus clases estables
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                    cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
                },
                buttonsStyling: false
            });

            // Disparar advertencia premium con tus botones
            swalWithBootstrapButtons.fire({
                title: "¿Eliminar centro escolar?",
                text: `Estás a punto de borrar el plantel "${nombreCentro}". Al hacerlo, los niños vinculados a este centro podrían quedar sin plantel asignado.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar centro",
                cancelButtonText: "No, conservar",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    formulario.submit(); // Submit real si pasa el filtro del administrador
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Acción Cancelada",
                        text: "El plantel se mantiene activo y sin modificaciones en la base de datos.",
                        icon: "error",
                        confirmButtonText: "Entendido"
                    });
                }
            });
        });
    });
</script>
@endsection