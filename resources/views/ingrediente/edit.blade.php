@extends("layouts.template")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">Editar: {{$ingrediente->nombre}}</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{route('ingredientes.update', $ingrediente)}}" method="post">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label for="nombre" class="form-label">Nombre del Ingrediente</label>
                        <input type="text" class="form-control" name="nombre" value="{{$ingrediente->nombre}}" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{route('ingredientes.index')}}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success px-4">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection