<div>
    {{-- Formulario --}}
    <x-adminlte-card theme="light" title="Despacho por Departamento" icon="fas fa-plus-circle"
        header-class="text-muted text-sm">
        <form class="col-md-12 p-2 row" wire:submit="guardar">

            {{-- Servicio --}}
            <x-adminlte-select name="servicio_id" wire:model.blur="servicio_id" label-class="text-lightblue"
                fgroup-class="col-md-2" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Servicio *</div>
                </x-slot>
                <option value="">Seleccionar</option>
                @foreach ($servicios as $servicio)
                    <option value="{{ $servicio->id_servicio }}">{{ $servicio->servicio ?? 'S/D' }}</option>
                @endforeach
            </x-adminlte-select>

            {{-- Clasificación --}}
            <x-adminlte-select name="clasificacion_id" wire:model.blur="clasificacion_id" label-class="text-lightblue"
                fgroup-class="col-md-2" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Clasificación *</div>
                </x-slot>
                <option value="">Seleccionar</option>
                @foreach ($clasificaciones as $clasificacion)
                    <option value="{{ $clasificacion->id_clasificacion }}">{{ $clasificacion->clasificacion ?? 'S/D' }}
                    </option>
                @endforeach
            </x-adminlte-select>

            {{-- Informaciones --}}
            <x-adminlte-input name="informacion_servicio" wire:model.blur="informacion_servicio"
                label-class="text-lightblue" fgroup-class="col-md-8" igroup-size="sm" placeholder="Informaciones..."
                oninput="this.value = this.value.toUpperCase()">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Informaciones *</div>
                </x-slot>
            </x-adminlte-input>

            {{-- Ciudad --}}
            <x-adminlte-select name="ciudad_id" wire:model.blur="ciudad_id" label-class="text-lightblue"
                fgroup-class="col-md-2" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Ciudad *</div>
                </x-slot>
                <option value="">Seleccionar</option>
                @foreach ($ciudades as $ciudad)
                    <option value="{{ $ciudad->id_ciudad }}">{{ $ciudad->ciudad ?? 'S/D' }}
                    </option>
                @endforeach
            </x-adminlte-select>

            {{-- Compañía --}}
            <x-adminlte-select name="compania_id" wire:model.blur="compania_id" label-class="text-lightblue"
                fgroup-class="col-md-2" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Compañía *</div>
                </x-slot>
                <option value="">Seleccionar</option>
                @foreach ($companias as $compania)
                    <option value="{{ $compania->id_compania }}">{{ $compania->compania ?? 'S/D' }}
                    </option>
                @endforeach
            </x-adminlte-select>

            {{-- Calles/Referencias --}}
            <x-adminlte-input name="calle_referencia" wire:model.blur="calle_referencia" label-class="text-lightblue"
                fgroup-class="col-md-8" igroup-size="sm" placeholder="Calles/Referencias..."
                oninput="this.value = this.value.toUpperCase()">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Calles/Referencias *</div>
                </x-slot>
            </x-adminlte-input>

            {{-- Móvil --}}
            <x-adminlte-select name="movil_id" wire:model.blur="movil_id" label-class="text-lightblue"
                fgroup-class="col-md-2" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Móvil *</div>
                </x-slot>
                <option value="">Seleccionar</option>
                @foreach ($moviles as $movil)
                    <option value="{{ $movil->id_movil }}">
                        {{ $movil->acronimo->tipo ?? 'S/D' }}-{{ $movil->movil ?? 'S/D' }}
                    </option>
                @endforeach
            </x-adminlte-select>

            {{-- Chofer --}}
            <x-adminlte-input name="chofer" wire:model.blur="chofer" label-class="text-lightblue"
                fgroup-class="col-md-3" igroup-size="sm" oninput="this.value = this.value.toUpperCase()">
                <x-slot name="appendSlot">
                    <x-adminlte-button theme="outline-warning" label="Rentado" wire:click="btnChoferRentado" />
                </x-slot>
                <x-slot name="prependSlot">
                    <div class="input-group-text">Chofer *</div>
                </x-slot>
            </x-adminlte-input>

            {{-- A cargo --}}
            <x-adminlte-input name="acargo" wire:model.blur="acargo" label-class="text-lightblue"
                fgroup-class="col-md-3" igroup-size="sm" oninput="this.value = this.value.toUpperCase()">
                <x-slot name="appendSlot">
                    <x-adminlte-button theme="outline-warning" label="Rentado" />
                </x-slot>
                <x-slot name="prependSlot">
                    <div class="input-group-text">A cargo *</div>
                </x-slot>
            </x-adminlte-input>

            {{-- Tripulantes --}}
            <x-adminlte-input name="cantidad_tripulantes" wire:model.blur="cantidad_tripulantes"
                label-class="text-lightblue" fgroup-class="col-md-2" igroup-size="sm"
                oninput="this.value = this.value.toUpperCase()" type="number" placeholder="Cant. Tripulantes...">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Tripulantes *</div>
                </x-slot>
            </x-adminlte-input>

            {{-- Hora denuncia --}}
            <x-adminlte-input name="fecha_alfa" wire:model.blur="fecha_alfa" label-class="text-lightblue"
                fgroup-class="col-md-3" igroup-size="sm" type="datetime-local">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Hora denuncia *</div>
                </x-slot>
            </x-adminlte-input>

            {{-- Despacho a Cia --}}
            <x-adminlte-input name="fecha_cia" wire:model.blur="fecha_cia" label-class="text-lightblue"
                fgroup-class="col-md-3" igroup-size="sm" type="datetime-local">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Despacho a Cia *</div>
                </x-slot>
            </x-adminlte-input>

            {{-- Salida de móvil --}}
            <x-adminlte-input name="fecha_movil" wire:model.blur="fecha_movil" label-class="text-lightblue"
                fgroup-class="col-md-3" igroup-size="sm" type="datetime-local">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Salida de móvil *</div>
                </x-slot>
            </x-adminlte-input>

            {{-- Llegada de móvil --}}
            <x-adminlte-input name="fecha_servicio" wire:model.blur="fecha_servicio" label-class="text-lightblue"
                fgroup-class="col-md-3" igroup-size="sm" type="datetime-local">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Llegada de móvil *</div>
                </x-slot>
            </x-adminlte-input>

            {{-- Móvil en base --}}
            <x-adminlte-input name="fecha_base" wire:model.blur="fecha_base" label-class="text-lightblue"
                fgroup-class="col-md-3" igroup-size="sm" type="datetime-local">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Móvil en base *</div>
                </x-slot>
            </x-adminlte-input>

            {{-- Kilometraje Final --}}
            <x-adminlte-input name="km_final" wire:model.blur="km_final" label-class="text-lightblue"
                fgroup-class="col-md-3" igroup-size="sm" type="number" placeholder="Kilometraje Final...">
                <x-slot name="appendSlot">
                    <x-adminlte-button theme="outline-warning" label="10.77" />
                </x-slot>
                <x-slot name="prependSlot">
                    <div class="input-group-text">Kilometraje Final *</div>
                </x-slot>
            </x-adminlte-input>

            {{-- Botón de Volver --}}
            <div class="form-group col-xl-3 d-flex align-items-end">
                <a href="{{ url()->previous() }}"
                    class="btn btn-block btn-outline-secondary text-decoration-none btn-sm"><i
                        class="fas fa-arrow-left mr-1"></i>Volver</a>
            </div>

            {{-- Botón de Guardar --}}
            <div class="form-group col-xl-3 d-flex align-items-end">
                <x-adminlte-button type="submit" label="Guardar" theme="outline-success" icon="fas fa-lg fa-save"
                    class="w-100 btn-sm" />
            </div>
        </form>
    </x-adminlte-card>
</div>
