<div>

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                Aspirantes y Ficha Médica

            </h3>

        </div>

        <div class="card-body">

            <div class="row mb-3">

                <div class="col-md-4">

                    <label>Llamado</label>

                    <select
                        class="form-control"
                        wire:model.live="llamado_id"
                    >

                        <option value="">
                            TODOS
                        </option>

                        @foreach($llamados as $llamado)

                            <option value="{{ $llamado->id }}">
                                {{ $llamado->nombre }}
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

                        <option value="PRE_ASPIRANTE">
                            PRE ASPIRANTE
                        </option>

                        <option value="ASPIRANTE">
                            ASPIRANTE
                        </option>

                    </select>

                </div>

            </div>

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>Cédula</th>

                        <th>Aspirante</th>

                        <th>Compañía</th>

                        <th>Estado</th>

                        <th>Ficha Médica</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($aspirantes as $aspirante)

                        <tr>

                            <td>
                                {{ $aspirante->cedula }}
                            </td>

                            <td>

                                {{ $aspirante->apellido }}

                                ,

                                {{ $aspirante->nombre }}

                            </td>

                            <td>

                                {{ $aspirante->compania->abreviatura ?? '-' }}

                            </td>

                            <td>

                                {{ $aspirante->estado }}

                            </td>

                            <td>

                                @if($aspirante->fichaMedica)

                                    <span class="badge badge-success">

                                        SI

                                    </span>

                                @else

                                    <span class="badge badge-danger">

                                        NO

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5">

                                Sin registros

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

            {{ $aspirantes->links() }}

        </div>

    </div>

</div>