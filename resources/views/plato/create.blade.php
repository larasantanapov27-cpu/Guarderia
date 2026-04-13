@extends("layouts.template")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">Nuevo Plato</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{route('platos.store')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Platillo</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Ej. Sopa de verduras" required>
                    </div>
                    <div class="mb-4">
                        <label for="precio" class="form-label">Precio ($)</label>
                        <input type="number" step="0.01" class="form-control" name="precio" placeholder="0.00" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{route('platos.index')}}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success px-4">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection