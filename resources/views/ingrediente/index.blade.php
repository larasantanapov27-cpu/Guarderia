@extends("layouts.template")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">Inventario de Ingredientes</h4>
            </div>
            <div class="p-4">
                <a class="btn btn-success px-4" href="{{route('ingredientes.create')}}">Nuevo Ingrediente</a>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($ingredientes as $ingrediente)
                            <tr>
                                <td class="fw-bold">{{$loop->index+1}}</td>
                                <td>{{$ingrediente->nombre}}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a class="btn btn-warning" href="{{route('ingredientes.edit', $ingrediente)}}">Editar</a>
                                        <form action="{{route('ingredientes.destroy', $ingrediente)}}" method="post" onsubmit="return confirm('¿Eliminar ingrediente?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection