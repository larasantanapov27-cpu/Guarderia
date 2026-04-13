@extends("layouts.template")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">Menú de Platos</h4>
            </div>
            <div class="p-4">
                <a class="btn btn-success px-4" href="{{route('platos.create')}}">Registrar Plato</a>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Platillo</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($platos as $plato)
                            <tr>
                                <td class="fw-bold">{{$loop->index+1}}</td>
                                <td>{{$plato->nombre}}</td>
                                <td><span class="badge bg-primary">${{number_format($plato->precio, 2)}}</span></td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a class="btn btn-warning" href="{{route('platos.edit', $plato)}}">Editar</a>
                                        <form action="{{route('platos.destroy', $plato)}}" method="post" onsubmit="return confirm('¿Eliminar plato?')">
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