
@extends("layouts.template")

@section("content")

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">Lista de Personas</h4>
            </div>
            <div class="row">
                <div class="col-1">
                    <a  class="btn btn-success px-4 mt-4" href="{{url('personas/create')}}">
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
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($personas as $persona)
                        <tr>
                            <td class="fw-bold">{{$loop->index+1}}</td>
                            <td>{{$persona->nom}}</td>
                            <td>{{$persona->ap}}</td>
                            <td>{{$persona->am}}</td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{$persona->fecha_nac}}
                                </span>
                            </td>
                            <td>
                                <a  class="btn btn-warning px-4 mt-4" href="{{route("personas.edit",$persona)}}">
                                    Editar
                                </a>

                                <form action="{{route("personas.destroy",$persona)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"  class="btn btn-danger px-4 mt-4">
                                        Eliminar
                                    </button>
                                </form>
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
