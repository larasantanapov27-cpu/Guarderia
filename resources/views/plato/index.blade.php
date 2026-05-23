@extends("layouts.template")

@section("content")
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="bubble-orange rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                <i class="fa-solid fa-utensils fa-lg"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Menú de Platos</h4>
                <p class="text-muted small mb-0">Catálogo general de platillos disponibles para el comedor de la guardería</p>
            </div>
        </div>
        {{-- Botón Estilizado en Rojo Normal Sólido --}}
        <a href="{{ route('platos.create') }}" class="btn btn-danger rounded-3 px-3 shadow-sm fw-semibold btn-sm" style="background-color: #dc3545; border: 1px solid #dc3545; padding: 10px 16px;">
            <i class="fa-solid fa-plus me-1"></i> Registrar Plato
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
                            <th>Platillo / Preparación</th>
                            <th>Costo / Precio Unitario</th>
                            <th class="text-end pe-3" style="width: 180px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($platos as $plato)
                            <tr style="transition: all 0.2s;">
                                <td class="ps-3 fw-bold text-secondary" style="font-size: 14px;">
                                    #{{ $loop->index + 1 }}
                                </td>

                                <td class="text-dark fw-bold" style="font-size: 14px; letter-spacing: -0.3px;">
                                    <span class="badge bubble-blue rounded-pill px-3 py-2 text-dark fw-bold" style="border: 1px solid rgba(46, 91, 255, 0.1);">
                                        {{ $plato->nombre }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bubble-green rounded-pill px-3 py-2 fw-bold" style="font-size: 13px; border: 1px solid rgba(16, 185, 129, 0.1);">
                                        <i class="fa-solid fa-dollar-sign me-1 opacity-75"></i>{{ number_format($plato->precio, 2) }}
                                    </span>
                                </td>

                                <td class="text-end pe-3">
                                    <div class="d-flex gap-2 justify-content-end align-items-center">
                                        <a href="{{ route('platos.edit', $plato) }}" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-secondary" style="background-color: #f4f7fc; padding: 6px 12px; font-size: 12px;" title="Editar Plato">
                                            <i class="fa-solid fa-pen-to-square me-1 text-warning"></i> Editar
                                        </a>

                                        <form action="{{ route('platos.destroy', $plato) }}" method="post" class="d-inline form-eliminar-plato m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-danger btn-trigger-delete" style="background-color: #ffeef4; padding: 6px 12px; font-size: 12px;" data-nombre="{{ $plato->nombre }}">
                                                <i class="fa-solid fa-trash-can me-1"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center p-5">
                                    <div class="text-muted mb-3"><i class="fa-solid fa-bowl-food fa-3x opacity-20"></i></div>
                                    <span class="text-muted fw-medium">No se han encontrado platos registrados en el menú actualmente.</span>
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
    document.querySelectorAll('.form-eliminar-plato').forEach(function(formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault(); // Detener el envío directo a Laravel

            // Capturar la metadata del botón interno
            const botonInterno = this.querySelector('.btn-trigger-delete');
            const nombrePlato = botonInterno.getAttribute('data-nombre');

            // Instancia de SweetAlert usando tus estilos nativos de Bootstrap
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                    cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
                },
                buttonsStyling: false
            });

            // Disparar recuadro de advertencia interactiva premium
            swalWithBootstrapButtons.fire({
                title: "¿Eliminar plato del menú?",
                text: `Vas a borrar permanentemente el platillo "${nombrePlato}". Al hacer esto, se eliminarán sus registros asociados en las bitácoras de comidas de los niños e ingredientes configurados.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar platillo",
                cancelButtonText: "No, conservar",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    formulario.submit(); // Proceder con el DELETE si el admin acepta
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Operación Cancelada",
                        text: "El platillo continúa activo en la minuta del comedor.",
                        icon: "error",
                        confirmButtonText: "Ok"
                    });
                }
            });
        });
    });
</script>
@endsection