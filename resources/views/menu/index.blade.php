@extends("layouts.template")

@section("content")
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="bubble-orange rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                <i class="fa-solid fa-utensils fa-lg"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Composición de Menús</h4>
                <p class="text-muted small mb-0">Gestión de recetas y desglose de ingredientes asignados a cada plato del comedor</p>
            </div>
        </div>
        {{-- Botón Estilizado en Rojo Normal Sólido --}}
        <a href="{{ route('menus.create') }}" class="btn btn-danger rounded-3 px-3 shadow-sm fw-semibold btn-sm" style="background-color: #dc3545; border: 1px solid #dc3545; padding: 10px 16px;">
            <i class="fa-solid fa-plus me-1"></i> Asignar Ingrediente
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
                            <th class="ps-3" style="width: 90px;">ID Menú</th>
                            <th>Plato Principal</th>
                            <th>Ingrediente Vinculado</th>
                            <th class="text-end pe-3" style="width: 180px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menus as $menu)
                            <tr style="transition: all 0.2s;">
                                <td class="ps-3 fw-bold text-secondary" style="font-size: 14px;">
                                    #{{ $menu->id_menu }}
                                </td>

                                <td>
                                    <span class="badge bubble-blue rounded-pill px-3 py-2 fw-bold" style="font-size: 13px; border: 1px solid rgba(46, 91, 255, 0.1);">
                                        <i class="fa-solid fa-bowl-rice me-1.5 opacity-75"></i>{{ $menu->nombre_plato }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bubble-green rounded-pill px-3 py-2 fw-semibold" style="font-size: 13px; border: 1px solid rgba(16, 185, 129, 0.1);">
                                        <i class="fa-solid fa-carrot me-1.5 opacity-75"></i>{{ $menu->nombre_ingrediente }}
                                    </span>
                                </td>

                                <td class="text-end pe-3">
                                    <div class="d-flex gap-2 justify-content-end align-items-center">
                                        <a href="{{ route('menus.edit', $menu->id_menu) }}" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-secondary" style="background-color: #f4f7fc; padding: 6px 12px; font-size: 12px;" title="Editar Composición">
                                            <i class="fa-solid fa-pen-to-square me-1 text-warning"></i> Editar
                                        </a>

                                        <form action="{{ route('menus.destroy', $menu->id_menu) }}" method="POST" class="d-inline form-eliminar-menu m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm rounded-3 fw-bold border-0 text-danger btn-trigger-delete" style="background-color: #ffeef4; padding: 6px 12px; font-size: 12px;" data-plato="{{ $menu->nombre_plato }}" data-ingrediente="{{ $menu->nombre_ingrediente }}">
                                                <i class="fa-solid fa-trash-can me-1"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center p-5">
                                    <div class="text-muted mb-3"><i class="fa-solid fa-kitchen-set fa-3x opacity-20"></i></div>
                                    <span class="text-muted fw-medium">No hay ingredientes asignados a los platos actualmente.</span>
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
    document.querySelectorAll('.form-eliminar-menu').forEach(function(formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault(); // Congelar el submit automático de Laravel

            // Capturar la metadata interactiva de los alimentos
            const botonInterno = this.querySelector('.btn-trigger-delete');
            const plato = botonInterno.getAttribute('data-plato');
            const ingrediente = botonInterno.getAttribute('data-ingrediente');

            // Instanciar alerta usando tus botones nativos de Bootstrap
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                    cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
                },
                buttonsStyling: false
            });

            // Disparar confirmación premium contextual
            swalWithBootstrapButtons.fire({
                title: "¿Quitar ingrediente del menú?",
                text: `Vas a desvincular por completo el ingrediente "${ingrediente}" de la preparación del plato "${plato}".`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "No, conservar",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    formulario.submit(); // Proceder al backend si confirma el administrador
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Acción Cancelada",
                        text: "La composición de la receta sigue intacta.",
                        icon: "error",
                        confirmButtonText: "Entendido"
                    });
                }
            });
        });
    });
</script>
@endsection