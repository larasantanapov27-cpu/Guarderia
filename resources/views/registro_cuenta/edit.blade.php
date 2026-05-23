@extends("layouts.template")

@section("content")
<div class="row justify-content-center mt-3">
    <div class="col-12 col-md-8 col-lg-6">

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4">
                
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-light">
                    <div class="bubble-purple rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="fa-solid fa-file-invoice-dollar fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Editar Cuenta / Mensualidad</h5>
                        <small class="text-muted">Modifica los detalles financieros de la cuota asignada</small>
                    </div>
                </div>

                <form action="{{ route('registro_cuentas.update', $registro_cuenta->id_regcuenta) }}" method="POST" id="formEditCuenta">
                    @csrf
                    @method('PUT')
                    
                    {{-- Selección de Niño / Alumno (Burbuja Azul Pastel) --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark opacity-75 small">Niño / Alumno</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-blue d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;"><i class="fa-solid fa-child"></i></span>
                            <select name="id_fam" id="id_fam" class="form-select bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" style="font-size: 14px; height: 42px;" required>
                                @foreach($ninios as $n)
                                    <option value="{{ $n->id_fam }}" 
                                        {{ $registro_cuenta->id_fam == $n->id_fam ? 'selected' : '' }}>
                                        {{ $n->nom }} {{ $n->ap }} {{ $n->am }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Campo: Número de Cuenta (Burbuja Naranja Pastel) --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark opacity-75 small">Número de Cuenta / Folio</label>
                        <div class="input-group align-items-center">
                            <span class="input-group-text border-0 rounded-start-3 bubble-orange d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;"><i class="fa-solid fa-hashtag"></i></span>
                            <input type="number" name="cuenta" id="cuenta" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" value="{{ $registro_cuenta->cuenta }}" style="font-size: 14px; height: 42px;" required>
                        </div>
                    </div>

                    {{-- Botones de Acción Estilizados --}}
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('registro_cuentas.index') }}" class="btn btn-light rounded-3 fw-bold px-3 text-muted py-2" style="background-color: #f4f7fc; font-size: 13px;">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary rounded-3 fw-bold px-4 py-2 shadow-sm" style="background-color: #2e5bff; border: none; font-size: 13px;">
                            <i class="fa-solid fa-rotate me-1"></i> Actualizar Cuenta
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('formEditCuenta').addEventListener('submit', function(e) {
        e.preventDefault(); // Congelar envío nativo para validar primero

        const alumno = document.getElementById('id_fam').options[document.getElementById('id_fam').selectedIndex].text.trim();
        const cuentaInput = document.getElementById('cuenta').value.trim();

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
            },
            buttonsStyling: false
        });

        // 1. VALIDACIÓN: Campo de cuenta vacío
        if (!cuentaInput) {
            swalWithBootstrapButtons.fire({
                title: "Campo Vacío",
                text: "Por favor, define un número de cuenta o folio válido.",
                icon: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        // 2. VALIDACIÓN COHERENTE: No folios negativos
        if (parseInt(cuentaInput) < 0) {
            swalWithBootstrapButtons.fire({
                title: "Número de Cuenta Inválido",
                text: "El número de cuenta / folio no puede ser una cantidad negativa.",
                icon: "error",
                confirmButtonText: "Corregir número"
            });
            return;
        }

        // 3. CONFIRMACIÓN INTERACTIVA CON TUS BOTONES BSTRAP
        swalWithBootstrapButtons.fire({
            title: "¿Confirmar Cambios?",
            text: `Vas a actualizar el registro de cuenta asignado a "${alumno}" con el Folio N° ${cuentaInput}.`,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, actualizar",
            cancelButtonText: "No, cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // Enviar de verdad si pasa el filtro final
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Acción Cancelada",
                    text: "Los datos de la cuenta se mantienen intactos.",
                    icon: "info",
                    confirmButtonText: "Ok"
                });
            }
        });
    });
</script>
@endsection