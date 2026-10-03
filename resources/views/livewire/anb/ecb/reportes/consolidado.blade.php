<div>

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                Reporte Consolidado de Aptitud

            </h3>

        </div>

        <div class="card-body">

            <div class="row mb-3">

                <div class="col-md-3">

                    <input
                        type="text"
                        class="form-control"
                        placeholder="Buscar..."
                        wire:model.live="buscar">

                </div>

                <div class="col-md-3">

                    <select
                        class="form-control"
                        wire:model.live="llamado">

                        <option value="">
                            Todos los llamados
                        </option>

                        @foreach($llamados as $l)

                            <option value="{{ $l->id }}">
                                {{ $l->nombre }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-3">

                    <select
                        class="form-control"
                        wire:model.live="compania">

                        <option value="">
                            Todas las compañías
                        </option>

                        @foreach($companias as $c)

                            <option value="{{ $c->id_compania }}">
                                {{ $c->compania }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-3">

                    <select
                        class="form-control"
                        wire:model.live="estado">

                        <option value="">
                            Todos
                        </option>

                        <option value="APTO">
                            Aptos
                        </option>

                        <option value="NO APTO">
                            No Aptos
                        </option>

                        <option value="PENDIENTE">
                            Pendientes
                        </option>

                    </select>

                </div>

            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-hover table-sm">

                    <thead class="table-dark">

                        <tr>

                            <th>C.I.</th>

                            <th>Nombre</th>

                            <th>Compañía</th>

                            <th>Médico</th>

                            <th>Físico</th>

                            <th>Wonderlic</th>

                            <th>NEOFFI</th>

                            <th>LSB50</th>

                            <th>Resultado Final</th>

                            <th>Observaciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($filas as $fila)

                            <tr>

                                <td>{{ $fila['cedula'] }}</td>

                                <td>{{ $fila['nombre'] }}</td>

                                <td>{{ $fila['compania'] }}</td>

                                <td>

                                    <span class="badge bg-{{ $fila['medico']['estado']=='APTO' ? 'success' : ($fila['medico']['estado']=='NO APTO' ? 'danger' : 'warning') }}">

                                        {{ $fila['medico']['texto'] }}

                                    </span>

                                </td>

                                <td>

                                    <span class="badge bg-{{ $fila['fisico']['estado']=='APTO' ? 'success' : ($fila['fisico']['estado']=='NO APTO' ? 'danger' : 'warning') }}">

                                        {{ $fila['fisico']['texto'] }}

                                    </span>

                                </td>

                                <td>

                                    <span class="badge bg-{{ $fila['wonderlic']['estado']=='APTO' ? 'success' : ($fila['wonderlic']['estado']=='NO APTO' ? 'danger' : 'warning') }}">

                                        {{ $fila['wonderlic']['texto'] }}

                                    </span>

                                </td>

                                <td>

                                    <span class="badge bg-{{ $fila['neoffi']['estado']=='APTO' ? 'success' : ($fila['neoffi']['estado']=='NO APTO' ? 'danger' : 'warning') }}">

                                        {{ $fila['neoffi']['texto'] }}

                                    </span>

                                </td>

                                <td>

                                    <span class="badge bg-{{ $fila['lsb50']['estado']=='APTO' ? 'success' : ($fila['lsb50']['estado']=='NO APTO' ? 'danger' : 'warning') }}">

                                        {{ $fila['lsb50']['texto'] }}

                                    </span>

                                </td>

                                <td>

                                    <span class="badge bg-{{ $fila['resultado']['estado']=='APTO' ? 'success' : ($fila['resultado']['estado']=='NO APTO' ? 'danger' : 'warning') }}">

                                        {{ $fila['resultado']['texto'] }}

                                    </span>

                                </td>

                                <td>

                                    {{ $fila['observacion'] }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="10" class="text-center">

                                    No existen registros.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>