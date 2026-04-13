@extends("layouts.template")

@section("content")
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-warning text-dark text-center">
                    <h5 class="mb-0">Editar Cuenta / Mensualidad</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('registro_cuentas.update', $registro_cuenta->id_regcuenta) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        {{-- Selección de Niño --}}
                        <div class="mb-3">
                            <label class="form-label">Niño / Alumno</label>
                            <select name="id_ninio" class="form-select" required>
                                @foreach($ninios as $n)
                                    <option value="{{ $n->id_ninio }}" 
                                        {{ $registro_cuenta->id_ninio == $n->id_ninio ? 'selected' : '' }}>
                                        {{ $n->nom }} {{ $n->ap }} {{ $n->am }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Selección de Mes --}}
                        <div class="mb-3">
                            <label class="form-label">Mes de la Cuota</label>
                            @php
                                $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                                          'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                            @endphp
                            <select name="mes" class="form-select" required>
                                @foreach($meses as $m)
                                    <option value="{{ $m }}" {{ $registro_cuenta->mes == $m ? 'selected' : '' }}>
                                        {{ $m }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Monto --}}
                        <div class="mb-4">
                            <label class="form-label">Monto de la Deuda ($)</label>
                            <input type="number" name="monto" class="form-control" step="0.01" 
                                   value="{{ $registro_cuenta->monto }}" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('registro_cuentas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-warning px-4">Actualizar Cuenta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection