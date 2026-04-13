@extends("layouts.template")

@section("content")
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Generar Nueva Cuenta (Deuda)</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('registro_cuentas.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Seleccionar Niño</label>
                            <select name="id_ninio" class="form-select" required>
                                <option value="" selected disabled>Elija un niño...</option>
                                @foreach($ninios as $n)
                                    <option value="{{ $n->id_ninio }}">{{ $n->nom }} {{ $n->ap }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mes de la Cuota</label>
                            <select name="mes" class="form-select" required>
                                <option value="Enero">Enero</option>
                                <option value="Febrero">Febrero</option>
                                <option value="Marzo">Marzo</option>
                                <option value="Abril">Abril</option>
                                <option value="Mayo">Mayo</option>
                                <option value="Junio">Junio</option>
                                <option value="Julio">Julio</option>
                                <option value="Agosto">Agosto</option>
                                <option value="Septiembre">Septiembre</option>
                                <option value="Octubre">Octubre</option>
                                <option value="Noviembre">Noviembre</option>
                                <option value="Diciembre">Diciembre</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Monto a Pagar ($)</label>
                            <input type="number" name="monto" class="form-control" step="0.01" placeholder="0.00" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Registrar Cuenta</button>
                            <a href="{{ route('registro_cuentas.index') }}" class="btn btn-light">Regresar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection