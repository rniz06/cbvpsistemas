<div class="card">
    <div class="card-header">
        <h3 class="card-title">Listado de Usuarios Bomberos</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 10px"></th>
                    <th>Nombre Completo: <br> <input class="form-control form-control-sm" type="text" placeholder=""
                            wire:model.live="buscarNombrecompleto"></th>
                    <th>Codigo: <br> <input class="form-control form-control-sm" type="text" placeholder=""
                            wire:model.live="buscarCodigo"></th>
                    <th>Documento: <br> <input class="form-control form-control-sm" type="text" placeholder=""
                            wire:model.live="buscarDocumento"></th>
                    <th>Categoria: <br> <input class="form-control form-control-sm" type="text" placeholder=""
                            wire:model.live="buscarCategoria"></th>
                    <th>Compañia: <br> <input class="form-control form-control-sm" type="text" placeholder=""
                            wire:model.live="buscarCompania"></th>
                    <th>Roles: <br> <input class="form-control form-control-sm" type="text" placeholder=""
                            wire:model.live="buscarRoles"></th>
                    <th></th>
                </tr>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Nombre Completo:</th>
                    <th>Codigo</th>
                    <th>Documento:</th>
                    <th>Categoria:</th>
                    <th>Compañia:</th>
                    <th>Roles:</th>
                    <th style="width: 40px">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id_user ?? null }}</td>
                        <td>{{ $usuario->nombrecompleto ?? 'N/A' }}</td>
                        <td>{{ $usuario->codigo ?? 'N/A' }}</td>
                        <td>{{ $usuario->documento ?? 'N/A' }}</td>
                        <td>{{ $usuario->categoria ?? 'N/A' }}</td>
                        <td>{{ $usuario->compania ?? 'N/A' }}</td>
                        <td><span class="badge badge-secondary">{{ $usuario->roles ?? 'N/A' }}</span></td>
                        <td>
                            <!-- Small button groups (default and split) -->
                            <div class="btn-group">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-align-justify"></i>
                                </button>
                                <div class="dropdown-menu">
                                    @if (auth()->user()->can('Usuarios Asignar Roles'))
                                        <a class="dropdown-item" tabindex="-1" href="{{ route('usuarios.asignarrolevista', $usuario->id_user) }}"><i
                                                class="fas fa-eye pr-2" style="color: #6c757d"></i>Asignar Roles</a>
                                    @endif

                                    @if (auth()->user()->can('Usuarios Eliminar'))
                                        <form action="{{ route('usuarios.destroy', $usuario->id_user) }}"
                                            method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="dropdown-item"><i
                                                    class="fas fa-trash-alt pr-2"
                                                    style="color: #dc3545"></i>Eliminar</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center font-italic">Sin Registros coincidentes...</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix col-12">
        <center><select class="col-1 form-control form-contro-sm" wire:model.live="paginado">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select></center>
        {{ $usuarios->links() }}
    </div>
</div>
