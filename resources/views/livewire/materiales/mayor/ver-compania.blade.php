<div>
    <h4>Ficha de Compañia</h4>
    <div class="row">
        <x-callout.ficha titulo="Compañía">{{ $compania->compania ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha titulo="Ciudad">{{ $compania->ciudad ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha titulo="Departamento">{{ $compania->departamento ?? 'N/A' }}</x-callout.ficha>
    </div>

    @if ($formVisible)
        <!-- Formulario para Agregar Movil -->
        <form wire:submit="guardar">
            <x-card-form>
                <div class="col-md-2">

                    {{-- CAMPO MARCA --}}
                    <x-adminlte-select name="marca_id" label="Marca:" wire:model.live="marca_id">
                        <option>Seleccionar...</option>
                        @foreach ($marcas as $marca)
                            <option value="{{ $marca->id_movil_marca }}">
                                {{ $marca->marca ?? 'N/A' }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                <div class="col-md-2">
                    <x-select.select campo="modelo_id" label="Modelo">
                        <option>Seleccionar...</option>
                        @foreach ($modelos as $modelo)
                            <option value="{{ $modelo->id_movil_modelo }}">
                                {{ $modelo->modelo ?? 'N/A' }}</option>
                        @endforeach
                    </x-select.select>
                </div>

                <div class="col-md-1 form-group">
                    <label>Designación:</label>
                    <select class="form-control" wire:model.live="movil_tipo_id">
                        <option>Seleccionar...</option>
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->id_movil_tipo }}">
                                {{ $tipo->tipo ?? 'N/A' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1 form-group">
                    <label>Código radial:</label>
                    <input type="number" class="form-control" wire:model.live="movil">
                </div>

                <x-card-input class="col-md-2" label="Año de Fábrica" type="number" placeholder="0000..."
                    campo="anho" />

                <x-card-input class="col-md-2" label="Chasis" placeholder="Chasis..." campo="chasis" />

                <div class="col-md-2">
                    <x-select.select campo="transmision_id" label="Transmisión">
                        <option>Seleccionar...</option>
                        @foreach ($transmisiones as $transmision)
                            <option value="{{ $transmision->id_movil_transmision }}">
                                {{ $transmision->transmision ?? 'N/A' }}</option>
                        @endforeach
                    </x-select.select>
                </div>

                <div class="col-md-2">
                    <x-select.select campo="eje_id" label="Eje">
                        <option>Seleccionar...</option>
                        @foreach ($ejes as $eje)
                            <option value="{{ $eje->id_movil_eje }}">
                                {{ $eje->eje ?? 'N/A' }}</option>
                        @endforeach
                    </x-select.select>
                </div>

                <x-card-input class="col-md-2" label="Cubiertas delanteras" placeholder="Cubiertas delanteras..."
                    campo="cubiertas_frente" />

                <x-card-input class="col-md-2" label="Cubiertas Traseras" placeholder="Cubiertas Traseras..."
                    campo="cubiertas_atras" />

                <div class="col-md-2">
                    <x-select.select campo="combustible_id" label="Combustible">
                        <option>Seleccionar...</option>
                        @foreach ($combustibles as $combustible)
                            <option value="{{ $combustible->id_movil_combustible }}">
                                {{ $combustible->tipo ?? 'N/A' }}</option>
                        @endforeach
                    </x-select.select>
                </div>

                <x-card-input class="col-md-2" label="Chapa" placeholder="Chapa..." campo="chapa" />

                <x-slot name="buttons">
                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save mr-2">
                            Guardar</i></button>
                </x-slot>

            </x-card-form>
        </form>
    @endif

    {{-- Tabla de Moviles --}}
    <div class="col-md-12">
        <x-table.table titulo="Móviles" ocultarBuscador personalizarPaginacion="paginadoMoviles">


            @canany(['Material Mayor Crear'])
                <x-slot name="headerBotones">
                    <button class="btn btn-outline-success btn-sm" wire:click="$toggle('formVisible')">
                        <i class="fas fa-{{ $formVisible ? 'minus' : 'plus' }}"></i>
                        {{ $formVisible ? 'Cancelar' : 'Agregar Móvil' }}
                    </button>
                </x-slot>
            @endcanany

            <x-slot name="cabeceras">
                <th>Móvil:</th>
                <th>Estado:</th>
                <th>Marca:</th>
            </x-slot>

            @foreach ($moviles as $movil)
                <tr>
                    <td>{{ $movil->tipo ?? 'N/A' }}-{{ $movil->movil ?? 'N/A' }}</td>
                    <td><span
                            class="badge badge-{{ $movil->operatividad == 'OPERATIVO' ? 'success' : 'danger' }}">{{ $movil->operatividad }}</span>
                    </td>
                    <td>{{ $movil->marca ?? 'N/A' }}</td>
                    @can('Material Mayor Ver')
                        <td><a href="{{ route('materiales.mayor.show', $movil->id_movil) }}"
                                class="btn btn-sm btn-{{ $movil->operatividad == 'OPERATIVO' ? 'success' : 'danger' }} btn-block">Ver
                                Ficha</a></td>
                    @endcan
                </tr>
            @endforeach
            <x-slot name="paginacion">
                {{ $moviles->links() }}
            </x-slot>
        </x-table.table>
    </div>
</div>
