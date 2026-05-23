@extends("layouts.template")

@section("content")
<div class="row justify-content-center mt-3">
    <div class="col-12 col-md-8 col-lg-6">

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4">
                
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-light">
                    <div class="bubble-purple rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="fa-solid fa-file-circle-plus fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Generar Nueva Cuenta</h5>
                        <small class="text-muted">Asigna un nuevo folio de cobro operativo a un alumno</small>
                    </div>
                </div>

                <form action="{{ route('registro_cuentas.store') }}" method="POST" id="formCreateCuenta">
                    @csrf
                    
                    {{-- Selección de Niño / Alumno (Burbuja Azul Pastel) --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark opacity-75 small">Seleccionar Niño / Alumno</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-blue d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;"><i class="fa-solid fa-child"></i></span>
                            <select name="id_fam" id="id_fam" class="form-select bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" style="font-size: 14px; height: 42px;" required>
                                <option value="" selected disabled>Elija un niño...</option>
                                @foreach($ninios as $n)
                                    <option value="{{ $n->id_fam }}">{{ $n->nom }} {{ $n->ap }} {{ $n->am }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Campo: Número de Cuenta (Burbuja Naranja Pastel) --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark opacity-75 small">Número de Cuenta / Folio Único</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-orange d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;"><i class="fa-solid fa-hashtag"></i></span>
                            <input type="number" name="cuenta" id="cuenta" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" placeholder="Ej: 5005" style="font-size: 14px; height: 42px;" required>
                        </div>
                    </div>

                    {{-- Botones de Acción Estilizados --}}
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <a href="{{ route('registro_cuentas.index') }}" class="btn btn-light rounded-3 fw-bold px-3 text-muted py-2" style="background-color: #f4f7fc; font-size: 13px;">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary rounded-3 fw-bold px-4 py-2 shadow-sm" style="background-color: #2e5bff; border: none; font-size: 13px;">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Registrar Cuenta
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('formCreateCuenta').addEventListener('submit', function(e) {
        e.preventDefault(); // Congelar envío automático de Laravel

        const familiarSelect = document.getElementById('id_fam');
        const cuentaInput = document.getElementById('cuenta').value.trim();

        // Estilos personalizados con tus clases de Bootstrap
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
            },
            buttonsStyling: false
        });

        // 1. COMPROBACIÓN: Validar si seleccionó un alumno
        if (familiarSelect.value === "") {
            swalWithBootstrapButtons.fire({
                title: "Falta Selección",
                text: "Por favor, selecciona un niño / alumno de la lista antes de continuar.",
                icon: "warning",
                confirmButtonText: "Elegir alumno"
            });
            return;
        }

        // 2. COMPROBACIÓN: Validar si el folio está vacío
        if (!cuentaInput) {
            swalWithBootstrapButtons.fire({
                title: "Folio Requerido",
                text: "El campo de número de cuenta no puede quedar vacío.",
                icon: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        // 3. COMPROBACIÓN COHERENTE: No números de cuenta negativos
        if (parseInt(cuentaInput) < 0) {
            swalWithBootstrapButtons.fire({
                title: "Número de Cuenta Inválido",
                text: "El número de cuenta o folio no puede ser un valor negativo.",
                icon: "error",
                confirmButtonText: "Corregir número"
            });
            return;
        }

        // Capturar texto del alumno seleccionado para la alerta
        const alumnoNombre = familiarSelect.options[familiarSelect.selectedIndex].text.trim();

        // 4. ADVERTENCIA E INTERACCIÓN CONFIRMACIÓN FINAL
        swalWithBootstrapButtons.fire({
            title: "¿Crear nuevo registro?",
            text: `Vas a dar de alta la cuenta Folio N° ${cuentaInput} asignada al alumno "${alumnoNombre}".`,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, registrar",
            cancelButtonText: "No, cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // Proceder con el envío real a Laravel
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelado",
                    text: "No se ha generado ninguna cuenta nueva en el sistema.",
                    icon: "info",
                    confirmButtonText: "Ok"
                });
            }
        });
    });
</script>
@endsection