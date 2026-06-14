<div>

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Reporte Psicológico
            </h3>

        </div>

        <div class="card-body">

            <div class="row mb-4">

                <div class="col-md-4">

                    <label>
                        Tipo de Test
                    </label>

                    <select
                        class="form-control"
                        wire:model.live="test_id"
                    >

                        <option value="">
                            Seleccione
                        </option>

                        @foreach($tests as $test)

                            <option value="{{ $test->id }}">
                                {{ $test->nombre }}
                            </option>

                        @endforeach

                    </select>

                </div>

                @if($test_id)

                    @php
                        $testSeleccionado = $tests->firstWhere('id', $test_id);
                    @endphp

                    @if(
                        $testSeleccionado &&
                        $testSeleccionado->codigo != 'WONDERLIC'
                    )

                        <div class="col-md-4">

                            <label>
                                Dimensión
                            </label>

                            <select
                                class="form-control"
                                wire:model.live="dimension_id"
                            >

                                <option value="">
                                    Todas
                                </option>

                                @foreach($dimensiones as $dimension)

                                    <option value="{{ $dimension->id }}">
                                        {{ $dimension->nombre }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    @endif

                @endif

            </div>

            @if($test_id)

                @if(
                    isset($testSeleccionado) &&
                    $testSeleccionado->codigo == 'WONDERLIC'
                )

                    <table class="table table-bordered table-striped">

                        <thead>

                            <tr>

                                <th>Cédula</th>

                                <th>Aspirante</th>

                                <th>Compañía</th>

                                <th>Puntaje</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($datos as $fila)

                                <tr>

                                    <td>
                                        {{ $fila->aspirante->cedula }}
                                    </td>

                                    <td>
                                        {{ $fila->aspirante->apellido }},
                                        {{ $fila->aspirante->nombre }}
                                    </td>

                                    <td>
                                        {{ $fila->aspirante->compania->descripcion ?? '' }}
                                    </td>

                                    <td>
                                        {{ $fila->puntaje }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                @else

                    <table class="table table-bordered table-striped">

                        <thead>

                            <tr>

                                <th>Cédula</th>

                                <th>Aspirante</th>

                                <th>Compañía</th>

                                @foreach($columnasDinamicas as $columna)

                                    <th>
                                        {{ $columna }}
                                    </th>

                                @endforeach

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($datos as $fila)

                                <tr>

                                    <td>
                                        {{ $fila['cedula'] }}
                                    </td>

                                    <td>
                                        {{ $fila['nombre'] }}
                                    </td>

                                    <td>
                                        {{ $fila['compania'] }}
                                    </td>

                                    @foreach($columnasDinamicas as $columna)

                                        <td>
                                            {{ $fila[$columna] ?? '' }}
                                        </td>

                                    @endforeach

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="100">
                                        Sin registros
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                @endif

            @else

                <div class="alert alert-info">

                    Seleccione un tipo de test.

                </div>

            @endif

        </div>

    </div>

</div>