@extends("layouts.template")

@section("content")

<div class="row justify-content-center">
    <div class="col-md-7">

        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">Editar a {{$centro->nom}}</h4> {{-- ← sin 's' --}}
            </div>

            <div class="card-body p-4">
                <form action="{{route('centros.update', $centro)}}" method="post">
                    @csrf
                    @method("PUT")

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nombre del centro</label>
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Pequeños Sueños" value="{{$centro->nom}}">
                    </div>

                    <div class="mb-4">
                        <label for="costo" class="form-label">Costo mensual</label>
                        <input type="number" class="form-control" id="costo" name="costo" placeholder="1500" value="{{$centro->costo}}">
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