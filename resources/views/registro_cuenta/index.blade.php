@extends("layouts.template")

@section("content")
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="bubble-blue rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                <i class="fa-solid fa-folder-open fa-lg"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Estado de Cuentas (Mensualidades)</h4>
                <p class="text-muted small mb-0">Listado general de folios de cobro asignados a los familiares responsables</p>
            </div>
        </div>
        <a href="{{ route('registro_cuentas.create') }}" class="btn btn-success rounded-3 px-3 shadow-sm fw-semibold btn-sm" style="background-color: #10b981; border: none; padding: 10px 16px;">
            <i class="fa-solid fa-plus me-1"></i> Nueva Cuenta
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
                            <th class="ps-3" style="width: 90px;">ID Reg</th>
                            <th>Familiar Responsable</th>
                            <th>Número de Cuenta / Folio</th>
                            <th class="text-end pe-3" style="width: 180px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cuentas as $cuenta)
                            <tr style="transition: all 0.2s;">
                                <td class="ps-3 fw-bold text-secondary" style="font-size: 14px;">
                                    #{{ $cuenta->id_regcuenta }}
                                </td>
                                
                                <td>
                                    <span class="badge bubble-green rounded-pill px-3 py-2 fw-semibold" style="font-size: 13px; border: 1px solid rgba(16, 185, 129, 0.1);">
                                        <i class="fa-solid fa-user-tie me-1 opacity-75"></i> {{ $cuenta->nombre_fam }} {{ $cuenta->apellido_fam ?? '' }}
                                    </span>
                                </td>
                                
                                <td>
                                    <span class="badge bubble-orange rounded-pill px-3 py-2 fw-bold" style="font-size: 13px; border: 1px solid rgba(255, 122, 50, 0.1);">
                                        <i class="fa-solid fa-hashtag me-1 opacity-75"></i> {{ $cuenta->cuenta }}
                                    </span>
                                </td>
                                
                                <td class="text-end pe-3">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('registro_cuentas.edit', $cuenta->id_regcuenta) }}" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-secondary" style="background-color: #f4f7fc; padding: 6px 12px; font-size: 12px;" title="Editar Cuenta">
                                            <i class="fa-solid fa-pen-to-square me-1 text-warning"></i> Editar
                                        </a>
                                        
                                        <form action="{{ route('registro_cuentas.destroy', $cuenta->id_regcuenta) }}" method="POST" class="d-inline form-eliminar-cuenta">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-danger btn-trigger-delete" style="background-color: #ffeef4; padding: 6px 12px; font-size: 12px;" data-tutor="{{ $cuenta->nombre_fam }}" data-folio="{{ $cuenta->cuenta }}">
                                                <i class="fa-solid fa-trash-can me-1"></i> Borrar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center p-5">
                                    <div class="text-muted mb-3"><i class="fa-solid fa-receipt fa-3x opacity-20"></i></div>
                                    <span class="text-muted fw-medium">No hay registros de cuentas o mensualidades cargadas actualmente.</span>
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
    document.querySelectorAll('.form-eliminar-cuenta').forEach(function(formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault(); // Detener el borrado inmediato de Laravel

            // Capturar la metadata del botón para personalizar el texto
            const botonInterno = this.querySelector('.btn-trigger-delete');
            const tutor = botonInterno.getAttribute('data-tutor');
            const folio = botonInterno.getAttribute('data-folio');

            // Configuramos los botones usando tus clases exactas de Bootstrap
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                    cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
                },
                buttonsStyling: false
            });

            // Disparar advertencia premium interactiva
            swalWithBootstrapButtons.fire({
                title: "¿Eliminar cuenta del sistema?",
                text: `Estás a punto de borrar por completo la cuenta Folio N° ${folio} asociada a "${tutor}". Esto desvinculará sus historiales de cobro.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, borrar cuenta",
                cancelButtonText: "No, conservar",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el administrador presiona el botón verde, se ejecuta el DELETE de Laravel
                    formulario.submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelado con éxito",
                        text: "La cuenta y sus folios operativos siguen vigentes sin alteraciones.",
                        icon: "error",
                        confirmButtonText: "Entendido"
                    });
                }
            });
        });
    });
</script>
@endsection