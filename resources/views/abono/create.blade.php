@extends("layouts.template")

@section("content")
<div class="row justify-content-center mt-3">
    <div class="col-12 col-md-8 col-lg-6">

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4">
                
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-light">
                    <div class="bubble-pink rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="fa-solid fa-money-bill-wave fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Registrar Abono</h5>
                        <small class="text-muted">Ingresa un nuevo pago a la cuenta del alumno</small>
                    </div>
                </div>

                <form action="{{ route('abonos.store') }}" method="post" id="formAbono">
                    @csrf

                    <div class="mb-3">
                        <label for="id_regcuenta" class="form-label fw-bold text-dark opacity-75 small">Cuenta de Registro</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 bg-light rounded-start-3 text-muted"><i class="fa-solid fa-file-invoice-dollar"></i></span>
                            <select class="form-select bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" id="id_regcuenta" name="id_regcuenta" style="font-size: 14px;">
                                <option value="">Seleccione una cuenta...</option>
                                @foreach($cuentas as $cuenta)
                                    <option value="{{ $cuenta->id_regcuenta }}">Cuenta: {{ $cuenta->cuenta }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="cantidad" class="form-label fw-bold text-dark opacity-75 small">Cantidad a Abonar ($)</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 bg-light rounded-start-3 text-muted"><i class="fa-solid fa-coins"></i></span>
                            <input type="number" step="0.01" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" id="cantidad" name="cantidad" placeholder="Ej: 500" style="font-size: 14px;">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="fecha" class="form-label fw-bold text-dark opacity-75 small">Fecha de Pago</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 bg-light rounded-start-3 text-muted"><i class="fa-regular fa-calendar-days"></i></span>
                            <input type="date" class="form-control bg-light border-0 rounded-end-3 py-2 text-dark fw-medium" id="fecha" name="fecha" value="{{ date('Y-m-d') }}" style="font-size: 14px;">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <a href="{{ route('abonos.index') }}" class="btn btn-light rounded-3 fw-bold px-3 text-muted py-2" style="background-color: #f4f7fc; font-size: 13px;">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary rounded-3 fw-bold px-4 py-2 shadow-sm" style="background-color: #2e5bff; border: none; font-size: 13px;">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Guardar Abono
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('formAbono').addEventListener('submit', function(e) {
        e.preventDefault(); // Pausar envío nativo

        const cuenta = document.getElementById('id_regcuenta').value;
        const cantidad = parseFloat(document.getElementById('cantidad').value);
        const fecha = document.getElementById('fecha').value;

        // Mezcla de botones con tus clases de Bootstrap
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
            },
            buttonsStyling: false
        });

        // 1. VALIDACIÓN: Campos vacíos
        if (!cuenta || isNaN(cantidad) || !fecha) {
            swalWithBootstrapButtons.fire({
                title: "Campos Incompletos",
                text: "Por favor, completa todos los campos del abono antes de guardar.",
                icon: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        // 2. VALIDACIÓN: Cantidad menor o igual a cero
        if (cantidad <= 0) {
            swalWithBootstrapButtons.fire({
                title: "Cantidad Inválida",
                text: "El monto a abonar debe ser una cantidad mayor a $0.00.",
                icon: "error",
                confirmButtonText: "Corregir monto"
            });
            return;
        }

        // 3. CONFIRMACIÓN INTERACTIVA FINAL
        swalWithBootstrapButtons.fire({
            title: "¿Confirmar transacción?",
            text: `Vas a registrar un abono por la cantidad de $${cantidad.toFixed(2)} con fecha de ${fecha}.`,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, registrar pago",
            cancelButtonText: "No, cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Envío real si pasa el control
                this.submit();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelado",
                    text: "No se ha realizado ningún cargo ni movimiento financiero.",
                    icon: "info",
                    confirmButtonText: "Ok"
                });
            }
        });
    });
</script>
@endsection