@extends("layouts.template")

@section("content")
<div class="row justify-content-center mt-3">
    <div class="col-12 col-md-6 col-lg-5">

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4">
                
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-light">
                    <div class="bubble-purple rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="fa-solid fa-kitchen-set fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Editar Composición</h5>
                        <small class="text-muted">Modifica los ingredientes que componen la receta</small>
                    </div>
                </div>

                <form action="{{ route('menus.update', $menu->id_menu) }}" method="POST" id="formEditMenu">
                    @csrf
                    @method('PUT')
                    
                    {{-- Select: Plato Principal (Burbuja Azul Pastel) --}}
                    <div class="mb-3">
                        <label for="id_plato" class="form-label fw-bold text-dark opacity-75 small">Plato Principal</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-blue d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-bowl-rice"></i>
                            </span>
                            <select name="id_plato" id="id_plato" class="form-select bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" style="font-size: 14px; height: 42px;" required>
                                @foreach($platos as $plato)
                                    <option value="{{ $plato->id_plato }}" {{ $menu->id_plato == $plato->id_plato ? 'selected' : '' }}>
                                        {{ $plato->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Select: Ingrediente a Vincular (Burbuja Verde Pastel) --}}
                    <div class="mb-4">
                        <label for="id_ingrediente" class="form-label fw-bold text-dark opacity-75 small">Ingrediente Asignado</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-green d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-carrot"></i>
                            </span>
                            <select name="id_ingrediente" id="id_ingrediente" class="form-select bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" style="font-size: 14px; height: 42px;" required>
                                @foreach($ingredientes as $ingrediente)
                                    <option value="{{ $ingrediente->id_ingrediente }}" {{ $menu->id_ingrediente == $ingrediente->id_ingrediente ? 'selected' : '' }}>
                                        {{ $ingrediente->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Botones de Acción Estilizados --}}
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <a href="{{ route('menus.index') }}" class="btn btn-light rounded-3 fw-bold px-3 text-muted py-2" style="background-color: #f4f7fc; font-size: 13px;">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary rounded-3 fw-bold px-4 py-2 shadow-sm" style="background-color: #2e5bff; border: none; font-size: 13px;">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Actualizar Relación
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('formEditMenu').addEventListener('submit', function(e) {
        e.preventDefault(); // Frenar envío automático nativo

        const platoSelect = document.getElementById('id_plato');
        const ingredienteSelect = document.getElementById('id_ingrediente');

        // Configuración estética de alertas usando tus clases de Bootstrap
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
            },
            buttonsStyling: false
        });

        // 1. COMPROBACIÓN: Validar que los selects no vengan hackeados o vacíos
        if (platoSelect.value === "" || ingredienteSelect.value === "") {
            swalWithBootstrapButtons.fire({
                title: "Selección Incompleta",
                text: "Por favor, asegúrate de seleccionar tanto el plato como el ingrediente correspondiente.",
                icon: "warning",
                confirmButtonText: "Revisar campos"
            });
            return;
        }

        // Extraer los textos dinámicos actuales para la alerta premium
        const textoPlato = platoSelect.options[platoSelect.selectedIndex].text.trim();
        const textoIngrediente = ingredienteSelect.options[ingredienteSelect.selectedIndex].text.trim();

        // 2. CONFIRMACIÓN INTERACTIVA CON CONTEXTO REAL
        swalWithBootstrapButtons.fire({
            title: "¿Actualizar ingredientes?",
            text: `Vas a modificar la receta para que el plato "${textoPlato}" contenga el ingrediente "${textoIngrediente}".`,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, actualizar",
            cancelButtonText: "No, cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // Disparar submit si el administrador da luz verde
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cambios Cancelados",
                    text: "La composición del menú se mantiene tal y como estaba.",
                    icon: "info",
                    confirmButtonText: "Ok"
                });
            }
        });
    });
</script>
@endsection