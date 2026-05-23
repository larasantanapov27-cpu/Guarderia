@extends("layouts.template")

@section("content")
<div class="row justify-content-center mt-3">
    <div class="col-12 col-md-10 col-lg-8">

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4">
                
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-light">
                    <div class="bubble-purple rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="fa-solid fa-user-gear fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Editar Datos Personales</h5>
                        <small class="text-muted">Modificando el registro de: <span class="text-primary fw-semibold">{{ $persona->nom }}</span></small>
                    </div>
                </div>

                <form action="{{ route('personas.update', $persona) }}" method="post" id="formEditPersona">
                    @csrf
                    @method("PUT")

                    <div class="row">
                        {{-- Input: Nombre(s) (Burbuja Azul Pastel) --}}
                        <div class="col-md-12 mb-3">
                            <label for="nom" class="form-label fw-bold text-dark opacity-75 small">Nombre(s)</label>
                            <div class="input-group align-items-center">
                                <span class="input-group-text border-0 rounded-start-3 bubble-blue d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                    <i class="fa-solid fa-signature"></i>
                                </span>
                                <input type="text" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" id="nom" name="nom" placeholder="Ej: Juan" value="{{ $persona->nom }}" style="font-size: 14px; height: 42px;" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Input: Apellido Paterno (Burbuja Verde Pastel) --}}
                        <div class="col-md-6 mb-3">
                            <label for="ap" class="form-label fw-bold text-dark opacity-75 small">Apellido Paterno</label>
                            <div class="input-group align-items-center">
                                <span class="input-group-text border-0 rounded-start-3 bubble-green d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                    <i class="fa-solid fa-font"></i>
                                </span>
                                <input type="text" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" id="ap" name="ap" placeholder="Ej: Pérez" value="{{ $persona->ap }}" style="font-size: 14px; height: 42px;" required>
                            </div>
                        </div>

                        {{-- Input: Apellido Materno (Burbuja Pink Pastel) --}}
                        <div class="col-md-6 mb-3">
                            <label for="am" class="form-label fw-bold text-dark opacity-75 small">Apellido Materno</label>
                            <div class="input-group align-items-center">
                                <span class="input-group-text border-0 rounded-start-3 bubble-pink d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                    <i class="fa-solid fa-font opacity-50"></i>
                                </span>
                                <input type="text" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" id="am" name="am" placeholder="Ej: García" value="{{ $persona->am }}" style="font-size: 14px; height: 42px;">
                            </div>
                        </div>
                    </div>

                    {{-- Input: Fecha de Nacimiento (Burbuja Naranja Pastel) --}}
                    <div class="mb-4">
                        <label for="fecha_nac" class="form-label fw-bold text-dark opacity-75 small">Fecha de Nacimiento</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-orange d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-regular fa-calendar"></i>
                            </span>
                            <input type="date" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" id="fecha_nac" name="fecha_nac" value="{{ $persona->fecha_nac }}" style="font-size: 14px; height: 42px;" required>
                        </div>
                    </div>

                    {{-- Botones de Acción Estilizados --}}
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <a href="{{ route('personas.index') }}" class="btn btn-light rounded-3 fw-bold px-3 text-muted py-2" style="background-color: #f4f7fc; font-size: 13px;">
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
    document.getElementById('formEditPersona').addEventListener('submit', function(e) {
        e.preventDefault(); // Detener el envío nativo automático

        const nomInput = document.getElementById('nom').value.trim();
        const apInput = document.getElementById('ap').value.trim();
        const amInput = document.getElementById('am').value.trim();
        const fechaInput = document.getElementById('fecha_nac').value;

        // Configuración de los botones con tus clases estables de Bootstrap
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
            },
            buttonsStyling: false
        });

        // 1. VALIDACIÓN LÓGICA: Nombre y Apellido Paterno requeridos
        if (!nomInput || !apInput || !fechaInput) {
            swalWithBootstrapButtons.fire({
                title: "Campos Incompletos",
                text: "Por favor, el nombre, el apellido paterno y la fecha de nacimiento no pueden quedar vacíos.",
                icon: "warning",
                confirmButtonText: "Completar datos"
            });
            return;
        }

        // 2. ADVERTENCIA E INTERACCIÓN DE CONFIRMACIÓN FINAL
        swalWithBootstrapButtons.fire({
            title: "¿Confirmar Modificaciones?",
            text: `Vas a actualizar los datos a: "${nomInput} ${apInput} ${amInput}". Asegúrate de verificar la información antes de guardar.`,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, guardar cambios",
            cancelButtonText: "No, cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // Disparar submit real si el administrador acepta
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Modificación Cancelada",
                    text: "Los datos de la persona permanecen intactos sin alteraciones.",
                    icon: "info",
                    confirmButtonText: "Ok"
                });
            }
        });
    });
</script>
@endsection