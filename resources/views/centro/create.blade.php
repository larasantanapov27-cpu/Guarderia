@extends("layouts.template")

@section("content")

<div class="row justify-content-center mt-3">
    <div class="col-12 col-md-8 col-lg-6">

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4">
                
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-light">
                    <div class="bubble-pink rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="fa-solid fa-school-flag fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Registrar Nueva Estancia</h5>
                        <small class="text-muted">Añade una sede al sistema de guarderías</small>
                    </div>
                </div>

                <form action="{{ url('centros') }}" method="post" id="formCentro">
                    @csrf

                    <div class="mb-3">
                        <label for="nom" class="form-label fw-bold text-dark opacity-75 small">Nombre del Centro</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 bg-light rounded-start-3 text-muted"><i class="fa-solid fa-signature"></i></span>
                            <input type="text" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" id="nom" name="nom" placeholder="Ej. Pequeños Sueños N° 2" style="font-size: 14px;">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="costo" class="form-label fw-bold text-dark opacity-75 small">Costo Mensual ($)</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 bg-light rounded-start-3 text-muted"><i class="fa-solid fa-money-bill-wave"></i></span>
                            <input type="number" step="0.01" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" id="costo" name="costo" placeholder="Ej. 1500" style="font-size: 14px;">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <button type="reset" class="btn btn-light rounded-3 fw-bold px-3 text-muted py-2" style="background-color: #f4f7fc; font-size: 13px;">
                            Limpiar Campos
                        </button>

                        <button type="submit" class="btn btn-primary rounded-3 fw-bold px-4 py-2 shadow-sm" style="background-color: #2e5bff; border: none; font-size: 13px;">
                            <i class="fa-solid fa-cloud-arrow-up me-1"></i> Guardar Centro
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('formCentro').addEventListener('submit', function(e) {
        // Detener el envío nativo para verificar los datos primero
        e.preventDefault();

        // Obtener los valores ingresados
        const nombreInput = document.getElementById('nom').value.trim();
        const costoInput = parseFloat(document.getElementById('costo').value);

        // Configuración de botones de Bootstrap que definiste
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
            },
            buttonsStyling: false
        });

        // 1. VALIDACIÓN: Campos Vacíos
        if (nombreInput === '' || isNaN(costoInput)) {
            swalWithBootstrapButtons.fire({
                title: "Campos Incompletos",
                text: "Por favor, llena todos los espacios del formulario antes de continuar.",
                icon: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        // 2. VALIDACIÓN COHERENTE: Costo no puede ser una cantidad negativa
        if (costoInput < 0) {
            swalWithBootstrapButtons.fire({
                title: "Monto Inválido",
                text: "El costo mensual no puede ser una cantidad negativa.",
                icon: "error",
                confirmButtonText: "Corregir costo"
            });
            return;
        }

        // 3. CONFIRMACIÓN FINAL ANTES DE GUARDAR
        swalWithBootstrapButtons.fire({
            title: "¿Estás seguro?",
            text: `Vas a registrar el centro "${nombreInput}" con un costo de $${costoInput.toFixed(2)}.`,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, registrar",
            cancelButtonText: "No, cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Si confirma de forma interactiva, enviamos el formulario real a Laravel
                this.submit();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelado",
                    text: "El registro ha sido detenido de forma segura.",
                    icon: "info",
                    confirmButtonText: "Ok"
                });
            }
        });
    });
</script>

@endsection