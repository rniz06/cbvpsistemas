<div>
    <h4>Editar un Registro de Comisionamiento</h4>
    {{-- Formulario --}}
    <x-adminlte-callout theme="warning">
        <form class="row" wire:submit="guardar"> <!-- Quitado col-md-12 aquí -->

            <!-- Primera fila -->
            <div class="row col-md-12"> <!-- Envuelve cada fila en un div.row -->

                {{-- Info Personal --}}
                <div class="form-group col-md-9">
                    <label>Información Del Personal:</label>
                    <p class="form-control">{{ $comisionamiento->nombrecompleto ?? 'S/D' }} -
                        {{ $comisionamiento->codigo ?? 'S/D' }}</p>
                </div>

                {{-- Fecha Inicio --}}
                <x-adminlte-input type="date" name="fecha_inicio" label="Fecha De Inicio:" fgroup-class="col-md-3"
                    wire:model.blur="fecha_inicio" />
            </div>

            <!-- Segunda fila -->
            <div class="row col-md-12">
                {{-- Cargo --}}
                <x-adminlte-select name="cargo_id" label="Cargo:" fgroup-class="col-md-3" wire:model.blur="cargo_id">
                    <option>-- Seleccionar --</option>
                    @foreach ($cargos as $cargo)
                        <option value="{{ $cargo->id_cargo }}">{{ $cargo->cargo ?? 'N/A' }}
                        </option>
                    @endforeach
                </x-adminlte-select>

                {{-- Compania --}}
                <x-adminlte-select name="compania_id" label="Comisionar a:" fgroup-class="col-md-3"
                    wire:model.blur="compania_id">
                    <option>-- Seleccionar --</option>
                    @foreach ($companias as $compania)
                        <option value="{{ $compania->id_compania }}">
                            {{ $compania->compania ?? 'N/A' }}
                        </option>
                    @endforeach
                </x-adminlte-select>

                {{-- Codigo de Comisionamiento --}}
                @if ($mostrarInputCodCom == true)
                    <x-adminlte-input name="codigo_comisionamiento" label="Codigo de Comisionamiento:"
                        placeholder="Codigo...." fgroup-class="col-md-3" wire:model.blur="codigo_comisionamiento"
                        oninput="this.value = this.value.toUpperCase()" />
                @else
                    <x-adminlte-input readonly name="codigo_comisionamiento" label="Codigo de Comisionamiento:"
                        fgroup-class="col-md-3" wire:model.blur="codigo_comisionamiento" />
                @endif

                {{-- Direccion --}}
                <x-adminlte-select name="direccion_id" label="En:" fgroup-class="col-md-3"
                    wire:model.blur="direccion_id">
                    <option>-- Seleccionar --</option>
                    @foreach ($direcciones as $direccion)
                        <option value="{{ $direccion->id_direccion }}">
                            {{ $direccion->direccion ?? 'N/A' }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </div>

            @isset($comisionamiento->resolucion_id)
                <div class="card col-md-12">
                    <div class="card-body">
                        <h5><span class="font-weight-bold">Datos de la Resolución:</span>
                            {{ $comisionamiento->n_resolucion ?? 'S/D' }}</h5>
                        <p><span class="font-weight-bold">Concepto:</span> {{ $comisionamiento->concepto ?? 'S/D' }}</p>
                    </div>
                </div>
            @endisset

            <!-- Tercera fila - Datos de la Resolución -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Asignar Una Resolución</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="row col-md-12"> <!-- Nueva fila dentro del card -->
                            {{-- Origen --}}
                            <x-adminlte-select name="origen_id" label="Origen De la Resolución:" fgroup-class="col-md-3"
                                wire:model.blur="origen_id">
                                <option>-- Seleccionar --</option>
                                @foreach ($origenes as $origen)
                                    <option value="{{ $origen->id }}">{{ $origen->origen ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </x-adminlte-select>

                            {{-- Anho --}}
                            <x-adminlte-select name="anho_id" label="Año De la Resolución:" fgroup-class="col-md-3"
                                wire:model.blur="anho_id">
                                <option>-- Seleccionar --</option>
                                @foreach ($anhos as $anho)
                                    <option value="{{ $anho }}">{{ $anho }}</option>
                                @endforeach
                            </x-adminlte-select>

                            {{-- Nro Resolucion Select --}}
                            <x-adminlte-select name="resolucion_id" label="Seleccionar Resolución:"
                                fgroup-class="col-md-3" wire:model.blur="resolucion_id">
                                <option>-- Seleccionar --</option>
                                @foreach ($nrosResolucion as $nroResolucion)
                                    <option value="{{ $nroResolucion->id }}">{{ $nroResolucion->n_resolucion }}
                                    </option>
                                @endforeach
                            </x-adminlte-select>

                            {{-- Info Resolucion --}}
                            <div class="form-group col-md-12">
                                <label>Información De la Resolución:</label>
                                <input type="text" class="form-control" value="{{ $info_resolucion_label }}"
                                    readonly />
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!--/.card -->
            </div>

            <!-- Cuarta fila - Botón -->
            <div class="row col-md-12">
                {{-- Botón de Guardar --}}
                <div class="form-group col-md-3 d-flex align-items-end">
                    <x-adminlte-button type="submit" label="Guardar" theme="warning" icon="fas fa-lg fa-save"
                        class="w-100" />
                </div>
            </div>
        </form>
    </x-adminlte-callout>
</div>
