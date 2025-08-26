<div>
    <h4>Agregar un nuevo Comisionamiento</h4>
    {{-- Formulario --}}
    <x-adminlte-callout theme="success">
        <form class="row" wire:submit="guardar"> <!-- Quitado col-md-12 aquí -->

            <!-- Primera fila -->
            <div class="row col-md-12"> <!-- Envuelve cada fila en un div.row -->
                {{-- Categoria --}}
                <x-adminlte-select name="categoria_id" label="Categoria:" fgroup-class="col-md-3"
                    wire:model.blur="categoria_id">
                    <option>-- Seleccionar --</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->idpersonal_categorias }}">{{ $categoria->categoria ?? 'N/A' }}
                        </option>
                    @endforeach
                </x-adminlte-select>

                {{-- Codigo --}}
                <x-adminlte-input type="number" name="codigo" label="Codigo:" placeholder="Codigo...."
                    fgroup-class="col-md-3" wire:model.blur="codigo" />

                {{-- Info Personal --}}
                <div class="form-group col-md-6">
                    <label>Información Del Personal:</label>
                    <input type="text" class="form-control" value="{{ $info_personal_label }}" readonly />
                </div>
            </div>

            <!-- Segunda fila -->
            <div class="row col-md-12">
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

                {{-- Fecha Inicio --}}
                <x-adminlte-input type="date" name="fecha_inicio" label="Fecha De Inicio:" fgroup-class="col-md-3"
                    wire:model.blur="fecha_inicio" />

                {{-- Fecha Fin --}}
                <x-adminlte-input type="date" name="fecha_fin" label="Fecha De Finalización:" fgroup-class="col-md-3"
                    wire:model.blur="fecha_fin" />

                {{-- Codigo de Comisionamiento --}}
                <x-adminlte-input name="codigo_comisionamiento" label="Codigo de Comisionamiento:"
                    placeholder="Codigo...." fgroup-class="col-md-3" wire:model.blur="codigo_comisionamiento"
                    oninput="this.value = this.value.toUpperCase()" />
            </div>

            <!-- Tercera fila - Datos de la Resolución -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Datos de la Resolución</h3>

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

                            {{-- Nro Resolucion --}}
                            <x-adminlte-input name="nro_resolucion" label="Nro. Resolución:" placeholder="Ej: 295/24 DN"
                                fgroup-class="col-md-3" wire:model.blur="nro_resolucion" />

                            {{-- Info Resolucion --}}
                            <div class="form-group col-md-12">
                                <label>Información Del Personal:</label>
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
                    <x-adminlte-button type="submit" label="Guardar" theme="success" icon="fas fa-lg fa-save"
                        class="w-100" />
                </div>
            </div>
        </form>
    </x-adminlte-callout>
</div>
