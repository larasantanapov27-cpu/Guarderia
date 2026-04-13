@extends("layouts.template")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Registrar Consumo de Alimento</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('registro_comidas.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Seleccionar Niño</label>
                        <select name="id_ninio" class="form-select" required>
                            <option value="" selected disabled>Elija un niño...</option>
                            @foreach($ninios as $n)
                                <option value="{{ $n->id_ninio }}">{{ $n->nom }} {{ $n->ap }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Plato Consumido</label>
                        <select name="id_plato" class="form-select" required>
                            <option value="" selected disabled>Elija un plato...</option>
                            @foreach($platos as $p)
                                <option value="{{ $p->id_plato }}">{{ $p->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Guardar Registro</button>
                        <a href="{{ route('registro_comidas.index') }}" class="btn btn-light">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection