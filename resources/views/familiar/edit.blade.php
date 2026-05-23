@extends("layouts.template")

@section("content")
<div class="row justify-content-center mt-3">
    <div class="col-12 col-md-10 col-lg-8">

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4">
                
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-light">
                    <div class="bubble-purple rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="fa-solid fa-user-pen fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Editar Familiar / Tutor</h5>
                        <small class="text-muted">Modifica las relaciones, identificación y residencia del tutor</small>
                    </div>
                </div>

                <form action="{{ route('familiares.update', $familiar->id_fam) }}" method="POST" id="formEditFamiliar">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- Select: Persona (Burbuja Azul Pastel) --}}
                        <div class="col-md-6 mb-3">
                            <label for="id_persona" class="form-label fw-bold text-dark opacity-75 small">Persona (Familiar)</label>
                            <div class="input-group align-items-center">
                                <span class="input-group-text border-0 rounded-start-3 bubble-blue d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                    <i class="fa-solid fa-user-shield"></i>
                                </span>
                                <select name="id_persona" id="id_persona" class="form-select bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" style="font-size: 14px; height: 42px;" required>
                                    @foreach($personas as $p)
                                        <option value="{{ $p->id_persona }}" {{ $familiar->id_persona == $p->id_persona ? 'selected' : '' }}>
                                            {{ $p->nom }} {{ $p->ap }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Input: DNI (Burbuja Naranja Pastel) --}}
                        <div class="col-md-6 mb-3">
                            <label for="DNI" class="form-label fw-bold text-dark opacity-75 small">DNI / Identificación</label>
                            <div class="input-group align-items-center">
                                <span class="input-group-text border-0 rounded-start-3 bubble-orange d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                    <i class="fa-solid fa-id-card"></i>
                                </span>
                                <input type="number" name="DNI" id="DNI" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" value="{{ $familiar->DNI }}" style="font-size: 14px; height: 42px;" required>
                            </div>
                        </div>
                    </div>

                    {{-- Input: Dirección (Burbuja Pink Pastel) --}}
                    <div class="mb-3">
                        <label for="dir" class="form-label fw-bold text-dark opacity-75 small">Dirección de Residencia</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-pink d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-map-location-dot"></i>
                            </span>
                            <input type="text" name="dir" id="dir" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" value="{{ $familiar->dir }}" placeholder="Ej: Av. Principal N° 123" maxlength="100" style="font-size: 14px; height: 42px;" required>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Select: Parentesco (Burbuja Morada Pastel) --}}
                        <div class="col-md-6 mb-3">
                            <label for="id_parentezco" class="form-label fw-bold text-dark opacity-75 small">Parentesco</label>
                            <div class="input-group align-items-center">
                                <span class="input-group-text border-0 rounded-start-3 bubble-purple d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                    <i class="fa-solid fa-people-roof"></i>
                                </span>
                                <select name="id_parentezco" id="id_parentezco" class="form-select bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" style="font-size: 14px; height: 42px;" required>
                                    @foreach($parentezcos as $par)
                                        <option value="{{ $par->id_parentezco }}" {{ $familiar->id_parentezco == $par->id_parentezco ? 'selected' : '' }}>
                                            {{ $par->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Select: Niño Asignado (Burbuja Verde Pastel) --}}
                        <div class="col-md-6 mb-3">
                            <label for="id_ninio" class="form-label fw-bold text-dark opacity-75 small">Niño Asignado / Alumno</label>
                            <div class="input-group align-items-center">
                                <span class="input-group-text border-0 rounded-start-3 bubble-green d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                    <i class="fa-solid fa-child"></i>
                                </span>
                                <select name="id_ninio" id="id_ninio" class="form-select bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" style="font-size: 14px; height: 42px;" required>
                                    @foreach($ninios as $n)
                                        <option value="{{ $n->id_ninio }}" {{ $familiar->id_ninio == $n->id_ninio ? 'selected' : '' }}>
                                            {{ $n->nom }} {{ $n->ap }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Botones de Acción Estilizados --}}
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('familiares.index') }}" class="btn btn-light rounded-3 fw-bold px-3 text-muted py-2" style="background-color: #f4f7fc; font-size: 13px;">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary rounded-3 fw-bold px-4 py-2 shadow-sm" style="background-color: #2e5bff; border: none; font-size: 13px;">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Actualizar Familiar
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('formEditFamiliar').addEventListener('submit', function(e) {
        e.preventDefault(); // Congelar el envío automático nativo de Laravel

        const dniInput = document.getElementById('DNI').value.trim();
        const dirInput = document.getElementById('dir').value.trim();
        const personaSelect = document.getElementById('id_persona');
        const ninioSelect = document.getElementById('id_ninio');

        // Instancia de alertas dinámicas con tu mezcla de Bootstrap
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
            },
            buttonsStyling: false
        });

        // 1. VALIDACIÓN LÓGICA: Comprobar campos de texto vacíos
        if (!dniInput || !dirInput) {
            swalWithBootstrapButtons.fire({
                title: "Campos Incompletos",
                text: "Por favor, el número de identificación DNI y la dirección de residencia son campos requeridos.",
                icon: "warning",
                confirmButtonText: "Completar"
            });
            return;
        }

        // 2. VALIDACIÓN LÓGICA COHERENTE: DNI Válido (No negativos ni cero)
        if (parseInt(dniInput) <= 0) {
            swalWithBootstrapButtons.fire({
                title: "DNI Inválido",
                text: "El número de identificación o DNI del tutor debe ser una cantidad numérica real mayor a 0.",
                icon: "error",
                confirmButtonText: "Corregir número"
            });
            return;
        }

        // Capturar los textos de las opciones seleccionadas
        const nombreTutor = personaSelect.options[personaSelect.selectedIndex].text.trim();
        const nombreNinio = ninioSelect.options[ninioSelect.selectedIndex].text.trim();

        // 3. ADVERTENCIA FINAL E INTERACCIÓN DE CONFIRMACIÓN
        swalWithBootstrapButtons.fire({
            title: "¿Guardar Modificaciones?",
            text: `Vas a actualizar el expediente de "${nombreTutor}" como familiar responsable de "${nombreNinio}".`,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, actualizar",
            cancelButtonText: "No, cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // Disparar envío de verdad a Laravel
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelado",
                    text: "Los datos del familiar responsable se mantienen intactos en el sistema.",
                    icon: "info",
                    confirmButtonText: "Ok"
                });
            }
        });
    });
</script>
@endsection