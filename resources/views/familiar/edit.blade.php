@extends("layouts.template")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-warning text-dark text-center">
                <h4 class="mb-0">Editar Familiar</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('familiares.update', $familiar->id_fam) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Persona (Familiar)</label>
                            <select name="id_persona" class="form-select" required>
                                @foreach($personas as $p)
                                    <option value="{{ $p->id_persona }}" {{ $familiar->id_persona == $p->id_persona ? 'selected' : '' }}>
                                        {{ $p->nom }} {{ $p->ap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">DNI</label>
                            <input type="number" name="DNI" class="form-control" value="{{ $familiar->DNI }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dirección</label>
                        <input type="text" name="dir" class="form-control" value="{{ $familiar->dir }}" maxlength="100" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Parentesco</label>
                            <select name="id_parentezco" class="form-select" required>
                                @foreach($parentezcos as $par)
                                    <option value="{{ $par->id_parentezco }}" {{ $familiar->id_parentezco == $par->id_parentezco ? 'selected' : '' }}>
                                        {{ $par->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Niño Asignado</label>
                            <select name="id_ninio" class="form-select" required>
                                @foreach($ninios as $n)
                                    <option value="{{ $n->id_ninio }}" {{ $familiar->id_ninio == $n->id_ninio ? 'selected' : '' }}>
                                        {{ $n->nom }} {{ $n->ap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('familiares.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning px-5">Actualizar Familiar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection