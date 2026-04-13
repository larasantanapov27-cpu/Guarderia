@extends("layouts.template")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow border-0">
            <div class="card-header bg-warning text-dark text-center">
                <h4 class="mb-0">Editar Registro de Comida</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('registro_comidas.update', $registroComida->id_regcomida) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Niño</label>
                        <select name="id_ninio" class="form-select" required>
                            @foreach($ninios as $n)
                                <option value="{{ $n->id_ninio }}" 
                                    {{ $registroComida->id_ninio == $n->id_ninio ? 'selected' : '' }}>
                                    {{ $n->nom }} {{ $n->ap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Plato Consumido</label>
                        <select name="id_plato" class="form-select" required>
                            @foreach($platos as $p)
                                <option value="{{ $p->id_plato }}"
                                    {{ $registroComida->id_plato == $p->id_plato ? 'selected' : '' }}>
                                    {{ $p->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Fecha del Registro</label>
                        <input type="date" name="fecha" class="form-control" 
                               value="{{ $registroComida->fecha }}" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('registro_comidas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning px-4">Actualizar Registro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection