@extends("layouts.template")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-danger text-white text-center">
                <h4 class="mb-0">Registrar Baja de Niño</h4>
            </div>
            <div class="card-body p-4">
                {{-- Asegúrate de que la ruta coincida con tu archivo de web.php --}}
                <form action="{{ route('baja_ninios.store') }}" method="post">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="id_ninio" class="form-label">Niño a dar de baja</label>
                        <select class="form-select" name="id_ninio" id="id_ninio" required>
                            <option value="">Seleccione el niño...</option>
                            @foreach($ninios as $ninio)
                                <option value="{{ $ninio->id_ninio }}">
                                    {{-- Accedemos a los campos de la tabla 'personas' que traeremos desde el controlador --}}
                                    {{ $ninio->nom }} {{ $ninio->ap }} {{ $ninio->am }} (Matrícula: {{ $ninio->matricula }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha de Baja</label>
                        {{-- El campo en la DB es varchar(100), pero usar type="date" es lo ideal para el usuario --}}
                        <input type="date" class="form-control" name="fecha" id="fecha" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="motivo" class="form-label">Motivo de la Baja</label>
                        <textarea class="form-control" name="motivo" id="motivo" rows="3" placeholder="Ej: cambio de domicilio" required maxlength="100"></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('baja_ninios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-danger px-4">Confirmar Baja</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection