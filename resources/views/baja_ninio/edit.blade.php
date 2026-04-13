@extends("layouts.template")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-warning text-dark text-center">
                <h4 class="mb-0">Editar Registro de Baja</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('baja_ninios.update', $baja->id_baja) }}" method="post">
                    @csrf
                    @method("PUT")
                    
                    <div class="mb-3">
                        <label for="id_ninio" class="form-label">Niño</label>
                        <select class="form-select" name="id_ninio" id="id_ninio" required>
                            @foreach($ninios as $ninio)
                                <option value="{{ $ninio->id_ninio }}" {{ $baja->id_ninio == $ninio->id_ninio ? 'selected' : '' }}>
                                    {{ $ninio->nom }} {{ $ninio->ap }} {{ $ninio->am }} (Matrícula: {{ $ninio->matricula }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha de Baja</label>
                        <input type="date" class="form-control" name="fecha" id="fecha" value="{{ $baja->fecha }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="motivo" class="form-label">Motivo de la Baja</label>
                        <textarea class="form-control" name="motivo" id="motivo" rows="3" required maxlength="100">{{ $baja->motivo }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('baja_ninios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning px-4">Actualizar Registro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection