@extends("layouts.template")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">Asignar Ingrediente a Plato</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('menus.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="id_plato" class="form-label">Seleccionar Plato</label>
                        <select name="id_plato" id="id_plato" class="form-select" required>
                            <option value="">Seleccione un plato</option>
                            @foreach($platos as $plato)
                                <option value="{{ $plato->id_plato }}">{{ $plato->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="id_ingrediente" class="form-label">Seleccionar Ingrediente</label>
                        <select name="id_ingrediente" id="id_ingrediente" class="form-select" required>
                            <option value="">Seleccione un ingrediente</option>
                            @foreach($ingredientes as $ingrediente)
                                <option value="{{ $ingrediente->id_ingrediente }}">{{ $ingrediente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('menus.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success px-4">Guardar Relación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection