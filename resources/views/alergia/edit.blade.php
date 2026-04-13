@extends("layouts.template")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">Editar Alergia</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{route('alergias.update', $alergia->id_alergia)}}" method="post">
                    @csrf
                    @method("PUT")

                    <div class="mb-3">
                        <label for="id_ninio" class="form-label">Niño</label>
                        <select class="form-select" name="id_ninio" id="id_ninio" required>
                            @foreach($ninios as $ninio)
                                {{-- Usamos nom, ap y am de la tabla personas --}}
                                <option value="{{$ninio->id_ninio}}" {{$alergia->id_ninio == $ninio->id_ninio ? 'selected' : ''}}>
                                    {{$ninio->nom}} {{$ninio->ap}} {{$ninio->am}} (Matrícula: {{$ninio->matricula}})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="id_ingrediente" class="form-label">Ingrediente</label>
                        <select class="form-select" name="id_ingrediente" id="id_ingrediente" required>
                            @foreach($ingredientes as $ingrediente)
                                {{-- Usamos 'nombre' de la tabla ingredientes --}}
                                <option value="{{$ingrediente->id_ingrediente}}" {{$alergia->id_ingrediente == $ingrediente->id_ingrediente ? 'selected' : ''}}>
                                    {{$ingrediente->nombre}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{route('alergias.index')}}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success px-4">Actualizar Alergia</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection