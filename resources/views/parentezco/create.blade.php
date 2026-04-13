@extends("layouts.template")

@section("content")

<div class="row justify-content-center">
    <div class="col-md-5"> <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">Crear un Parentesco</h4>
            </div>

            <div class="card-body p-4">
                <form action="{{url('parentezcos')}}" method="post">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="nombre" class="form-label">Tipo de Parentesco</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej. Tío, Primo, Tutor" required>
                        <div class="form-text">Ingresa el nombre de la relación familiar.</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{url('parentezcos')}}" class="btn btn-outline-secondary">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-success px-4">
                            Guardar Parentesco
                        </button>
                    </div>

                </form>
            </div>

        </div>

    </div>
</div>

@endsection