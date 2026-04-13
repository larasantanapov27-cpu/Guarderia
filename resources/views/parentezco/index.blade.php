@extends("layouts.template")

@section("content")

<div class="row justify-content-center">
    <div class="col-md-6"> <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">Lista de Parentescos</h4>
            </div>
            
            <div class="row">
                <div class="col-1">
                    <a class="btn btn-success px-4 mt-4 ms-4" href="{{url('parentezcos/create')}}">
                        Registrar
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Parentesco</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($parentezcos as $parentezco)
                            <tr>
                                <td class="fw-bold">{{$loop->index + 1}}</td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{$parentezco->nombre}}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a class="btn btn-warning px-4" href="{{route('parentezcos.edit', $parentezco)}}">
                                            Editar
                                        </a>

                                        <form action="{{route('parentezcos.destroy', $parentezco)}}" method="post" onsubmit="return confirm('¿Estás seguro de eliminar este parentesco?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger px-4">
                                                Eliminar
                                            </button>
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