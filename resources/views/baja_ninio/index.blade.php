@extends("layouts.template")

@section("content")
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-secondary">Historial de Bajas de Niños</h2>
        <a href="{{ route('baja_ninios.create') }}" class="btn btn-danger">
            <i class="fas fa-user-minus"></i> Registrar Nueva Baja
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow border-0">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Matrícula</th>
                        <th>Nombre del Niño</th>
                        <th>Fecha de Baja</th>
                        <th>Motivo</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bajas as $baja)
                        <tr>
                            <td>{{ $baja->id_baja }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $baja->matricula }}</span></td>
                            {{-- Concatenamos los nombres que vienen de la tabla personas --}}
                            <td>{{ $baja->nom }} {{ $baja->ap }} {{ $baja->am }}</td>
                            <td>{{ $baja->fecha }}</td>
                            <td>{{ $baja->motivo }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('baja_ninios.edit', $baja->id_baja) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    
                                    {{-- Formulario para eliminar (opcional) --}}
                                    <form action="{{ route('baja_ninios.destroy', $baja->id_baja) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar este registro?')">
                                            Borrar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No se han encontrado registros de bajas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection