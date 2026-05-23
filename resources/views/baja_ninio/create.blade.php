@extends("layouts.template")

@section("content")
<div class="row justify-content-center mt-3">
    <div class="col-12 col-md-8 col-lg-6">

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4">
                
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-light">
                    <div class="bubble-purple rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="fa-solid fa-user-minus fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Registrar Baja de Niño</h5>
                        <small class="text-muted">Crea una nueva bitácora de desincorporación para un alumno</small>
                    </div>
                </div>

                <form action="{{ route('baja_ninios.store') }}" method="post" id="formCreateBaja">
                    @csrf
                    
                    {{-- Select: Niño a dar de baja (Burbuja Azul Pastel) --}}
                    <div class="mb-3">
                        <label for="id_ninio" class="form-label fw-bold text-dark opacity-75 small">Niño / Alumno a dar de baja</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-blue d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-child"></i>
                            </span>
                            <select class="form-select bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" name="id_ninio" id="id_ninio" style="font-size: 14px; height: 42px;" required>
                                <option value="" selected disabled>Seleccione el niño...</option>
                                @foreach($ninios as $ninio)
                                    <option value="{{ $ninio->id_ninio }}">
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
                            <input type="date" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" name="fecha" id="fecha" value="{{ date('Y-m-d') }}" style="font-size: 14px; height: 42px;" required>
                        </div>
                    </div>

                    {{-- Textarea: Motivo de la Baja (Burbuja Pink Pastel) --}}
                    <div class="mb-4">
                        <label for="motivo" class="form-label fw-bold text-dark opacity-75 small">Motivo de la Baja (Máx. 100 caracteres)</label>
                        <div class="input-group align-items-start">
                            <span class="input-group-text border-0 rounded-start-3 bubble-pink d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-comment-medical"></i>
                            </span>
                            <textarea class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" name="motivo" id="motivo" rows="3" placeholder="Ej: Cambio de domicilio o egreso..." style="font-size: 14px;" required maxlength="100"></textarea>
                        </div>
                    </div>

                    {{-- Botones de Acción Estilizados --}}
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <a href="{{ route('baja_ninios.index') }}" class="btn btn-light rounded-3 fw-bold px-3 text-muted py-2" style="background-color: #f4f7fc; font-size: 13px;">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-danger rounded-3 fw-bold px-4 py-2 shadow-sm" style=" #dc3545; border: 1px solid #dc3545: none; font-size: 13px;">
                            <i class="fa-solid fa-user-xmark me-1"></i> Confirmar Baja
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('formCreateBaja').addEventListener('submit', function(e) {
        e.preventDefault(); // Detener el envío automático nativo de Laravel

        const ninioSelect = document.getElementById('id_ninio');
        const fechaInput = document.getElementById('fecha').value;
        const motivoInput = document.getElementById('motivo').value.trim();

        // Instancia de alerta premium usando tus clases de Bootstrap
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
            },
            buttonsStyling: false
        });

        // 1. COMPROBACIÓN: Validar si se seleccionó un alumno
        if (ninioSelect.value === "") {
            swalWithBootstrapButtons.fire({
                title: "Falta Selección",
                text: "Por favor, elija un niño / alumno de la lista antes de continuar.",
                icon: "warning",
                confirmButtonText: "Elegir alumno"
            });
            return;
        }

        // 2. COMPROBACIÓN: Validar que el motivo no vaya vacío
        if (!fechaInput || !motivoInput) {
            swalWithBootstrapButtons.fire({
                title: "Campos Incompletos",
                text: "Por favor, complete la fecha y describa el motivo de la baja.",
                icon: "warning",
                confirmButtonText: "Completar"
            });
            return;
        }

        // 3. COMPROBACIÓN COHERENTE: Longitud del motivo
        if (motivoInput.length < 5) {
            swalWithBootstrapButtons.fire({
                title: "Motivo insuficiente",
                text: "Por favor, detalle de manera más clara la razón de la baja del alumno.",
                icon: "warning",
                confirmButtonText: "Ampliar motivo"
            });
            return;
        }

        // Extraer dinámicamente el texto completo del alumno seleccionado
        const nombreNinio = ninioSelect.options[ninioSelect.selectedIndex].text.trim();

        // 4. ADVERTENCIA E INTERACCIÓN CONFIRMACIÓN FINAL
        swalWithBootstrapButtons.fire({
            title: "¿Confirmar desincorporación?",
            text: `Estás a punto de registrar la baja oficial para el alumno "${nombreNinio}". Asegúrate de revisar que sea el expediente correcto.`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, registrar baja",
            cancelButtonText: "No, cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // Proceder con el envío real a Laravel
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Acción Cancelada",
                    text: "No se ha generado ningún registro de baja en el sistema.",
                    icon: "info",
                    confirmButtonText: "Ok"
                });
            }
        });
    });
</script>
@endsection