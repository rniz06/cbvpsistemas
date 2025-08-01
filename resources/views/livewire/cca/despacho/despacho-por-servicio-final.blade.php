<div>
    {{-- Datos del servicio --}}
    <h4>Datos del servicio</h4>
    <x-adminlte-card theme="success" theme-mode="outline">
        <form wire:submit="grabar" class="col-md-12 row">
            {{-- Servicio --}}
            <x-adminlte-input name="" label="Servicio:" value="{{ $servicio->servicio ?? 'S/D' }}"
                fgroup-class="col-md-2" disabled />

            {{-- Clasificacion --}}
            <x-adminlte-input name="" label="Clasificacion:" value="{{ $servicio->clasificacion ?? 'S/D' }}"
                fgroup-class="col-md-2" disabled />

            {{-- Informaciones --}}
            <x-adminlte-input name="" label="Informaciones:"
                value="{{ $servicio->informacion_servicio ?? 'S/D' }}" fgroup-class="col-md-8" disabled />

            {{-- Ciudad --}}
            <x-adminlte-input name="" label="Ciudad:" value="{{ $servicio->ciudad ?? 'S/D' }}"
                fgroup-class="col-md-3" disabled />

            {{-- Calles/Referencias --}}
            <x-adminlte-input name="" label="Calles/Referencias:"
                value="{{ $servicio->calle_referencia ?? 'S/D' }}" fgroup-class="col-md-9" disabled />

            {{-- Compania --}}
            <x-adminlte-input name="" label="Compañia:" value="{{ $servicio->compania ?? 'S/D' }}"
                fgroup-class="col-md-3" disabled />

            {{-- Movil --}}
            <div class="col-md-3">
                <x-adminlte-select name="movil_id" label="Movil:" wire:model.blur="movil_id">
                    <option>Seleccionar...</option>
                    @forelse ($moviles as $movil)
                        <option value="{{ $movil->id_movil ?? 'null' }}">
                            {{ $movil->tipo ?? 'S/D' }}-{{ $movil->movil ?? 'S/D' }}
                        </option>
                    @empty
                        <option>Sin datos...</option>
                    @endforelse
                </x-adminlte-select>
            </div>

            {{-- A cargo --}}
            <x-adminlte-input name="acargo" label="A cargo:" placeholder="Codigo del A cargo..."
                fgroup-class="col-md-2" wire:model.blur="acargo" oninput="this.value = this.value.toUpperCase()" />

            {{-- chofer --}}
            <x-adminlte-input name="chofer" label="Chofer:" wire:model.blur="chofer" fgroup-class="col-md-2"
                :disabled="$chofer_rentado" oninput="this.value = this.value.toUpperCase()" />

            {{-- BOTON DE RENTADO --}}
            <div class="form-group col-md-1 align-self-end">
                <x-adminlte-button :label="$chofer_rentado ? 'Cancelar Rentado' : 'Rentado'" :theme="$chofer_rentado ? 'secondary' : 'warning'" :icon="$chofer_rentado ? 'fas fa-times-circle' : 'fas fa-user-check'" wire:click="btnrentado" />
            </div>

            {{-- Cantidad Tripulantes --}}
            <x-adminlte-input name="cantidad_tripulantes" type="numeric" label="Tripulantes:"
                wire:model.blur="cantidad_tripulantes" fgroup-class="col-md-1" />

            {{-- Botones --}}
            <div class="card-footer">
                <x-adminlte-button type="submit" label="Guardar" theme="success" icon="fas fa-lg fa-save" />
            </div>
        </form>
    </x-adminlte-card>

    <br>

    @if (isset($acargoDetalles) and $acargoDetalles != null)
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
    @else
        <h4> Sin detalles del A cargo:</h4>
    @endif
</div>
