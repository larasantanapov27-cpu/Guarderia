
@extends("layouts.template")

@section("content")

<div class="row justify-content-center">
    <div class="col-md-7">

        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0"> Editar a {{$persona->nom}}</h4>
            </div>

            <div class="card-body p-4">
                <form action="{{route("personas.update",$persona)}}" method="post">
                    @csrf
                    @method("PUT")
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="nom" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Juan" value="{{$persona->nom}}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ap" class="form-label">Apellido Paterno</label>
                            <input type="text" class="form-control" id="ap" name="ap" placeholder="Pérez" value="{{$persona->ap}}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="am" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" id="am" name="am" placeholder="García" value="{{$persona->am}}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="fecha_nac" class="form-label">Fecha de nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" value="{{$persona->fecha_nac}}">
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="reset" class="btn btn-outline-secondary">
                            Limpiar
                        </button>

                        <button type="submit" class="btn btn-success px-4">
                            Guardar
                        </button>
                    </div>

                </form>
            </div>

        </div>

    </div>
</div>

@endsection
