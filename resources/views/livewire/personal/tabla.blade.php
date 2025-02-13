<div class="card">
    <div class="card-header">
        <h3 class="card-title">Listado de Personales @can('Personal Exportar Excel')
                <a href="{{ route('personal.exportar') }}" class="btn btn-sm btn-secondary"><i class="fas fa-file-export"></i>
                    Exportar</a>
            @endcan 
            @can('Personal Crear')
            <a href="{{ route('personal.create') }}" class="btn btn-sm btn-success">Registrar Personal</a>
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
                    <th>Categoria: <br> <input class="form-control form-control-sm" type="text" placeholder=""
                            wire:model.live="buscarCategoria"></th>
                    <th>Estado: <br> <input class="form-control form-control-sm" type="text" placeholder=""
                            wire:model.live="buscarEstado"></th>
                    <th>Actualizar: <br> <input class="form-control form-control-sm" type="text" placeholder=""
                            wire:model.live="buscarEstadoActualizar"></th>
                    <th>Pais: <br> <input class="form-control form-control-sm" type="text" placeholder=""
                            wire:model.live="buscarPais"></th>
                    <th>Sexo: <br> <input class="form-control form-control-sm" type="text" placeholder=""
                            wire:model.live="buscarSexo"></th>
                    <th>Grupo Sanguineo: <br> <input class="form-control form-control-sm" type="text" placeholder="">
                    </th>
                    <th>Compañia: <br> <select wire:model.live="companiaId" class="js-example-basic-single form-control">
                        <option value=""></option>
                        @foreach ($companias as $compania)
                            <option value="{{$compania->idcompanias}}">{{$compania->compania ?? 'N/A'}}</option>
                        @endforeach
                    </select></th>

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
