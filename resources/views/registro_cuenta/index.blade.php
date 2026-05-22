@extends("layouts.template")

@section("content")
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Estado de Cuentas (Mensualidades)</h4>
            <a href="{{ route('registro_cuentas.create') }}" class="btn btn-success btn-sm">
                Nueva Cuenta
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success border-0">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Familiar</th>
                            <th>Cuenta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cuentas as $cuenta)
                        <tr>
                            <td class="text-muted">#{{ $cuenta->id_regcuenta }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $cuenta->nombre_fam }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $cuenta->cuenta }}</span>
                            </td>
                            
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('registro_cuentas.edit', $cuenta->id_regcuenta) }}" 
                                       class="btn btn-sm btn-outline-warning">
                                        Editar
                                    </a>
                                    <form action="{{ route('registro_cuentas.destroy', $cuenta->id_regcuenta) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('¿Eliminar esta cuenta?')">
                                            Borrar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                No hay registros de cuentas pendientes.
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