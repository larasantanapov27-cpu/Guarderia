@extends("layouts.template")

@section("content")
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="bubble-pink rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                <i class="fa-solid fa-user-minus fa-lg"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Historial de Bajas de Niños</h4>
                <p class="text-muted small mb-0">Bitácora y registro de los alumnos desincorporados de la guardería</p>
            </div>
        </div>
        <a href="{{ route('baja_ninios.create') }}" class="btn btn-danger rounded-3 px-3 shadow-sm fw-semibold btn-sm" style="background-color: #dc3545; border: 1px solid #dc3545; padding: 10px 16px;">
    <i class="fas fa-user-minus"></i> Registrar Nueva Baja
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
                            <th class="ps-3" style="width: 80px;">Reg ID</th>
                            <th>Matrícula</th>
                            <th>Nombre del Niño</th>
                            <th>Fecha de Baja</th>
                            <th>Motivo / Razón</th>
                            <th class="text-end pe-3" style="width: 180px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bajas as $baja)
                            <tr style="transition: all 0.2s;">
                                <td class="ps-3 fw-bold text-secondary" style="font-size: 14px;">
                                    #{{ $baja->id_baja }}
                                </td>

                                <td>
                                    <span class="badge bubble-blue rounded-pill px-3 py-2 fw-bold" style="font-size: 12px; border: 1px solid rgba(46, 91, 255, 0.1);">
                                        {{ $baja->matricula }}
                                    </span>
                                </td>

                                <td class="text-dark fw-bold" style="font-size: 14px; letter-spacing: -0.3px;">
                                    {{ $baja->nom }} {{ $baja->ap }} {{ $baja->am }}
                                </td>

                                <td>
                                    <span class="badge bubble-orange rounded-pill px-2.5 py-2 fw-semibold" style="font-size: 13px; border: 1px solid rgba(255, 122, 50, 0.1);">
                                        <i class="fa-regular fa-calendar-times me-1.5 opacity-75"></i>{{ $baja->fecha }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bubble-purple rounded-pill px-3 py-2 fw-medium text-wrap text-start" style="font-size: 13px; max-width: 250px; line-height: 1.4;">
                                        {{ $baja->motivo }}
                                    </span>
                                </td>

                                <td class="text-end pe-3">
                                    <div class="d-flex gap-2 justify-content-end align-items-center">
                                        <a href="{{ route('baja_ninios.edit', $baja->id_baja) }}" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-secondary" style="background-color: #f4f7fc; padding: 6px 12px; font-size: 12px;" title="Editar Registro">
                                            <i class="fa-solid fa-pen-to-square me-1 text-warning"></i> Editar
                                        </a>

                                        <form action="{{ route('baja_ninios.destroy', $baja->id_baja) }}" method="POST" class="d-inline form-eliminar-baja m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-danger btn-trigger-delete" style="background-color: #ffeef4; padding: 6px 12px; font-size: 12px;" data-alumno="{{ $baja->nom }} {{ $baja->ap }}">
                                                <i class="fa-solid fa-trash-can me-1"></i> Borrar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-5">
                                    <div class="text-muted mb-3"><i class="fa-solid fa-user-slash fa-3x opacity-20"></i></div>
                                    <span class="text-muted fw-medium">No se han encontrado registros de bajas históricas en el sistema.</span>
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
    document.querySelectorAll('.form-eliminar-baja').forEach(function(formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault(); // Detener envío inmediato automático

            // Capturar metadatos del botón interno
            const botonInterno = this.querySelector('.btn-trigger-delete');
            const nombreAlumno = botonInterno.getAttribute('data-alumno');

            // Instancia interactiva con tu mezcla nativa de botones Bootstrap
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                    cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
                },
                buttonsStyling: false
            });

            // Disparar recuadro de advertencia interactiva premium
            swalWithBootstrapButtons.fire({
                title: "¿Eliminar registro de baja?",
                text: `Vas a borrar de forma permanente la bitácora de baja correspondiente al alumno(a) "${nombreAlumno}". ¡Esta acción no reincorporará al niño de forma automática!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar historial",
                cancelButtonText: "No, conservar",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    formulario.submit(); // Proceder con el submit si pasa el control manual
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelado",
                        text: "El registro histórico de baja permanece intacto.",
                        icon: "error",
                        confirmButtonText: "Entendido"
                    });
                }
            });
        });
    });
</script>
@endsection