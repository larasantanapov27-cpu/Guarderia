@extends("layouts.template")

@section("content")
<div class="row justify-content-center mt-3">
    <div class="col-12 col-md-6 col-lg-5">

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4">
                
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-light">
                    <div class="bubble-purple rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="fa-solid fa-people-arrows fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Editar Parentesco</h5>
                        <small class="text-muted">Modificando el vínculo: <span class="text-primary fw-semibold">{{ $parentezco->nombre }}</span></small>
                    </div>
                </div>

                <form action="{{ route('parentezcos.update', $parentezco) }}" method="post" id="formEditParentesco">
                    @csrf
                    @method("PUT")
                    
                    {{-- Input: Nombre del Parentesco (Burbuja Azul Pastel) --}}
                    <div class="mb-4">
                        <label for="nombre" class="form-label fw-bold text-dark opacity-75 small">Nombre del Parentesco</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-blue d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-users-line"></i>
                            </span>
                            <input type="text" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" id="nombre" name="nombre" placeholder="Ej: Madre, Padre, Tío..." value="{{ $parentezco->nombre }}" style="font-size: 14px; height: 42px;" required>
                        </div>
                    </div>

                    {{-- Botones de Acción Estilizados --}}
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <a href="{{ route('parentezcos.index') }}" class="btn btn-light rounded-3 fw-bold px-3 text-muted py-2" style="background-color: #f4f7fc; font-size: 13px;">
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
    document.getElementById('formEditParentesco').addEventListener('submit', function(e) {
        e.preventDefault(); // Detener envío automático nativo

        const nombreInput = document.getElementById('nombre').value.trim();

        // Configuración de los botones con tus clases estables de Bootstrap
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
            },
            buttonsStyling: false
        });

        // 1. COMPROBACIÓN LÓGICA: Que no dejen el campo vacío o con puros espacios
        if (!nombreInput) {
            swalWithBootstrapButtons.fire({
                title: "Campo Requerido",
                text: "Por favor, el nombre del parentesco o relación familiar no puede quedar vacío.",
                icon: "warning",
                confirmButtonText: "Escribir nombre"
            });
            return;
        }

        // 2. COMPROBACIÓN LÓGICA: Evitar nombres de relación absurdamente cortos
        if (nombreInput.length < 3) {
            swalWithBootstrapButtons.fire({
                title: "Texto muy corto",
                text: "Por favor, escribe un término de parentesco válido (Ej: Tío, Primo, Madre).",
                icon: "warning",
                confirmButtonText: "Corregir"
            });
            return;
        }

        // 3. ADVERTENCIA E INTERACCIÓN CONFIRMACIÓN FINAL
        swalWithBootstrapButtons.fire({
            title: "¿Confirmar Cambios?",
            text: `Vas a modificar la etiqueta de relación a: "${nombreInput}". Esto actualizará a todos los tutores registrados bajo este vínculo.`,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, guardar cambios",
            cancelButtonText: "No, cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // Proceder con el envío de verdad si acepta el administrador
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelado",
                    text: "La configuración original del parentesco se mantiene intacta.",
                    icon: "info",
                    confirmButtonText: "Ok"
                });
            }
        });
    });
</script>
@endsection