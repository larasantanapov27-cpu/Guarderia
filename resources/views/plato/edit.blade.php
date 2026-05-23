@extends("layouts.template")

@section("content")
<div class="row justify-content-center mt-3">
    <div class="col-12 col-md-6 col-lg-5">

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4">
                
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-light">
                    <div class="bubble-purple rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="fa-solid fa-bowl-food fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Editar Platillo</h5>
                        <small class="text-muted">Modificando el registro de: <span class="text-primary fw-semibold">{{ $plato->nombre }}</span></small>
                    </div>
                </div>

                <form action="{{ route('platos.update', $plato) }}" method="post" id="formEditPlato">
                    @csrf 
                    @method('PUT')
                    
                    {{-- Input: Nombre del Platillo (Burbuja Azul Pastel) --}}
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold text-dark opacity-75 small">Nombre del Platillo</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-blue d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-quote-left"></i>
                            </span>
                            <input type="text" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" id="nombre" name="nombre" value="{{ $plato->nombre }}" placeholder="Ej: Sopa de Verduras" style="font-size: 14px; height: 42px;" required>
                        </div>
                    </div>

                    {{-- Input: Precio ($) (Burbuja Verde Pastel) --}}
                    <div class="mb-4">
                        <label for="precio" class="form-label fw-bold text-dark opacity-75 small">Precio Unitario ($)</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-green d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-dollar-sign"></i>
                            </span>
                            <input type="number" step="0.01" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" id="precio" name="precio" value="{{ $plato->precio }}" placeholder="0.00" style="font-size: 14px; height: 42px;" required>
                        </div>
                    </div>

                    {{-- Botones de Acción Estilizados Asimétricos --}}
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <a href="{{ route('platos.index') }}" class="btn btn-light rounded-3 fw-bold px-3 text-muted py-2" style="background-color: #f4f7fc; font-size: 13px;">
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
    document.getElementById('formEditPlato').addEventListener('submit', function(e) {
        e.preventDefault(); // Detener el envío automático nativo de Laravel

        const nombreInput = document.getElementById('nombre').value.trim();
        const precioInput = document.getElementById('precio').value;

        // Mezcla de alertas premium usando tus clases de Bootstrap
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
            },
            buttonsStyling: false
        });

        // 1. VALIDACIÓN LÓGICA: Validar campos vacíos o con puros espacios
        if (!nombreInput || !precioInput) {
            swalWithBootstrapButtons.fire({
                title: "Campos Incompletos",
                text: "Por favor, el nombre del platillo y el precio unitario no pueden quedar vacíos.",
                icon: "warning",
                confirmButtonText: "Completar"
            });
            return;
        }

        // 2. VALIDACIÓN LÓGICA COHERENTE: Precio mayor a cero
        if (parseFloat(precioInput) <= 0) {
            swalWithBootstrapButtons.fire({
                title: "Costo no válido",
                text: "El precio unitario asignado al platillo debe ser una cantidad numérica mayor a $0.00.",
                icon: "error",
                confirmButtonText: "Corregir monto"
            });
            return;
        }

        // 3. ADVERTENCIA INTERACTIVA Y CONFIRMACIÓN FINAL
        swalWithBootstrapButtons.fire({
            title: "¿Guardar Modificaciones?",
            text: `Vas a actualizar el platillo a: "${nombreInput}" con un precio de $${parseFloat(precioInput).toFixed(2)}.`,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, actualizar",
            cancelButtonText: "No, cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // Proceder con el envío real a Laravel si el admin aprueba
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Modificación Cancelada",
                    text: "Las especificaciones del platillo se mantienen intactas.",
                    icon: "info",
                    confirmButtonText: "Ok"
                });
            }
        });
    });
</script>
@endsection