@extends("layouts.template")

@section("content")
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="bubble-purple rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                <i class="fa-solid fa-people-roof fa-lg"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Lista de Parentescos</h4>
                <p class="text-muted small mb-0">Configuración de relaciones y vínculos legales entre tutores y alumnos</p>
            </div>
        </div>
        {{-- Botón Estilizado en Rojo Normal Sólido --}}
        <a href="{{ url('parentezcos/create') }}" class="btn btn-danger rounded-3 px-3 shadow-sm fw-semibold btn-sm" style="background-color: #dc3545; border: 1px solid #dc3545; padding: 10px 16px;">
            <i class="fa-solid fa-plus me-1"></i> Registrar Parentesco
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 fw-bold small text-success bg-success bg-opacity-10 py-3">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" style="border-color: #f4f7fc;">
                            <thead>
                                <tr class="text-muted small uppercase" style="font-size: 11px; letter-spacing: 0.8px;">
                                    <th class="ps-3" style="width: 80px;">No.</th>
                                    <th>Vínculo / Parentesco</th>
                                    <th class="text-end pe-3" style="width: 180px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($parentezcos as $parentezco)
                                    <tr style="transition: all 0.2s;">
                                        <td class="ps-3 fw-bold text-secondary" style="font-size: 14px;">
                                            #{{ $loop->index + 1 }}
                                        </td>

                                        <td>
                                            <span class="badge bubble-blue rounded-pill px-3 py-2 fw-bold" style="font-size: 13px; border: 1px solid rgba(46, 91, 255, 0.1);">
                                                {{ $parentezco->nombre }}
                                            </span>
                                        </td>

                                        <td class="text-end pe-3">
                                            <div class="d-flex gap-2 justify-content-end align-items-center">
                                                <a href="{{ route('parentezcos.edit', $parentezco) }}" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-secondary" style="background-color: #f4f7fc; padding: 6px 12px; font-size: 12px;" title="Editar Vínculo">
                                                    <i class="fa-solid fa-pen-to-square me-1 text-warning"></i> Editar
                                                </a>

                                                <form action="{{ route('parentezcos.destroy', $parentezco) }}" method="post" class="d-inline form-eliminar-parentesco m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-danger btn-trigger-delete" style="background-color: #ffeef4; padding: 6px 12px; font-size: 12px;" data-nombre="{{ $parentezco->nombre }}">
                                                        <i class="fa-solid fa-trash-can me-1"></i> Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center p-5">
                                            <div class="text-muted mb-3"><i class="fa-solid fa-people-arrows fa-3x opacity-20"></i></div>
                                            <span class="text-muted fw-medium">No se han configurado tipos de parentescos actualmente.</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.form-eliminar-parentesco').forEach(function(formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault(); // Pausar envío automático nativo

            // Capturar la metadata del botón interno
            const botonInterno = this.querySelector('.btn-trigger-delete');
            const nombreParentesco = botonInterno.getAttribute('data-nombre');

            // Configuramos los botones usando tus clases exactas de Bootstrap
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                    cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
                },
                buttonsStyling: false
            });

            // Alerta Interactiva de Seguridad
            swalWithBootstrapButtons.fire({
                title: "¿Eliminar este parentesco?",
                text: `Estás a punto de borrar la configuración de relación "${nombreParentesco}". Si existen tutores vinculados bajo este parentesco, la base de datos podría restringir la acción o quedar inconsistente.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, borrar de la DB",
                cancelButtonText: "No, conservar",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    formulario.submit(); // Completar DELETE real si confirma el administrador
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Acción Cancelada",
                        text: "La configuración de parentesco se mantiene vigente.",
                        icon: "error",
                        confirmButtonText: "Entendido"
                    });
                }
            });
        });
    });
</script>
@endsection