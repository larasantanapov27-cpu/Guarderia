@extends("layouts.template")

@section("content")
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="bubble-blue rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                <i class="fa-solid fa-user-shield fa-lg"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Lista de Familiares / Tutores</h4>
                <p class="text-muted small mb-0">Administración de padres de familia, tutores responsables y sus parentescos</p>
            </div>
        </div>
        {{-- Corregido a Rojo Normal brillante tal como lo solicitaste --}}
        <a href="{{ route('familiares.create') }}" class="btn btn-danger rounded-3 px-3 shadow-sm fw-semibold btn-sm" style="background-color: #dc3545; border: 1px solid #dc3545; padding: 10px 16px;">
            <i class="fa-solid fa-plus me-1"></i> Nuevo Familiar
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
                            <th class="ps-3">Familiar / Tutor</th>
                            <th>Parentesco</th>
                            <th>Niño Asignado</th>
                            <th>DNI / Identificación</th>
                            <th>Dirección de Residencia</th>
                            <th class="text-end pe-3" style="width: 180px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($familiares as $f)
                            <tr style="transition: all 0.2s;">
                                
                                <td class="ps-3 text-dark fw-bold" style="font-size: 14px; letter-spacing: -0.3px;">
                                    <i class="fa-solid fa-user-tie text-muted me-2 opacity-75"></i>{{ $f->nom_fam }} {{ $f->ap_fam }}
                                </td>

                                <td>
                                    <span class="badge bubble-purple rounded-pill px-3 py-2 fw-semibold" style="font-size: 13px;">
                                        {{ $f->parentesco }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bubble-green rounded-pill px-3 py-2 fw-bold" style="font-size: 13px; border: 1px solid rgba(16, 185, 129, 0.1);">
                                        <i class="fa-solid fa-child me-1.5 opacity-75"></i>{{ $f->nom_ninio }} {{ $f->ap_ninio }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bubble-orange rounded-pill px-2.5 py-2 fw-semibold" style="font-size: 12px; border: 1px solid rgba(255, 122, 50, 0.1);">
                                        <i class="fa-solid fa-id-card me-1.5 opacity-75"></i>{{ $f->DNI }}
                                    </span>
                                </td>

                                <td class="text-muted text-wrap" style="font-size: 13.5px; max-width: 200px;">
                                    {{ $f->dir }}
                                </td>

                                <td class="text-end pe-3">
                                    <div class="d-flex gap-2 justify-content-end align-items-center">
                                        <a href="{{ route('familiares.edit', $f->id_fam) }}" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-secondary" style="background-color: #f4f7fc; padding: 6px 12px; font-size: 12px;" title="Editar Familiar">
                                            <i class="fa-solid fa-pen-to-square me-1 text-warning"></i> Editar
                                        </a>

                                        <form action="{{ route('familiares.destroy', $f->id_fam) }}" method="POST" class="d-inline form-eliminar-familiar m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-danger btn-trigger-delete" style="background-color: #ffeef4; padding: 6px 12px; font-size: 12px;" data-tutor="{{ $f->nom_fam }} {{ $f->ap_fam }}" data-alumno="{{ $f->nom_ninio }} {{ $f->ap_ninio }}">
                                                <i class="fa-solid fa-trash-can me-1"></i> Borrar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-5">
                                    <div class="text-muted mb-3"><i class="fa-solid fa-users-slash fa-3x opacity-20"></i></div>
                                    <span class="text-muted fw-medium">No se han encontrado registros de familiares cargados actualmente.</span>
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
    document.querySelectorAll('.form-eliminar-familiar').forEach(function(formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault(); // Detener borrado automático

            // Capturar metadatos dinámicos del botón interno
            const botonInterno = this.querySelector('.btn-trigger-delete');
            const tutor = botonInterno.getAttribute('data-tutor');
            const alumno = botonInterno.getAttribute('data-alumno');

            // Instancia interactiva con tus clases nativas de Bootstrap
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                    cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
                },
                buttonsStyling: false
            });

            // Disparar recuadro de advertencia interactiva premium
            swalWithBootstrapButtons.fire({
                title: "¿Eliminar expediente del familiar?",
                text: `Vas a borrar permanentemente a "${tutor}" responsable del alumno(a) "${alumno}". Esto removerá sus cuentas de mensualidades vinculadas.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar tutor",
                cancelButtonText: "No, conservar",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    formulario.submit(); // Proceder con el DELETE real si acepta el administrador
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Acción Cancelada",
                        text: "El registro del familiar permanece activo en la base de datos.",
                        icon: "error",
                        confirmButtonText: "Entendido"
                    });
                }
            });
        });
    });
</script>
@endsection