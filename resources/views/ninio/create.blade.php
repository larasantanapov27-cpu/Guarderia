@extends("layouts.template")

@section("content")
<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white">
            <h5>Registrar Niño</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('ninios.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Matrícula</label>
                    <input type="number" name="matricula" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Fecha de Ingreso</label>
                    <input type="date" name="fecha" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Seleccionar Persona (Niño)</label>
                    <select name="id_persona" class="form-select" required>
                        @foreach($personas as $p)
                            {{-- Usamos 'nom' y 'ap' según tu SQL --}}
                            <option value="{{ $p->id_persona }}">{{ $p->nom }} {{ $p->ap }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label>Asignar Centro</label>
                    <select name="id_centro" class="form-select" required>
                        @foreach($centros as $c)
                            {{-- En centros la columna es 'nom' --}}
                            <option value="{{ $c->id_centro }}">{{ $c->nom }} (Costo: ${{ $c->costo }})</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">Guardar</button>
            </form>
        </div>
    </div>
</div>
@endsection