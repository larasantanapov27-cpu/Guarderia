@extends("layouts.template")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">Editar Abono #{{$abono->id_abono}}</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{route('abonos.update', $abono->id_abono)}}" method="post">
                    @csrf
                    @method("PUT")

                    <div class="mb-3">
                        <label for="id_regcuenta" class="form-label">Cuenta</label>
                        <select class="form-select" id="id_regcuenta" name="id_regcuenta" required>
                            @foreach($cuentas as $cuenta)
                                <option value="{{$cuenta->id_regcuenta}}" {{$abono->id_regcuenta == $cuenta->id_regcuenta ? 'selected' : ''}}>
                                    Cuenta: {{$cuenta->cuenta}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" value="{{$abono->cantidad}}" required>
                    </div>

                    <div class="mb-4">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" value="{{$abono->fecha}}" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="reset" class="btn btn-outline-secondary">Restablecer</button>
                        <button type="submit" class="btn btn-success px-4">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection