@extends("layouts.template")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">Control de Alergias</h4>
            </div>
            <div class="p-3">
                <a class="btn btn-success px-4" href="{{route('alergias.create')}}">
                    Registrar Nueva Alergia
                </a>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Niño</th>
                                <th>Ingrediente Alérgeno</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($alergias as $alergia)
                            <tr>
                                <td class="fw-bold">{{$loop->iteration}}</td>
                                {{-- Usamos los alias definidos en el controlador (nom, ap, am) --}}
                                <td>{{$alergia->nom}} {{$alergia->ap}} {{$alergia->am}}</td>
                                <td>
                                    <span class="badge bg-danger p-2">
                                        {{-- En la tabla ingredientes el campo es 'nombre' --}}
                                        {{$alergia->nombre_ingrediente}}
                                    </span>
                                </td>
                                <td>
                                    <a class="btn btn-warning btn-sm px-3" href="{{route('alergias.edit', $alergia->id_alergia)}}">
                                        Editar
                                    </a>

                                    <form action="{{route('alergias.destroy', $alergia->id_alergia)}}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm px-3" onclick="return confirm('¿Estás seguro de eliminar esta alerta de alergia?')">
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