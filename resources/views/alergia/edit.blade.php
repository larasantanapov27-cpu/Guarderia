@extends("layouts.template")

@section("content")
<div class="row justify-content-center mt-3">
    <div class="col-12 col-md-8 col-lg-6">

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4">
                
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-light">
                    <div class="bubble-purple rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="fa-solid fa-heart-pulse fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Editar Alerta Médica</h5>
                        <small class="text-muted">Modifica las restricciones alimentarias del expediente</small>
                    </div>
                </div>

                <form action="{{ route('alergias.update', $alergia->id_alergia) }}" method="post" id="formEditAlergia">
                    @csrf
                    @method("PUT")

                    {{-- Select: Alumno / Niño (Burbuja Azul Pastel) --}}
                    <div class="mb-3">
                        <label for="id_ninio" class="form-label fw-bold text-dark opacity-75 small">Alumno / Niño</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-blue d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-child"></i>
                            </span>
                            <select class="form-select bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" name="id_ninio" id="id_ninio" style="font-size: 14px; height: 42px;" required>
                                @foreach($ninios as $ninio)
                                    <option value="{{ $ninio->id_ninio }}" {{ $alergia->id_ninio == $ninio->id_ninio ? 'selected' : '' }}>
                                        {{ $ninio->nom }} {{ $ninio->ap }} {{ $ninio->am }} (Matrícula: {{ $ninio->matricula }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Select: Ingrediente Alérgeno (Burbuja Pink Pastel) --}}
                    <div class="mb-4">
                        <label for="id_ingrediente" class="form-label fw-bold text-dark opacity-75 small">Ingrediente Alérgeno / Restricción</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-pink d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #ffeef4; color: #dc3545;">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </span>
                            <select class="form-select bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" name="id_ingrediente" id="id_ingrediente" style="font-size: 14px; height: 42px;" required>
                                @foreach($ingredientes as $ingrediente)
                                    <option value="{{ $ingrediente->id_ingrediente }}" {{ $alergia->id_ingrediente == $ingrediente->id_ingrediente ? 'selected' : '' }}>
                                        {{ $ingrediente->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Botones de Acción Estilizados Asimétricos --}}
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <a href="{{ route('alergias.index') }}" class="btn btn-light rounded-3 fw-bold px-3 text-muted py-2" style="background-color: #f4f7fc; font-size: 13px;">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary rounded-3 fw-bold px-4 py-2 shadow-sm" style="background-color: #2e5bff; border: none; font-size: 13px;">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Actualizar Alergia
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('formEditAlergia').addEventListener('submit', function(e) {
        e.preventDefault(); // Frenar el envío automático nativo de Laravel

        const ninioSelect = document.getElementById('id_ninio');
        const ingredienteSelect = document.getElementById('id_ingrediente');

        // Configuración estética de las alertas usando tus botones nativos de Bootstrap
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
            },
            buttonsStyling: false
        });

        // 1. VALIDACIÓN LÓGICA: Que las opciones no se mantengan colgadas
        if (ninioSelect.value === "" || ingredienteSelect.value === "") {
            swalWithBootstrapButtons.fire({
                title: "Campos Incompletos",
                text: "Por favor, asegúrate de seleccionar tanto al alumno como el ingrediente alérgeno correspondiente.",
                icon: "warning",
                confirmButtonText: "Revisar opciones"
            });
            return;
        }

        // Extraer etiquetas legibles en tiempo real para armar el mensaje de confirmación
        const textoNinio = ninioSelect.options[ninioSelect.selectedIndex].text.split('(Matrícula:')[0].trim();
        const textoIngrediente = ingredienteSelect.options[ingredienteSelect.selectedIndex].text.trim();

        // 2. ADVERTENCIA E INTERACCIÓN DE CONFIRMACIÓN CON RIESGO MÉDICO CONTEMPLADO
        swalWithBootstrapButtons.fire({
            title: "¿Actualizar restricción médica?",
            text: `Confirmas que se cambien las especificaciones para que el alumno "${textoNinio}" quede registrado como alérgico a: "${textoIngrediente}".`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, actualizar",
            cancelButtonText: "No, cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // Proceder con el envío real si el admin lo autoriza
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Modificación Cancelada",
                    text: "El expediente de alergias permanece intacto.",
                    icon: "info",
                    confirmButtonText: "Ok"
                });
            }
        });
    });
</script>
@endsection