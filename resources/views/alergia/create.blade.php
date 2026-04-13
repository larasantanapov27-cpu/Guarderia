@extends("layouts.template")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">Nueva Alergia</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{route('alergias.store')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="id_ninio" class="form-label">Seleccionar Niño</label>
                        <select class="form-select" name="id_ninio" id="id_ninio" required>
                            <option value="">Elija un niño...</option>
                            @foreach($ninios as $ninio)
                                {{-- Corrección: Tu SQL usa 'nom', 'ap' (paterno) y 'am' (materno) --}}
                                <option value="{{$ninio->id_ninio}}">
                                    {{$ninio->nom}} {{$ninio->ap}} {{$ninio->am}} (Matrícula: {{$ninio->matricula}})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="id_ingrediente" class="form-label">Ingrediente Alérgeno</label>
                        <select class="form-select" name="id_ingrediente" id="id_ingrediente" required>
                            <option value="">Elija el ingrediente...</option>
                            @foreach($ingredientes as $ingrediente)
                                {{-- Corrección: En la tabla ingredientes la columna es 'nombre' --}}
                                <option value="{{$ingrediente->id_ingrediente}}">
                                    {{$ingrediente->nombre}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{route('alergias.index')}}" class="btn btn-outline-secondary">Volver</a>
                        <button type="submit" class="btn btn-success px-4">Guardar Alergia</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection