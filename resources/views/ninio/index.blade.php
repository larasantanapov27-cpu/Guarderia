@extends("layouts.template")

@section("content")
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-secondary">Listado de Niños Inscritos</h2>
        <a href="{{ route('ninios.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Registrar Nuevo Niño
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
                        <th>Matrícula</th>
                        <th>Nombre Completo</th>
                        <th>Fecha Ingreso</th>
                        <th>Centro</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ninios as $n)
                        <tr>
                            <td><span class="badge bg-light text-dark border">{{ $n->matricula }}</span></td>
                            {{-- Estos campos vienen del JOIN con la tabla personas --}}
                            <td>{{ $n->nom }} {{ $n->ap }} {{ $n->am }}</td>
                            <td>{{ $n->fecha }}</td>
                            {{-- Este campo viene del JOIN con la tabla centros --}}
                            <td>{{ $n->centro_nombre }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('ninios.edit', $n->id_ninio) }}" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="{{ route('ninios.destroy', $n->id_ninio) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar registro?')">Borrar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-3 text-muted">No hay niños registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection