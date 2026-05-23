@extends("layouts.template")

@section("content")
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="bubble-pink rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px; background-color: #ffeef4; color: #dc3545;">
                <i class="fa-solid fa-shield-virus fa-lg"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Control de Alergias</h4>
                <p class="text-muted small mb-0">Restricciones alimentarias críticas y alertas médicas para el comedor escolar</p>
            </div>
        </div>
        {{-- Botón Estilizado en Rojo Normal Sólido --}}
        <a href="{{ route('alergias.create') }}" class="btn btn-danger rounded-3 px-3 shadow-sm fw-semibold btn-sm" style="background-color: #dc3545; border: 1px solid #dc3545; padding: 10px 16px;">
            <i class="fa-solid fa-plus me-1"></i> Registrar Nueva Alergia
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
                            <th>Alumno / Niño</th>
                            <th>Ingrediente Alérgeno</th>
                            <th class="text-end pe-3" style="width: 180px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($alergias as $alergia)
                            <tr style="transition: all 0.2s;">
                                <td class="ps-3 fw-bold text-secondary" style="font-size: 14px;">
                                    #{{ $loop->iteration }}
                                </td>

                                <td class="text-dark fw-bold" style="font-size: 14px; letter-spacing: -0.3px;">
                                    <span class="badge bubble-blue rounded-pill px-3 py-2 text-dark fw-bold" style="border: 1px solid rgba(46, 91, 255, 0.1);">
                                        <i class="fa-solid fa-child me-1.5 opacity-75"></i>{{ $alergia->nom }} {{ $alergia->ap }} {{ $alergia->am }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge rounded-pill px-3 py-2 fw-bold" style="font-size: 13px; background-color: #ffeef4; color: #dc3545; border: 1px solid rgba(220, 53, 69, 0.1);">
                                        <i class="fa-solid fa-triangle-exclamation me-1.5 opacity-75"></i>{{ $alergia->nombre_ingrediente }}
                                    </span>
                                </td>

                                <td class="text-end pe-3">
                                    <div class="d-flex gap-2 justify-content-end align-items-center">
                                        <a href="{{ route('alergias.edit', $alergia->id_alergia) }}" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-secondary" style="background-color: #f4f7fc; padding: 6px 12px; font-size: 12px;" title="Editar Alergia">
                                            <i class="fa-solid fa-pen-to-square me-1 text-warning"></i> Editar
                                        </a>

                                        <form action="{{ route('alergias.destroy', $alergia->id_alergia) }}" method="post" class="d-inline form-eliminar-alergia m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-danger btn-trigger-delete" style="background-color: #ffeef4; padding: 6px 12px; font-size: 12px;" data-nino="{{ $alergia->nom }} {{ $alergia->ap }}" data-ingrediente="{{ $alergia->nombre_ingrediente }}">
                                                <i class="fa-solid fa-trash-can me-1"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center p-5">
                                    <div class="text-muted mb-3"><i class="fa-solid fa-heart-pulse fa-3x opacity-20"></i></div>
                                    <span class="text-muted fw-medium">No se han registrado alertas de alergias en el sistema. El comedor está libre de restricciones.</span>
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
    document.querySelectorAll('.form-eliminar-alergia').forEach(function(formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault(); // Detener el submit automático nativo de Laravel

            // Capturar la información médica contextual del renglón
            const botonInterno = this.querySelector('.btn-trigger-delete');
            const nombreNino = botonInterno.getAttribute('data-nino');
            const nombreIngrediente = botonInterno.getAttribute('data-ingrediente');

            // Instanciar alerta usando tus botones estables de Bootstrap
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                    cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
                },
                buttonsStyling: false
            });

            // Disparar confirmación interactiva premium
            swalWithBootstrapButtons.fire({
                title: "¿Remover alerta médica?",
                text: `Vas a retirar la restricción de "${nombreIngrediente}" para el alumno "${nombreNino}". Asegúrate de que el alta médica sea correcta antes de permitir el consumo de este alimento.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, dar de alta",
                cancelButtonText: "No, mantener alerta",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    formulario.submit(); // Pasar la petición al backend si confirma el admin
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Alerta Conservada",
                        text: "El expediente médico del alumno no ha sufrido modificaciones.",
                        icon: "info",
                        confirmButtonText: "Entendido"
                    });
                }
            });
        });
    });
</script>
@endsection