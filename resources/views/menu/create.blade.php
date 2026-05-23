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
                        <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Asignar Ingrediente a Plato</h5>
                        <small class="text-muted">Desglosa las materias primas para las recetas del comedor</small>
                    </div>
                </div>

                <form action="{{ route('menus.store') }}" method="POST" id="formCreateMenu">
                    @csrf
                    
                    {{-- Select: Seleccionar Plato (Burbuja Azul Pastel) --}}
                    <div class="mb-3">
                        <label for="id_plato" class="form-label fw-bold text-dark opacity-75 small">Seleccionar Plato</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-blue d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-bowl-rice"></i>
                            </span>
                            <select name="id_plato" id="id_plato" class="form-select bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" style="font-size: 14px; height: 42px;" required>
                                <option value="" selected disabled>Seleccione un plato...</option>
                                @foreach($platos as $plato)
                                    <option value="{{ $plato->id_plato }}">{{ $plato->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Select: Seleccionar Ingrediente (Burbuja Verde Pastel) --}}
                    <div class="mb-4">
                        <label for="id_ingrediente" class="form-label fw-bold text-dark opacity-75 small">Seleccionar Ingrediente</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-green d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-carrot"></i>
                            </span>
                            <select name="id_ingrediente" id="id_ingrediente" class="form-select bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" style="font-size: 14px; height: 42px;" required>
                                <option value="" selected disabled>Seleccione un ingrediente...</option>
                                @foreach($ingredientes as $ingrediente)
                                    <option value="{{ $ingrediente->id_ingrediente }}">{{ $ingrediente->nombre }}</option>
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
                            <i class="fa-solid fa-floppy-disk me-1"></i> Guardar Relación
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('formCreateMenu').addEventListener('submit', function(e) {
        e.preventDefault(); // Pausar envío automático nativo de Laravel

        const platoSelect = document.getElementById('id_plato');
        const ingredienteSelect = document.getElementById('id_ingrediente');

        // Instancia premium basada en tus clases nativas de Bootstrap
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
            },
            buttonsStyling: false
        });

        // 1. COMPROBACIÓN: Validar selecciones vacías o colgadas
        if (platoSelect.value === "") {
            swalWithBootstrapButtons.fire({
                title: "Falta el Plato",
                text: "Por favor, selecciona a qué plato del menú deseas agregarle un componente.",
                icon: "warning",
                confirmButtonText: "Elegir plato"
            });
            return;
        }

        if (ingredienteSelect.value === "") {
            swalWithBootstrapButtons.fire({
                title: "Falta el Ingrediente",
                text: "Por favor, elige qué ingrediente se va a incorporar a la preparación.",
                icon: "warning",
                confirmButtonText: "Elegir ingrediente"
            });
            return;
        }

        // Capturar los textos dinámicos de las opciones elegidas en tiempo real
        const nombrePlato = platoSelect.options[platoSelect.selectedIndex].text.trim();
        const nombreIngrediente = ingredienteSelect.options[ingredienteSelect.selectedIndex].text.trim();

        // 2. INTERACCIÓN Y ADVERTENCIA DE CONFIRMACIÓN FINAL
        swalWithBootstrapButtons.fire({
            title: "¿Confirmar composición?",
            text: `Vas a registrar de forma oficial que el plato "${nombrePlato}" incluye el ingrediente "${nombreIngrediente}".`,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, guardar relación",
            cancelButtonText: "No, cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // Disparar submit real si pasa los filtros del administrador
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Registro Cancelado",
                    text: "No se ha modificado la composición de las recetas.",
                    icon: "info",
                    confirmButtonText: "Ok"
                });
            }
        });
    });
</script>
@endsection