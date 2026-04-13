@extends("layouts.template")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">Nuevo Registro Familiar</div>
            <div class="card-body">
                <form action="{{route('familiares.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Persona (Familiar)</label>
                            <select name="id_persona" class="form-select" required>
                                @foreach($personas as $p)
                                    <option value="{{$p->id_persona}}">{{$p->nom}} {{$p->ap}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">DNI</label>
                            <input type="number" name="DNI" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dirección</label>
                        <input type="text" name="dir" class="form-control" placeholder="Máximo 100 caracteres" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Parentesco</label>
                            <select name="id_parentezco" class="form-select" required>
                                @foreach($parentezcos as $par)
                                    <option value="{{$par->id_parentezco}}">{{$par->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Asignar al Niño</label>
                            <select name="id_ninio" class="form-select" required>
                                @foreach($ninios as $n)
                                    <option value="{{$n->id_ninio}}">{{$n->nom}} {{$n->ap}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Guardar Familiar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection