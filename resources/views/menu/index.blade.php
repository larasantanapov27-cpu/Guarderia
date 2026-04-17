@extends("layouts.template")

@section("content")
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-secondary">Composición de Menús (Platos e Ingredientes)</h2>
        <a href="{{ route('menus.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Asignar Ingrediente
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
                        <th>Plato</th>
                        <th>Ingrediente</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                        <tr>
                            <td>{{ $menu->id_menu }}</td>
                            <td><strong>{{ $menu->nombre_plato }}</strong></td>
                            <td>{{ $menu->nombre_ingrediente }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('menus.edit', $menu->id_menu) }}" class="btn btn-sm btn-warning">
                                        Editar
                                    </a>
                                    <form action="{{ route('menus.destroy', $menu->id_menu) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Quitar este ingrediente del plato?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-3 text-muted">No hay ingredientes asignados a platos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection