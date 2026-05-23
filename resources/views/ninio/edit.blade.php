@extends("layouts.template")

@section("content")
<div class="row justify-content-center mt-3">
    <div class="col-12 col-md-8 col-lg-6">

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4">
                
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-light">
                    <div class="bubble-purple rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="fa-solid fa-child-reaching fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Editar Información del Niño</h5>
                        <small class="text-muted">Modifica el expediente o la asignación de plantel del alumno</small>
                    </div>
                </div>

                <form action="{{ route('ninios.update', $ninio->id_ninio) }}" method="POST" id="formEditNinio">
                    @csrf
                    @method('PUT')

                    {{-- Input: Matrícula (Burbuja Azul Pastel) --}}
                    <div class="mb-3">
                        <label for="matricula" class="form-label fw-bold text-dark opacity-75 small">Matrícula Escolar</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-blue d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-id-card-clip"></i>
                            </span>
                            <input type="number" name="matricula" id="matricula" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" value="{{ $ninio->matricula }}" style="font-size: 14px; height: 42px;" required>
                        </div>
                    </div>

                    {{-- Input: Fecha de Ingreso (Burbuja Naranja Pastel) --}}
                    <div class="mb-3">
                        <label for="fecha" class="form-label fw-bold text-dark opacity-75 small">Fecha de Ingreso</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-orange d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-regular fa-calendar-plus"></i>
                            </span>
                            <input type="date" name="fecha" id="fecha" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" value="{{ $ninio->fecha }}" style="font-size: 14px; height: 42px;" required>
                        </div>
                    </div>

                    {{-- Select: Persona / Datos Personales (Burbuja Verde Pastel) --}}
                    <div class="mb-3">
                        <label for="id_persona" class="form-label fw-bold text-dark opacity-75 small">Persona (Datos Personales)</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-green d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <select name="id_persona" id="id_persona" class="form-select bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" style="font-size: 14px; height: 42px;" required>
                                @foreach($personas as $p)
                                    <option value="{{ $p->id_persona }}" {{ $ninio->id_persona == $p->id_persona ? 'selected' : '' }}>
                                        {{ $p->nom }} {{ $p->ap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Select: Centro Asignado (Burbuja Azul Pastel) --}}
                    <div class="mb-4">
                        <label for="id_centro" class="form-label fw-bold text-dark opacity-75 small">Centro Asignado / Plantel</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-blue d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-school"></i>
                            </span>
                            <select name="id_centro" id="id_centro" class="form-select bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" style="font-size: 14px; height: 42px;" required>
                                @foreach($centros as $c)
                                    <option value="{{ $c->id_centro }}" {{ $ninio->id_centro == $c->id_centro ? 'selected' : '' }}>
                                        {{ $c->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Botones de Acción Estilizados --}}
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <a href="{{ route('ninios.index') }}" class="btn btn-light rounded-3 fw-bold px-3 text-muted py-2" style="background-color: #f4f7fc; font-size: 13px;">
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
    document.getElementById('formEditNinio').addEventListener('submit', function(e) {
        e.preventDefault(); // Pausar envío nativo para validar primero

        const matriculaInput = document.getElementById('matricula').value.trim();
        const fechaInput = document.getElementById('fecha').value;
        const personaSelect = document.getElementById('id_persona');
        const centroSelect = document.getElementById('id_centro');

        // Instancia de SweetAlert2 combinando tus clases personalizadas de Bootstrap
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
            },
            buttonsStyling: false
        });

        // 1. COMPROBACIÓN: Campos obligatorios vacíos
        if (!matriculaInput || !fechaInput) {
            swalWithBootstrapButtons.fire({
                title: "Campos Incompletos",
                text: "Por favor, la matrícula y la fecha de ingreso no pueden quedar vacías.",
                icon: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        // 2. COMPROBACIÓN COHERENTE: Matrículas válidas
        if (parseInt(matriculaInput) <= 0) {
            swalWithBootstrapButtons.fire({
                title: "Matrícula Inválida",
                text: "El número de matrícula escolar del alumno debe ser un valor real mayor a 0.",
                icon: "error",
                confirmButtonText: "Corregir matrícula"
            });
            return;
        }

        // Extraer textos para el mensaje interactivo
        const nombreNinio = personaSelect.options[personaSelect.selectedIndex].text.trim();
        const nombreCentro = centroSelect.options[centroSelect.selectedIndex].text.trim();

        // 3. ADVERTENCIA E INTERACCIÓN CONFIRMACIÓN FINAL
        swalWithBootstrapButtons.fire({
            title: "¿Confirmar Cambios?",
            text: `Vas a guardar las modificaciones en el expediente de "${nombreNinio}" asignado al centro "${nombreCentro}".`,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, guardar",
            cancelButtonText: "No, cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // Proceder con el envío de verdad a Laravel si pasa el filtro
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelado",
                    text: "Las especificaciones del alumno se mantienen intactas.",
                    icon: "info",
                    confirmButtonText: "Ok"
                });
            }
        });
    });
</script>
@endsection