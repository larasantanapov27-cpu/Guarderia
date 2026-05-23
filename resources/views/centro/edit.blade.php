@extends("layouts.template")

@section("content")
<div class="row justify-content-center mt-3">
    <div class="col-12 col-md-8 col-lg-6">

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4">
                
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-light">
                    <div class="bubble-purple rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="fa-solid fa-school-flag fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Editar Centro</h5>
                        <small class="text-muted">Modificando: <span class="text-primary fw-semibold">{{ $centro->nom }}</span></small>
                    </div>
                </div>

                <form action="{{ route('centros.update', $centro) }}" method="post" id="formEditCentro">
                    @csrf
                    @method("PUT")

                    {{-- Input: Nombre del Centro (Burbuja Azul Pastel) --}}
                    <div class="mb-3">
                        <label for="nom" class="form-label fw-bold text-dark opacity-75 small">Nombre del Centro</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-blue d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </span>
                            <input type="text" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" id="nom" name="nom" placeholder="Ej: Pequeños Sueños" value="{{ $centro->nom }}" style="font-size: 14px; height: 42px;" required>
                        </div>
                    </div>

                    {{-- Input: Costo Mensual (Burbuja Naranja Pastel) --}}
                    <div class="mb-4">
                        <label for="costo" class="form-label fw-bold text-dark opacity-75 small">Costo Mensual ($)</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-orange d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-hand-holding-dollar"></i>
                            </span>
                            <input type="number" step="0.01" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" id="costo" name="costo" placeholder="Ej: 1500" value="{{ $centro->costo }}" style="font-size: 14px; height: 42px;" required>
                        </div>
                    </div>

                    {{-- Botones de Acción Estilizados --}}
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <a href="{{ route('centros.index') }}" class="btn btn-light rounded-3 fw-bold px-3 text-muted py-2" style="background-color: #f4f7fc; font-size: 13px;">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary rounded-3 fw-bold px-4 py-2 shadow-sm" style="background-color: #2e5bff; border: none; font-size: 13px;">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Guardar Cambios
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('formEditCentro').addEventListener('submit', function(e) {
        e.preventDefault(); // Detener el envío automático para hacer las comprobaciones

        const nombreInput = document.getElementById('nom').value.trim();
        const costoInput = parseFloat(document.getElementById('costo').value);

        // Instancia con tus clases de botones personalizadas de Bootstrap
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
            },
            buttonsStyling: false
        });

        // 1. COMPROBACIÓN: Campos vacíos
        if (!nombreInput || isNaN(costoInput)) {
            swalWithBootstrapButtons.fire({
                title: "Campos Incompletos",
                text: "Por favor, el nombre del centro y el costo mensual no pueden quedar vacíos.",
                icon: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        // 2. COMPROBACIÓN COHERENTE: Costos mayores a cero
        if (costoInput <= 0) {
            swalWithBootstrapButtons.fire({
                title: "Costo Mensual Inválido",
                text: "El costo asignado al centro debe ser una cantidad real mayor a $0.00.",
                icon: "error",
                confirmButtonText: "Corregir costo"
            });
            return;
        }

        // 3. CONFIRMACIÓN INTERACTIVA FINAL
        swalWithBootstrapButtons.fire({
            title: "¿Confirmar Modificaciones?",
            text: `Vas a actualizar los datos del centro a: "${nombreInput}" con una mensualidad base de $${costoInput.toFixed(2)}.`,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, guardar cambios",
            cancelButtonText: "No, cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // Proceder con el envío real si pasa los controles
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelado",
                    text: "Las especificaciones del plantel se mantienen intactas.",
                    icon: "info",
                    confirmButtonText: "Ok"
                });
            }
        });
    });
</script>
@endsection