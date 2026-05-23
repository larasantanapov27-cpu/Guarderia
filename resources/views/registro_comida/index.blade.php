@extends("layouts.template")

@section("content")
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="bubble-blue rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                <i class="fa-solid fa-calendar-check fa-lg"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Historial de Alimentación</h4>
                <p class="text-muted small mb-0">Bitácora diaria de consumos alimenticios y seguimiento nutricional de los alumnos</p>
            </div>
        </div>
        {{-- Botón Estilizado en Rojo Normal Sólido --}}
        <a href="{{ route('registro_comidas.create') }}" class="btn btn-danger rounded-3 px-3 shadow-sm fw-semibold btn-sm" style="background-color: #dc3545; border: 1px solid #dc3545; padding: 10px 16px;">
            <i class="fa-solid fa-plus me-1"></i> Registrar Nueva Comida
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
                            <th class="ps-3" style="width: 90px;">ID Reg.</th>
                            <th>Fecha</th>
                            <th>Niño / Alumno</th>
                            <th>Plato Consumido</th>
                            <th class="text-end pe-3" style="width: 180px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registros as $reg)
                            <tr style="transition: all 0.2s;">
                                <td class="ps-3 fw-bold text-secondary" style="font-size: 14px;">
                                    #{{ $reg->id_regcomida }}
                                </td>

                                <td>
                                    <span class="badge bubble-purple rounded-pill px-2.5 py-2 fw-semibold" style="font-size: 13px;">
                                        <i class="fa-regular fa-calendar me-1.5 opacity-75"></i>{{ \Carbon\Carbon::parse($reg->fecha)->format('d/m/Y') }}
                                    </span>
                                </td>

                                <td class="text-dark fw-bold" style="font-size: 14px; letter-spacing: -0.3px;">
                                    {{ $reg->nombre_ninio }} {{ $reg->apellido_ninio }}
                                </td>

                                <td>
                                    <span class="badge bubble-orange rounded-pill px-3 py-2 fw-bold" style="font-size: 13px; border: 1px solid rgba(249, 115, 22, 0.1);">
                                        <i class="fa-solid fa-bowl-rice me-1.5 opacity-75"></i>{{ $reg->nombre_plato }}
                                    </span>
                                </td>

                                <td class="text-end pe-3">
                                    <div class="d-flex gap-2 justify-content-end align-items-center">
                                        <a href="{{ route('registro_comidas.edit', $reg->id_regcomida) }}" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-secondary" style="background-color: #f4f7fc; padding: 6px 12px; font-size: 12px;" title="Editar Registro">
                                            <i class="fa-solid fa-pen-to-square me-1 text-warning"></i> Editar
                                        </a>

                                        <form action="{{ route('registro_comidas.destroy', $reg->id_regcomida) }}" method="POST" class="d-inline form-eliminar-registro m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-danger btn-trigger-delete" style="background-color: #ffeef4; padding: 6px 12px; font-size: 12px;" data-nino="{{ $reg->nombre_ninio }} {{ $reg->apellido_ninio }}" data-plato="{{ $reg->nombre_plato }}">
                                                <i class="fa-solid fa-trash-can me-1"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center p-5">
                                    <div class="text-muted mb-3"><i class="fa-solid fa-utensils fa-3x opacity-20"></i></div>
                                    <span class="text-muted fw-medium">No se han encontrado registros de comidas en los expedientes actuales.</span>
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
    document.querySelectorAll('.form-eliminar-registro').forEach(function(formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault(); // Detener el envío automático nativo de Laravel

            // Capturar la metadata del registro alimenticio
            const botonInterno = this.querySelector('.btn-trigger-delete');
            const nino = botonInterno.getAttribute('data-nino');
            const plato = botonInterno.getAttribute('data-plato');

            // Instanciar alerta usando tus clases estables de Bootstrap
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                    cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
                },
                buttonsStyling: false
            });

            // Disparar confirmación premium interactiva contextual
            swalWithBootstrapButtons.fire({
                title: "¿Eliminar del historial?",
                text: `Vas a borrar de forma permanente el registro de consumo del plato "${plato}" asignado al alumno "${nino}".`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, borrar registro",
                cancelButtonText: "No, conservar",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    formulario.submit(); // Pasar la petición al backend si confirma el administrador
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Operación Cancelada",
                        text: "La bitácora de alimentación permanece segura y vigente.",
                        icon: "error",
                        confirmButtonText: "Entendido"
                    });
                }
            });
        });
    });
</script>
@endsection