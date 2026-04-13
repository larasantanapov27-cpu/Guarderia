@extends("layouts.template")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-warning text-dark text-center">
                <h4 class="mb-0">Editar Composición del Plato</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('menus.update', $menu->id_menu) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="id_plato" class="form-label">Plato</label>
                        <select name="id_plato" id="id_plato" class="form-select" required>
                            @foreach($platos as $plato)
                                <option value="{{ $plato->id_plato }}" 
                                    {{ $menu->id_plato == $plato->id_plato ? 'selected' : '' }}>
                                    {{ $plato->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="id_ingrediente" class="form-label">Ingrediente</label>
                        <select name="id_ingrediente" id="id_ingrediente" class="form-select" required>
                            @foreach($ingredientes as $ingrediente)
                                <option value="{{ $ingrediente->id_ingrediente }}"
                                    {{ $menu->id_ingrediente == $ingrediente->id_ingrediente ? 'selected' : '' }}>
                                    {{ $ingrediente->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('menus.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning px-4">Actualizar Relación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection