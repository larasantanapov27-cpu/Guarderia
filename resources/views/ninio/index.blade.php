@extends("layouts.template")

@section("content")
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="bubble-green rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                <i class="fa-solid fa-children fa-lg"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Listado de Niños Inscritos</h4>
                <p class="text-muted small mb-0">Control escolar general y administración de expedientes de alumnos</p>
            </div>
        </div>
        <a href="{{ route('ninios.create') }}" class="btn btn-success rounded-3 px-3 shadow-sm fw-semibold btn-sm" style="background-color: #10b981; border: none; padding: 10px 16px;">
            <i class="fa-solid fa-plus me-1"></i> Registrar Nuevo Niño
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
                            <th class="ps-3" style="width: 120px;">Matrícula</th>
                            <th>Nombre Completo</th>
                            <th>Fecha Ingreso</th>
                            <th>Centro Asignado</th>
                            <th class="text-end pe-3" style="width: 180px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ninios as $n)
                            <tr style="transition: all 0.2s;">
                                
                                <td class="ps-3">
                                    <span class="badge bubble-blue rounded-pill px-3 py-2 fw-bold" style="font-size: 12px; border: 1px solid rgba(46, 91, 255, 0.1);">
                                        {{ $n->matricula }}
                                    </span>
                                </td>
                                
                                <td class="text-dark fw-bold" style="font-size: 14px; letter-spacing: -0.3px;">
                                    {{ $n->nom }} {{ $n->ap }} {{ $n->am }}
                                </td>
                                
                                <td>
                                    <span class="badge bubble-purple rounded-pill px-2.5 py-2 fw-medium" style="font-size: 13px;">
                                        <i class="fa-regular fa-calendar me-1.5 opacity-75"></i>{{ $n->fecha }}
                                    </span>
                                </td>
                                
                                <td>
                                    <span class="badge bubble-orange rounded-pill px-3 py-2 fw-semibold" style="font-size: 13px; border: 1px solid rgba(255, 122, 50, 0.1);">
                                        <i class="fa-solid fa-school me-1.5 opacity-75"></i>{{ $n->centro_nombre }}
                                    </span>
                                </td>
                                
                                <td class="text-end pe-3">
                                    <div class="d-flex gap-2 justify-content-end align-items-center">
                                        <a href="{{ route('ninios.edit', $n->id_ninio) }}" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-secondary" style="background-color: #f4f7fc; padding: 6px 12px; font-size: 12px;" title="Editar Alumno">
                                            <i class="fa-solid fa-pen-to-square me-1 text-warning"></i> Editar
                                        </a>
                                        
                                        <form action="{{ route('ninios.destroy', $n->id_ninio) }}" method="POST" class="d-inline form-eliminar-alumno m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-danger btn-trigger-delete" style="background-color: #ffeef4; padding: 6px 12px; font-size: 12px;" data-alumno="{{ $n->nom }} {{ $n->ap }}">
                                                <i class="fa-solid fa-trash-can me-1"></i> Borrar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center p-5">
                                    <div class="text-muted mb-3"><i class="fa-solid fa-graduation-cap fa-3x opacity-20"></i></div>
                                    <span class="text-muted fw-medium">No se han encontrado registros de niños inscritos actualmente.</span>
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
    document.querySelectorAll('.form-eliminar-alumno').forEach(function(formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault(); // Detener el borrado inmediato automático

            // Capturar metadatos del botón interno
            const botonInterno = this.querySelector('.btn-trigger-delete');
            const nombreAlumno = botonInterno.getAttribute('data-alumno');

            // Instancia con tu mezcla de botones de Bootstrap
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                    cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
                },
                buttonsStyling: false
            });

            // Disparar recuadro de advertencia interactiva premium
            swalWithBootstrapButtons.fire({
                title: "¿Dar de baja al alumno?",
                text: `Estás a punto de eliminar permanentemente el expediente escolar de "${nombreAlumno}". Esta acción removerá sus bitácoras de comedor y registros de cuentas asociados.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, dar de baja",
                cancelButtonText: "No, conservar",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    formulario.submit(); // Proceder con el submit real si confirma el administrador
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Baja Cancelada",
                        text: "El expediente escolar del alumno sigue activo y sin modificaciones.",
                        icon: "error",
                        confirmButtonText: "Entendido"
                    });
                }
            });
        });
    });
</script>
@endsection