<div class="card">
    <div class="card-header">
        <h3 class="card-title">Listado de Personales @can('Personal Exportar Excel')
                <button class="btn btn-sm btn-secondary" wire:click="excel"><i class="fas fa-file-export"></i>
                    Exportar</button>
            @endcan
            @can('Personal Crear')
                <a href="{{ route('personal.create') }}" class="btn btn-sm btn-success"><i class="fas fa-plus"></i>Registrar
                    Personal</a>
            @endcan
        </h3>
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
                    <th>Fecha Juramento: <br> <input class="form-control form-control-sm" type="text" placeholder=""
                            wire:model.live="buscarFechajuramento"></th>
                    <th>Categoria: <br> <select class="form-control form-control-sm"
                            wire:model.live="buscarCategoriaId">
                            <option value="">Todos</option>
                            @forelse ($categorias as $categoria)
                                <option value="{{ $categoria->idpersonal_categorias ?? '0' }}">
                                    {{ $categoria->categoria ?? 'S/D' }}</option>
                            @empty
                                <option value="">Sin datos...</option>
                            @endforelse
                        </select>
                    </th>
                    <th>Estado: <br> <select class="form-control form-control-sm" wire:model.live="buscarEstadoId">
                            <option value="">Todos</option>
                            @forelse ($estados as $estado)
                                <option value="{{ $estado->idpersonal_estados ?? '0' }}">
                                    {{ $estado->estado ?? 'S/D' }}</option>
                            @empty
                                <option value="">Sin datos...</option>
                            @endforelse
                        </select></th>
                    <th>Actualizar: <br> <select class="form-control form-control-sm"
                            wire:model.live="buscarEstadoActualizarId">
                            <option value="">Todos</option>
                            @forelse ($estados_actualizar as $estado_actualizar)
                                <option value="{{ $estado_actualizar->idpersonal_estado_actualizar ?? '0' }}">
                                    {{ $estado_actualizar->estado ?? 'S/D' }}</option>
                            @empty
                                <option value="">Sin datos...</option>
                            @endforelse
                        </select></th>
                    <th>Pais: <br> <select class="form-control form-control-sm" wire:model.live="buscarPaisId">
                            <option value="">Todos</option>
                            @forelse ($paises as $pais)
                                <option value="{{ $pais->idpaises ?? '0' }}">
                                    {{ $pais->pais ?? 'S/D' }}</option>
                            @empty
                                <option value="">Sin datos...</option>
                            @endforelse
                        </select></th>
                    <th>Sexo: <br> <select class="form-control form-control-sm" wire:model.live="buscarSexoId">
                            <option value="">Todos</option>
                            @forelse ($sexos as $sexo)
                                <option value="{{ $sexo->idpersonal_sexo ?? '0' }}">
                                    {{ $sexo->sexo ?? 'S/D' }}</option>
                            @empty
                                <option value="">Sin datos...</option>
                            @endforelse
                        </select></th>
                    <th>G. Sanguineo: <br> <select class="form-control form-control-sm"
                            wire:model.live="buscarGrupoSanguineoId">
                            <option value="">Todos</option>
                            @forelse ($gruposSanguineos as $grupoSanguineo)
                                <option value="{{ $grupoSanguineo->idpersonal_grupo_sanguineo ?? '0' }}">
                                    {{ $grupoSanguineo->grupo_sanguineo ?? 'S/D' }}</option>
                            @empty
                                <option value="">Sin datos...</option>
                            @endforelse
                        </select></th>
                    @unless (Auth::user()->hasRole('personal_moderador_compania') || Auth::user()->hasRole('personal_moderador_por_compania'))
                        <th>Compañia: <br> <select class="form-control form-control-sm" wire:model.live="buscarCompaniaId">
                                <option value="">Todos</option>
                                @forelse ($companias as $compania)
                                    <option value="{{ $compania->idcompanias ?? '0' }}">
                                        {{ $compania->compania ?? 'S/D' }}</option>
                                @empty
                                    <option value="">Sin datos...</option>
                                @endforelse
                            </select></th>
                    @endunless
                    <th></th>
                </tr>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Nombre Completo:</th>
                    <th>Codigo</th>
                    <th>Documento:</th>
                    <th>Fecha Juramento:</th>
                    <th>Categoria:</th>
                    <th>Estado:</th>
                    <th>Actualizar:</th>
                    <th>Pais:</th>
                    <th>Sexo:</th>
                    <th>Grupo Sanguineo:</th>
                    <th>Compañia:</th>
                    <th style="width: 40px">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($personales as $personal)
                    <tr>
                        <td>#</td>
                        <td>{{ $personal->nombrecompleto ?? 'N/A' }}</td>
                        <td>{{ $personal->codigo ?? 'N/A' }}</td>
                        <td>{{ $personal->documento ?? 'N/A' }}</td>
                        <td>{{ $personal->fecha_juramento ?? 'N/A' }}</td>
                        <td>{{ $personal->categoria ?? 'N/A' }}</td>
                        <td>{{ $personal->estado ?? 'N/A' }}</td>
                        <td>{{ $personal->estado_actualizar ?? 'N/A' }}</td>
                        <td>{{ $personal->pais ?? 'N/A' }}</td>
                        <td>{{ $personal->sexo ?? 'N/A' }}</td>
                        <td>{{ $personal->grupo_sanguineo ?? 'N/A' }}</td>
                        <td>{{ $personal->compania ?? 'N/A' }}</td>
                        <td>
                            <x-dropdown>
                                @if (auth()->user()->can('Personal Ver'))
                                    <x-slot name="show">{{ route('personal.show', $personal->idpersonal) }}</x-slot>
                                @endif

                                @if (auth()->user()->can('Personal Cambiar Codigo'))
                                    <x-slot
                                        name="cambiarCodigo">{{ route('personal.cambiarCodigo', $personal->idpersonal) }}</x-slot>
                                @endif

                                @if (auth()->user()->can('Personal Generar Ficha'))
                                    <x-slot
                                        name="ficha">{{ route('personal.fichapdf', $personal->idpersonal) }}</x-slot>
                                @endif

                                @if (auth()->user()->can('Personal Editar'))
                                    <x-slot name="edit">{{ route('personal.edit', $personal->idpersonal) }}</x-slot>
                                @endif

                                @if (auth()->user()->can('Personal Eliminar'))
                                    <x-slot name="action">#</x-slot>
                                @endif

                                @can('Personal Comisionamientos Create')
                                    <x-slot
                                        name="comisionamiento">{{ route('personal.comisionamientos.create', $personal->idpersonal) }}</x-slot>
                                @endcan
                            </x-dropdown>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="text-center font-italic">Sin Registros coincidentes...</td>
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
        {{ $personales->links() }}
    </div>
</div>
