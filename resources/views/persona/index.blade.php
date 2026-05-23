@extends("layouts.template")

@section("content")
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="bubble-blue rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                <i class="fa-solid fa-address-book fa-lg"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Lista de Personas</h4>
                <p class="text-muted small mb-0">Catálogo general de registros de datos personales para alumnos y tutores</p>
            </div>
        </div>
        {{-- Botón Estilizado en Rojo Normal Sólido --}}
        <a href="{{ url('personas/create') }}" class="btn btn-danger rounded-3 px-3 shadow-sm fw-semibold btn-sm" style="background-color: #dc3545; border: 1px solid #dc3545; padding: 10px 16px;">
            <i class="fa-solid fa-plus me-1"></i> Registrar Persona
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
                            <th class="ps-3" style="width: 70px;">No.</th>
                            <th>Nombre Completo</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Fecha de Nacimiento</th>
                            <th class="text-end pe-3" style="width: 180px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($personas as $persona)
                            <tr style="transition: all 0.2s;">
                                <td class="ps-3 fw-bold text-secondary" style="font-size: 14px;">
                                    #{{ $loop->index + 1 }}
                                </td>

                                <td class="text-dark fw-bold" style="font-size: 14px; letter-spacing: -0.3px;">
                                    {{ $persona->nom }}
                                </td>

                                <td class="text-secondary fw-medium" style="font-size: 14px;">
                                    {{ $persona->ap }}
                                </td>

                                <td class="text-secondary fw-medium" style="font-size: 14px;">
                                    {{ $persona->am ?? '---' }}
                                </td>

                                <td>
                                    <span class="badge bubble-purple rounded-pill px-2.5 py-2 fw-semibold" style="font-size: 13px;">
                                        <i class="fa-regular fa-calendar me-1.5 opacity-75"></i>{{ $persona->fecha_nac }}
                                    </span>
                                </td>

                                <td class="text-end pe-3">
                                    <div class="d-flex gap-2 justify-content-end align-items-center">
                                        <a href="{{ route('personas.edit', $persona) }}" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-secondary" style="background-color: #f4f7fc; padding: 6px 12px; font-size: 12px;" title="Editar Datos">
                                            <i class="fa-solid fa-pen-to-square me-1 text-warning"></i> Editar
                                        </a>

                                        <form action="{{ route('personas.destroy', $persona) }}" method="post" class="d-inline form-eliminar-persona m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-danger btn-trigger-delete" style="background-color: #ffeef4; padding: 6px 12px; font-size: 12px;" data-nombre="{{ $persona->nom }} {{ $persona->ap }}">
                                                <i class="fa-solid fa-trash-can me-1"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-5">
                                    <div class="text-muted mb-3"><i class="fa-solid fa-users-viewfinder fa-3x opacity-20"></i></div>
                                    <span class="text-muted fw-medium">No se han encontrado personas registradas en el sistema.</span>
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
    document.querySelectorAll('.form-eliminar-persona').forEach(function(formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault(); // Detener el borrado inmediato

            // Capturar el nombre dinámico de la persona
            const botonInterno = this.querySelector('.btn-trigger-delete');
            const nombreCompleto = botonInterno.getAttribute('data-nombre');

            // Configuramos los botones basándonos en tus clases estables de Bootstrap
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                    cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
                },
                buttonsStyling: false
            });

            // Alerta Interactiva Premium
            swalWithBootstrapButtons.fire({
                title: "¿Eliminar registro de la base de datos?",
                text: `Estás a punto de borrar a "${nombreCompleto}". Al ser un catálogo maestro, eliminar esta persona romperá los expedientes de los niños o familiares asociados.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, borrar registro",
                cancelButtonText: "No, conservar",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    formulario.submit(); // Submit real si pasa el filtro
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Operación Cancelada",
                        text: "El registro de la persona permanece intacto y seguro.",
                        icon: "error",
                        confirmButtonText: "Entendido"
                    });
                }
            });
        });
    });
</script>
@endsection