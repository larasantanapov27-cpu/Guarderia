@extends("layouts.template")

@section("content")

<div class="row justify-content-center">
    <div class="col-md-5">

        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0"> Editar Parentesco: {{$parentezco->nombre}}</h4>
            </div>

            <div class="card-body p-4">
                <form action="{{route('parentezcos.update', $parentezco)}}" method="post">
                    @csrf
                    @method("PUT")
                    
                    <div class="mb-4">
                        <label for="nombre" class="form-label">Nombre del Parentesco</label>
                        <input type="text" 
                               class="form-control" 
                               id="nombre" 
                               name="nombre" 
                               placeholder="Ej. Madre" 
                               value="{{$parentezco->nombre}}" 
                               required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{url('parentezcos')}}" class="btn btn-outline-secondary">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-success px-4">
                            Actualizar
                        </button>
                    </div>

                </form>
            </div>

        </div>

    </div>
</div>

@endsection