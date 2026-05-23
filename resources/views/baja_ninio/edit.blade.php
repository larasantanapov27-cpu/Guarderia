@extends("layouts.template")

@section("content")
<div class="row justify-content-center mt-3">
    <div class="col-12 col-md-8 col-lg-6">

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4">
                
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-light">
                    <div class="bubble-purple rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="fa-solid fa-user-pen fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Editar Registro de Baja</h5>
                        <small class="text-muted">Modifica los detalles del expediente de desincorporación</small>
                    </div>
                </div>

                <form action="{{ route('baja_ninios.update', $baja->id_baja) }}" method="post" id="formEditBaja">
                    @csrf
                    @method("PUT")
                    
                    {{-- Select: Niño (Burbuja Azul Pastel) --}}
                    <div class="mb-3">
                        <label for="id_ninio" class="form-label fw-bold text-dark opacity-75 small">Niño / Alumno afectado</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-blue d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-child"></i>
                            </span>
                            <select class="form-select bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" name="id_ninio" id="id_ninio" style="font-size: 14px; height: 42px;" required>
                                @foreach($ninios as $ninio)
                                    <option value="{{ $ninio->id_ninio }}" {{ $baja->id_ninio == $ninio->id_ninio ? 'selected' : '' }}>
                                        {{ $ninio->nom }} {{ $ninio->ap }} {{ $ninio->am }} (Matrícula: {{ $ninio->matricula }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Input: Fecha de Baja (Burbuja Naranja Pastel) --}}
                    <div class="mb-3">
                        <label for="fecha" class="form-label fw-bold text-dark opacity-75 small">Fecha de Baja</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-orange d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-regular fa-calendar-minus"></i>
                            </span>
                            <input type="date" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" name="fecha" id="fecha" value="{{ $baja->fecha }}" style="font-size: 14px; height: 42px;" required>
                        </div>
                    </div>

                    {{-- Textarea: Motivo de la Baja (Burbuja Pink Pastel) --}}
                    <div class="mb-4">
                        <label for="motivo" class="form-label fw-bold text-dark opacity-75 small">Motivo de la Baja (Máx. 100 caracteres)</label>
                        <div class="input-group align-items-start">
                            <span class="input-group-text border-0 rounded-start-3 bubble-pink d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-comment-medical"></i>
                            </span>
                            <textarea class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" name="motivo" id="motivo" rows="3" placeholder="Escriba aquí la razón del retiro..." style="font-size: 14px;" required maxlength="100">{{ $baja->motivo }}</textarea>
                        </div>
                    </div>

                    {{-- Botones de Acción Estilizados --}}
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <a href="{{ route('baja_ninios.index') }}" class="btn btn-light rounded-3 fw-bold px-3 text-muted py-2" style="background-color: #f4f7fc; font-size: 13px;">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary rounded-3 fw-bold px-4 py-2 shadow-sm" style="background-color: #2e5bff; border: none; font-size: 13px;">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Actualizar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('formEditBaja').addEventListener('submit', function(e) {
        e.preventDefault(); // Pausar envío automático nativo

        const ninioSelect = document.getElementById('id_ninio');
        const fechaInput = document.getElementById('fecha').value;
        const motivoInput = document.getElementById('motivo').value.trim();

        // Instancia de alerta con tus estilos de Bootstrap predefinidos
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
            },
            buttonsStyling: false
        });

        // 1. COMPROBACIÓN: Validar campos vacíos
        if (!fechaInput || !motivoInput) {
            swalWithBootstrapButtons.fire({
                title: "Campos Incompletos",
                text: "Por favor, la fecha de baja y el motivo no pueden quedar vacíos o con puros espacios.",
                icon: "warning",
                confirmButtonText: "Completar"
            });
            return;
        }

        // 2. COMPROBACIÓN: Longitud del motivo razonable
        if (motivoInput.length < 5) {
            swalWithBootstrapButtons.fire({
                title: "Motivo muy corto",
                text: "Por favor, detalle de manera más clara la razón o motivo del retiro del niño.",
                icon: "warning",
                confirmButtonText: "Ampliar texto"
            });
            return;
        }

        // Extraer texto del niño seleccionado para personalizar el SweetAlert
        const nombreNinio = ninioSelect.options[ninioSelect.selectedIndex].text.trim();

        // 3. CONFIRMACIÓN INTERACTIVA FINAL CON TUS BOTONES NATIVOS
        swalWithBootstrapButtons.fire({
            title: "¿Confirmar Cambios?",
            text: `Vas a actualizar los detalles de la baja del alumno(a) "${nombreNinio}".`,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, guardar cambios",
            cancelButtonText: "No, cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // Disparar submit real si pasa los controles manuales
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Modificación Cancelada",
                    text: "Las especificaciones de la bitácora de baja se mantienen intactas.",
                    icon: "info",
                    confirmButtonText: "Ok"
                });
            }
        });
    });
</script>
@endsection