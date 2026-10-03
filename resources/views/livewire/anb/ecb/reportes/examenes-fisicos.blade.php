<div>

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                Reporte de Exámenes Físicos

            </h3>

        </div>

        <div class="card-body">

            <div class="row mb-3">

                <div class="col-md-4">

                    <label>Examen Físico</label>

                    <select
                        class="form-control"
                        wire:model.live="examen_id"
                    >

                        <option value="">
                            TODOS
                        </option>

                        @foreach($examenes as $examen)

                            <option value="{{ $examen->id }}">
                                {{ $examen->nombre }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-4">

                    <label>Estado</label>

                    <select
                        class="form-control"
                        wire:model.live="estado"
                    >

                        <option value="">
                            TODOS
                        </option>

                        <option value="1">
                            APROBADOS
                        </option>

                        <option value="0">
                            REPROBADOS
                        </option>

                    </select>

                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-4">

                    <div class="small-box bg-info">

                        <div class="inner">

                            <h3>

                                {{ $resultados->total() }}

                            </h3>

                            <p>

                                Evaluados

                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="small-box bg-success">

                        <div class="inner">

                            <h3>

                                {{ $resultados->where('aprobado',1)->count() }}

                            </h3>

                            <p>

                                Aprobados

                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="small-box bg-danger">

                        <div class="inner">

                            <h3>

                                {{ $resultados->where('aprobado',0)->count() }}

                            </h3>

                            <p>

                                Reprobados

                            </p>

                        </div>

                    </div>

                </div>

            </div>

            <table class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th>Cédula</th>

                        <th>Aspirante</th>

                        <th>Compañía</th>

                        <th>Examen</th>

                        <th>Puntaje</th>

                        <th>Estado</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($resultados as $resultado)

                        <tr>

                            <td>

                                {{ $resultado->aspirante->cedula }}

                            </td>

                            <td>

                                {{ $resultado->aspirante->apellido }}

                                ,

                                {{ $resultado->aspirante->nombre }}

                            </td>

                            <td>

                                {{ $resultado->aspirante->compania?->compania }}

                            </td>

                            <td>

                                {{ $resultado->examen->nombre ?? '-' }}

                            </td>

                            <td>

                                {{ $resultado->puntaje_total }}

                            </td>

                            <td>

                                @if($resultado->aprobado)

                                    <span class="badge badge-success">

                                        APROBADO

                                    </span>

                                @else

                                    <span class="badge badge-danger">

                                        REPROBADO

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6">

                                Sin registros

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

            {{ $resultados->links() }}

        </div>

    </div>

</div>