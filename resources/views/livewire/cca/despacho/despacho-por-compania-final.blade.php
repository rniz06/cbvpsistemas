<div>
    <h4>Despacho por compañia - {{ $compania->compania ?? 'S/D' }} - {{ $compania->departamento ?? 'S/D' }} -
        {{ $compania->ciudad ?? 'S/D' }}</h4>

    {{-- Formulario --}}
    <x-adminlte-card theme="success" theme-mode="outline">
        <form class="col-md-12 row" wire:submit="grabar">
            {{-- Servicio --}}
            <div class="col-md-2">
                <x-adminlte-select name="servicio_id" label="Servicio:" wire:model.live="servicio_id">
                    <option>Seleccionar...</option>
                    @forelse ($servicios as $servicio)
                        <option value="{{ $servicio->id_servicio ?? 'null' }}">{{ $servicio->servicio ?? 'S/D' }}
                        </option>
                    @empty
                        <option>Sin datos...</option>
                    @endforelse
                </x-adminlte-select>
            </div>

            {{-- Clasificacion --}}
            <div class="col-md-2">
                <x-adminlte-select name="clasificacion_id" label="Clasificación:" wire:model.live="clasificacion_id">
                    <option>-- Seleccionar --</option>
                    @forelse ($clasificaciones as $clasificacion)
                        <option value="{{ $clasificacion->id_servicio_clasificacion ?? 'null' }}">
                            {{ $clasificacion->clasificacion ?? 'S/D' }}</option>
                    @empty
                    @endforelse
                </x-adminlte-select>
            </div>

            {{-- Informaciones --}}
            <x-adminlte-input name="informacion_servicio" label="Informaciones:" placeholder="Informaciones..."
                fgroup-class="col-md-8" oninput="this.value = this.value.toUpperCase()"
                wire:model.blur="informacion_servicio" />

            {{-- Ciudad --}}
            <div class="col-md-3">
                <x-adminlte-select name="ciudad_id" label="ciudad:" wire:model.blur="ciudad_id">
                    <option>-- Seleccionar --</option>
                    @forelse ($ciudades as $ciudad)
                        <option value="{{ $ciudad->id_ciudad ?? 'null' }}">
                            {{ $ciudad->ciudad ?? 'S/D' }}</option>
                    @empty
                        <option>Sin datos...</option>
                    @endforelse
                </x-adminlte-select>
            </div>

            {{-- Calles/Referencias --}}
            <x-adminlte-input name="calle_referencia" label="Calles/Referencias:" placeholder="Calles/Referencias..."
                fgroup-class="col-md-9" oninput="this.value = this.value.toUpperCase()"
                wire:model.blur="calle_referencia" />

            {{-- Movil --}}
            <div class="col-md-3">
                <x-adminlte-select name="movil_id" label="Móvil:" wire:model.blur="movil_id">
                    <option>-- Seleccionar --</option>
                    @forelse ($moviles as $movil)
                        <option value="{{ $movil->id_movil ?? 'null' }}">
                            {{ $movil->tipo ?? 'S/D' }}-{{ $movil->movil ?? 'S/D' }}</option>
                    @empty
                        <option>Sin datos...</option>
                    @endforelse
                </x-adminlte-select>
            </div>

            {{-- A cargo --}}
            <x-adminlte-input name="acargo" label="A cargo:" placeholder="Codigo del A cargo..."
                fgroup-class="col-md-3" oninput="this.value = this.value.toUpperCase()" wire:model.blur="acargo" />

            {{-- Chofer --}}
            <x-adminlte-input name="chofer" label="Chofer:" placeholder="Chofer..." fgroup-class="col-md-2"
                wire:model.blur="chofer" :disabled="$chofer_rentado" oninput="this.value = this.value.toUpperCase()" />

            {{-- BOTON DE RENTADO --}}
            <div class="form-group col-md-1 align-self-end">
                <x-adminlte-button :label="$chofer_rentado ? 'Cancelar Rentado' : 'Rentado'" :theme="$chofer_rentado ? 'secondary' : 'warning'" :icon="$chofer_rentado ? 'fas fa-times-circle' : 'fas fa-user-check'" wire:click="btnrentado" />
            </div>

            {{-- Tripulantes --}}
            <x-adminlte-input type="number" name="cantidad_tripulantes" label="Tripulantes:"
                placeholder="Cantidad de tripulantes..." fgroup-class="col-md-2"
                wire:model.blur="cantidad_tripulantes" />

            {{-- Botones --}}
            <div class="card-footer">
                <x-adminlte-button type="submit" label="Guardar" theme="success" icon="fas fa-lg fa-save" />
            </div>
        </form>
    </x-adminlte-card>

    <br>

    @if (isset($acargoDetalles))
        <h4> Detalles del A cargo:</h4>
        <div class="col-md-12 row" wire:transition.duration.1000ms>
            {{-- Nombrecompleto --}}
            <x-adminlte-callout theme="success" title="Nombre Completo:" class="col-md-2 mr-1">
                {{ $acargoDetalles->nombrecompleto ?? 'S/D' }}
            </x-adminlte-callout>

            {{-- codigo --}}
            <x-adminlte-callout theme="success" title="Codigo:" class="col-md-2">
                {{ $acargoDetalles->codigo ?? 'S/D' }}
            </x-adminlte-callout>

            {{-- Categoria --}}
            <x-adminlte-callout theme="success" title="Categoria:" class="col-md-2">
                {{ $acargoDetalles->categoria ?? 'S/D' }}
            </x-adminlte-callout>

            {{-- Estado --}}
            <x-adminlte-callout theme="success" title="Estado:" class="col-md-2">
                {{ $acargoDetalles->estado ?? 'S/D' }}
            </x-adminlte-callout>

            {{-- Contactos --}}
            <x-adminlte-callout theme="success" title="Contactos:" class="col-md-2">
                @forelse ($acargoDetalles->contactos as $contacto)
                    - {{ $contacto->contacto ?? 'S/D' }} <br>
                @empty
                    Sin datos...
                @endforelse
            </x-adminlte-callout>
        </div>
    @endif
</div>
