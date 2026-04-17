@extends("layouts.template")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">Historial de Abonos</h4>
            </div>
            <div class="p-3">
                <a class="btn btn-success px-4" href="{{route('abonos.create')}}">
                    Registrar Nuevo Abono
                </a>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Cantidad</th>
                                <th>Fecha</th>
                                <th>Nombre Nino</th>
                                <th>Nombre Familiar</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($abonos as $abono)
                            <tr>
                                <td class="fw-bold">{{$loop->index+1}}</td>
                                <td>
                                    <span class="badge bg-info text-dark">${{$abono->cantidad}}</span>
                                </td>
                                <td>{{$abono->fecha}}</td>
                                <td>{{$abono->nombre_ninio}}</td>
                                <td>{{$abono->nombre_tutor}}</td>

                                <td>
                                    <a class="btn btn-warning btn-sm px-3" href="{{route('abonos.edit', $abono->id_abono)}}">
                                        Editar
                                    </a>
                                    <form action="{{route('abonos.destroy', $abono->id_abono)}}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm px-3" onclick="return confirm('¿Eliminar abono?')">
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