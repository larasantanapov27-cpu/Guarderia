@extends("layouts.template")

@section("content")
<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-warning text-dark text-center">
            <h5 class="mb-0">Editar Información del Niño</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('ninios.update', $ninio->id_ninio) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Matrícula</label>
                    <input type="number" name="matricula" class="form-control" value="{{ $ninio->matricula }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fecha de Ingreso</label>
                    <input type="date" name="fecha" class="form-control" value="{{ $ninio->fecha }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Persona (Datos Personales)</label>
                    <select name="id_persona" class="form-select" required>
                        @foreach($personas as $p)
                            <option value="{{ $p->id_persona }}" {{ $ninio->id_persona == $p->id_persona ? 'selected' : '' }}>
                                {{ $p->nom }} {{ $p->ap }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">Centro Asignado</label>
                    <select name="id_centro" class="form-select" required>
                        @foreach($centros as $c)
                            <option value="{{ $c->id_centro }}" {{ $ninio->id_centro == $c->id_centro ? 'selected' : '' }}>
                                {{ $c->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('ninios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-warning px-5">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection