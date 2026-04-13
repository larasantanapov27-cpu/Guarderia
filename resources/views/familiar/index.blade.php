@extends("layouts.template")

@section("content")
<div class="card shadow border-0">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Lista de Familiares</h4>
    </div>
    <div class="p-3">
        <a href="{{route('familiares.create')}}" class="btn btn-primary">Nuevo Familiar</a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Familiar</th>
                    <th>Parentesco</th>
                    <th>Niño Asignado</th>
                    <th>DNI</th>
                    <th>Dirección</th>
                </tr>
            </thead>
            <tbody>
                @foreach($familiares as $f)
                <tr>
                    <td>{{$f->nom_fam}} {{$f->ap_fam}}</td>
                    <td><span class="badge bg-info">{{$f->parentesco}}</span></td>
                    <td>{{$f->nom_ninio}} {{$f->ap_ninio}}</td>
                    <td>{{$f->DNI}}</td>
                    <td>{{$f->dir}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection