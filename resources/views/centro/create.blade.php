@extends("layouts.template")

@section("content")

<div class="row justify-content-center">
    <div class="col-md-7">

        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">Crear un centro</h4>
            </div>

            <div class="card-body p-4">
                <form action="{{url('centros')}}" method="post">
                    @csrf

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nombre del centro</label>
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Pequeños Sueños">
                    </div>

                    <div class="mb-4">
                        <label for="costo" class="form-label">Costo mensual</label>
                        <input type="number" class="form-control" id="costo" name="costo" placeholder="1500">
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