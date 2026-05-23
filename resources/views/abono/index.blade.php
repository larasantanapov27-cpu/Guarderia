@extends("layouts.template")

@section("content")
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="bubble-pink rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                <i class="fa-solid fa-money-check-dollar fa-lg"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Historial de Abonos</h4>
                <p class="text-muted small mb-0">Control y registro de los pagos recibidos por los familiares</p>
            </div>
        </div>
        <a href="{{ route('abonos.create') }}" class="btn btn-success rounded-3 px-3 shadow-sm fw-semibold btn-sm" style="background-color: #10b981; border: none; padding: 10px 16px;">
            <i class="fa-solid fa-plus me-1"></i> Registrar Nuevo Abono
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle" style="border-color: #f4f7fc;">
                    <thead>
                        <tr class="text-muted small uppercase" style="font-size: 11px; letter-spacing: 0.8px;">
                            <th class="ps-3" style="width: 70px;">No.</th>
                            <th>Monto</th>
                            <th>Fecha de Pago</th>
                            <th>Alumno</th>
                            <th>Tutor / Familiar</th>
                            <th class="text-end pe-3" style="width: 180px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($abonos as $abono)
                            <tr style="transition: all 0.2s;">
                                <td class="ps-3 fw-bold text-secondary" style="font-size: 14px;">
                                    #{{ $loop->index + 1 }}
                                </td>
                                
                                <td>
                                    <span class="text-dark rounded-pill px-3 py-2 fw-bold" style="font-size: 13px; border: 1px solid rgba(255, 92, 147, 0.1);">
                                        ${{ number_format($abono->cantidad, 2) }}
                                    </span>
                                </td>
                                
                                <td class="text-dark fw-medium" style="font-size: 14px;">
                                    <i class="fa-regular fa-calendar text-muted me-2"></i>{{ $abono->fecha }}
                                </td>
                                
                                <td class="text-dark fw-bold" style="font-size: 14px; letter-spacing: -0.3px;">
                                    {{ $abono->nombre_ninio }}
                                </td>
                                
                                <td class="text-muted" style="font-size: 14px;">
                                    {{ $abono->nombre_tutor }}
                                </td>
                                
                                <td class="text-end pe-3">
                                    <div class="d-flex gap-2 justify-content-end">
                                        
                                        
                                        <form action="{{ route('abonos.destroy', $abono->id_abono) }}" method="post" class="d-inline form-eliminar">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-baby-pink btn-sm rounded-3 fw-bold border-0 text-danger btn-alerta-delete" style="padding: 6px 12px; font-size: 12px;" data-nombre="{{ $abono->nombre_ninio }}" data-monto="{{ number_format($abono->cantidad, 2) }}">
                                                <i class="fa-solid fa-trash-can me-1"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-5">
                                    <div class="text-muted mb-3"><i class="fa-solid fa-receipt fa-3x opacity-20"></i></div>
                                    <span class="text-muted fw-medium">No se han registrado abonos o transacciones actualmente.</span>
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
    document.querySelectorAll('.form-eliminar').forEach(function(formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault(); // Detener borrado automático

            // Capturar datos dinámicos del botón interno
            const boton = this.querySelector('.btn-alerta-delete');
            const nino = boton.getAttribute('data-nombre');
            const monto = boton.getAttribute('data-monto');

            // Instancia con tus estilos Bootstrap Buttons
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                    cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
                },
                buttonsStyling: false
            });

            // Alerta confirmación premium
            swalWithBootstrapButtons.fire({
                title: "¿Estás completamente seguro?",
                text: `Vas a eliminar permanentemente el abono de $${monto} correspondiente al alumno(a) "${nino}". ¡Esta acción no se puede revertir!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar abono",
                cancelButtonText: "No, conservar",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el administrador confirma, procedemos al submit real de Laravel
                    formulario.submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelado",
                        text: "El abono financiero sigue a salvo en el historial :)",
                        icon: "error",
                        confirmButtonText: "Entendido"
                    });
                }
            });
        });
    });
</script>
@endsection