<!-- Tabla -->
<x-tabla titulo="Listado de Usuarios Bomberos" excel pdf>
    <x-slot name="headerBotones">
        @can('Usuarios Crear')
            <a href="{{ route('usuarios.create') }}" class="btn btn-sm btn-success"><i class="fas fa-plus"></i>
                Agregar</a>
        @endcan
    </x-slot>
    <x-slot name="cabeceras">
        {{-- Nombre Completo --}}
        <th>
            <div>
                <x-adminlte-input name="buscarNombrecompleto" label="Nombre Completo:" placeholder="Compañia..."
                    fgroup-class="col-md-12" wire:model.live.debounce.250ms="buscarNombrecompleto" />
            </div>
        </th>
        {{-- Codigo --}}
        <th>
            <div>
                <x-adminlte-input name="buscarCodigo" label="Código:" placeholder="Código..." fgroup-class="col-md-12"
                    wire:model.live.debounce.250ms="buscarCodigo" />
            </div>
        </th>
        {{-- Documento --}}
        <th>
            <div>
                <x-adminlte-input name="buscarDocumento" label="Documento:" placeholder="Documento..."
                    fgroup-class="col-md-12" wire:model.live.debounce.250ms="buscarDocumento" />
            </div>
        </th>
        <th>
            <div>
                <x-adminlte-select name="buscarCategoriaId" label="Categoria:"
                    wire:model.live.debounce.250ms="buscarCategoriaId" fgroup-class="col-md-12">
                    <option value="">-- Todos --</option>
                    @forelse ($categorias as $categoria)
                        <option value="{{ $categoria->idpersonal_categorias ?? 'S/D' }}">
                            {{ $categoria->categoria ?? 'S/D' }}</option>
                    @empty
                        <option>Sin datos...</option>
                    @endforelse
                </x-adminlte-select>
            </div>
        </th>
        <th>
            <div>
                <x-adminlte-select name="buscarCompaniaId" label="Compañia:"
                    wire:model.live.debounce.250ms="buscarCompaniaId" fgroup-class="col-md-12">
                    <option value="">-- Todos --</option>
                    @forelse ($companias as $compania)
                        <option value="{{ $compania->id_compania ?? 'S/D' }}">{{ $compania->compania ?? 'S/D' }}
                        </option>
                    @empty
                        <option>Sin datos...</option>
                    @endforelse
                </x-adminlte-select>
            </div>
        </th>
        <th>
            <div>
                <x-adminlte-select name="buscarRoles" label="Roles:" wire:model.live.debounce.250ms="buscarRoles"
                    fgroup-class="col-md-12">
                    <option value="">-- Todos --</option>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->name }}">
                            {{ $rol->name ?? 'N/A' }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </div>
        </th>
        <th>U. Acceso</th>
    </x-slot>

    @forelse ($usuarios as $usuario)
        <tr>
            <td>{{ $usuario->nombrecompleto ?? 'N/A' }}</td>
            <td>{{ $usuario->codigo ?? 'N/A' }}</td>
            <td>{{ $usuario->documento ?? 'N/A' }}</td>
            <td>{{ $usuario->categoria ?? 'N/A' }}</td>
            <td>{{ $usuario->compania ?? 'N/A' }}</td>
            <td><span class="badge badge-secondary">{{ $usuario->roles ?? 'Sin Roles' }}</span></td>
            <td>{{ optional($usuario->ultimo_acceso)->format('d/m/Y H:i:s') ?? 'S/D' }}</td>
            <td>
                <!-- Small button groups (default and split) -->
                <div class="btn-group">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-align-justify"></i>
                    </button>
                    <div class="dropdown-menu">
                        @if (auth()->user()->can('Usuarios Asignar Roles'))
                            <a class="dropdown-item" tabindex="-1"
                                href="{{ route('usuarios.asignarrolevista', $usuario->id_usuario) }}"><i
                                    class="fas fa-user-tag pr-2" style="color: #6c757d"></i>Asignar
                                Roles</a>
                        @endif

                        @if (auth()->user()->can('Usuarios Asignar Permisos'))
                            <a class="dropdown-item" tabindex="-1"
                                href="{{ route('usuarios.asignarpermisovista', $usuario->id_usuario) }}"><i
                                    class="fas fa-user-lock pr-2" style="color: #6c757d"></i>Asignar
                                Permisos</a>
                        @endif

                        @if (auth()->user()->can('Usuarios Resetear Contrasena'))
                            <a class="dropdown-item" tabindex="-1"
                                href="{{ route('usuarios.passwordreset', $usuario->id_usuario) }}"><i
                                    class="fas fa-unlock-alt pr-2" style="color: #6c757d"></i>Resetear
                                Contraseña</a>
                        @endif

                        @if (auth()->user()->can('Usuarios Eliminar'))
                            <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="dropdown-item"><i class="fas fa-trash-alt pr-2"
                                        style="color: #dc3545"></i>Eliminar</button>
                            </form>
                        @endif
                    </div>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="100%" class="text-center font-italic">Sin Registros coincidentes...</td>
        </tr>
    @endforelse

    <x-slot name="paginacion">
        {{ $usuarios->links() }}
    </x-slot>
</x-tabla>