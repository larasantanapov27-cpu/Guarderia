@extends("layouts.template")

@section("content")
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Historial de Alimentación</h4>
            <a href="{{ route('registro_comidas.create') }}" class="btn btn-success btn-sm">
                Registrar Nueva Comida
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Niño</th>
                            <th>Plato Consumido</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registros as $reg)
                        <tr>
                            <td class="text-muted">#{{ $reg->id_regcomida }}</td>
                            <td>{{ \Carbon\Carbon::parse($reg->fecha)->format('d/m/Y') }}</td>
                            <td><strong>{{ $reg->nombre_ninio }} {{ $reg->apellido_ninio }}</strong></td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $reg->nombre_plato }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('registro_comidas.edit', $reg->id_regcomida) }}" 
                                       class="btn btn-sm btn-outline-warning">
                                        Editar
                                    </a>
                                    <form action="{{ route('registro_comidas.destroy', $reg->id_regcomida) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('¿Eliminar este registro?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                No se han encontrado registros de comidas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection