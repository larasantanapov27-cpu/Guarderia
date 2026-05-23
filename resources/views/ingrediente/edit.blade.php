@extends("layouts.template")

@section("content")
<div class="row justify-content-center mt-3">
    <div class="col-12 col-md-6 col-lg-5">

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4">
                
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-light">
                    <div class="bubble-purple rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="fa-solid fa-pen-to-square fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Editar Ingrediente</h5>
                        <small class="text-muted">Modificando el insumo: <span class="text-primary fw-semibold">{{ $ingrediente->nombre }}</span></small>
                    </div>
                </div>

                <form action="{{ route('ingredientes.update', $ingrediente) }}" method="post" id="formEditIngrediente">
                    @csrf 
                    @method('PUT')
                    
                    {{-- Input: Nombre del Ingrediente (Burbuja Azul Pastel) --}}
                    <div class="mb-4">
                        <label for="nombre" class="form-label fw-bold text-dark opacity-75 small">Nombre del Ingrediente</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-blue d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-basket-shopping"></i>
                            </span>
                            <input type="text" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" id="nombre" name="nombre" value="{{ $ingrediente->nombre }}" placeholder="Ej: Zanahoria, Pollo, Arroz..." style="font-size: 14px; height: 42px;" required>
                        </div>
                    </div>

                    {{-- Botones de Acción Estilizados Asimétricos --}}
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <a href="{{ route('ingredientes.index') }}" class="btn btn-light rounded-3 fw-bold px-3 text-muted py-2" style="background-color: #f4f7fc; font-size: 13px;">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary rounded-3 fw-bold px-4 py-2 shadow-sm" style="background-color: #2e5bff; border: none; font-size: 13px;">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('formEditIngrediente').addEventListener('submit', function(e) {
        e.preventDefault(); // Frenar el envío automático de Laravel

        const nombreInput = document.getElementById('nombre').value.trim();

        // Configuración estética de alertas usando tus clases de Bootstrap
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
            },
            buttonsStyling: false
        });

        // 1. COMPROBACIÓN LÓGICA: Validar campo vacío o con puros espacios vacíos
        if (!nombreInput) {
            swalWithBootstrapButtons.fire({
                title: "Campo Incompleto",
                text: "Por favor, el nombre del ingrediente o insumo no puede quedar vacío.",
                icon: "warning",
                confirmButtonText: "Completar"
            });
            return;
        }

        // 2. COMPROBACIÓN LÓGICA: Evitar nombres absurdamente cortos
        if (nombreInput.length < 3) {
            swalWithBootstrapButtons.fire({
                title: "Nombre muy corto",
                text: "Por favor, escribe un nombre de insumo válido (mínimo 3 caracteres).",
                icon: "warning",
                confirmButtonText: "Corregir"
            });
            return;
        }

        // 3. ADVERTENCIA E INTERACCIÓN CONFIRMACIÓN FINAL
        swalWithBootstrapButtons.fire({
            title: "¿Guardar Cambios?",
            text: `Vas a modificar el nombre del ingrediente a: "${nombreInput}". Esto actualizará todas las recetas donde esté integrado.`,
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
                    text: "Las especificaciones del insumo permanecen sin alteraciones.",
                    icon: "info",
                    confirmButtonText: "Ok"
                });
            }
        });
    });
</script>
@endsection