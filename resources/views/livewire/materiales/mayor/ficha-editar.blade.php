<div>
    <!-- Formulario para Editar Ficha Material Mayor -->
    <form wire:submit="actualizar">
        <x-adminlte-card title="Actualizar Ficha" icon="fas fa-edit" theme-mode="outline" header-class="bg-warning">

            <div class="row align-items-end">

                {{-- CAMPO COMPANIA --}}
                <div class="col-md-2">
                    <x-adminlte-input name="compania" label="Compañia:" value="{{ $movilRegistro->compania ?? 'N/A' }}"
                        disabled />
                </div>

                {{-- CAMPO ACRONIMO --}}
                <div class="col-md-1 form-group" style="margin:0px;">
                    <label>Acrónimo: </label>
                    <div style="display:flex;">
                        <x-adminlte-input name="movil_tipo" value="{{ $movilRegistro->tipo ?? 'N/A' }}" disabled />
                        <x-adminlte-input name="movil" wire:model.live="movil" />
                    </div>
                </div>

                {{-- CAMPO MARCA --}}
                <div class="col-md-2">
                    <x-adminlte-select name="marca_id" label="Marca:" wire:model.live="marca_id">
                        <option>Seleccionar...</option>
                        @foreach ($marcas as $marca)
                            <option value="{{ $marca->id_movil_marca }}">
                                {{ $marca->marca ?? 'N/A' }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                {{-- CAMPO MODELO --}}
                <div class="col-md-2">
                    <x-adminlte-select name="modelo_id" label="Modelo:" wire:model.live="modelo_id">
                        <option>Seleccionar...</option>
                        @foreach ($modelos as $modelo)
                            <option value="{{ $modelo->id_movil_modelo }}">
                                {{ $modelo->modelo ?? 'N/A' }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                {{-- CAMPO DESIGNACION --}}
                <div class="col-md-2">
                    <x-adminlte-select name="movil_tipo_id" label="Designación:" wire:model.live="movil_tipo_id">
                        <option>Seleccionar...</option>
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->id_movil_tipo }}">
                                {{ $tipo->tipo ?? 'N/A' }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                {{-- CAMPO OPERATIVIDAD ( ESTADO ) --}}
                <div class="col-md-2">
                    <x-adminlte-input name="operatividad_id" label="Estado:"
                        value="{{ $movilRegistro->operatividad ?? 'N/A' }}" disabled />
                </div>

                {{-- CAMPO ANHO --}}
                <div class="col-md-2">
                    <x-adminlte-input name="anho" label="Año" type="number" wire:model.live="anho" />
                </div>

                {{-- CAMPO TRANSMISION --}}
                <div class="col-md-2">
                    <x-adminlte-select name="transmision_id" label="Transmisión:" wire:model.live="transmision_id">
                        <option>Seleccionar...</option>
                        @foreach ($transmisiones as $transmision)
                            <option value="{{ $transmision->id_movil_transmision }}">
                                {{ $transmision->transmision ?? 'N/A' }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                {{-- CAMPO EJES --}}
                <div class="col-md-2">
                    <x-adminlte-select name="eje_id" label="Ejes:" wire:model.live="eje_id">
                        <option>Seleccionar...</option>
                        @foreach ($ejes as $eje)
                            <option value="{{ $eje->id_movil_eje }}">
                                {{ $eje->eje ?? 'N/A' }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                {{-- CAMPO COMBUSTIBLES --}}
                <div class="col-md-2">
                    <x-adminlte-select name="combustible_id" label="Combustible:" wire:model.live="combustible_id">
                        <option>Seleccionar...</option>
                        @foreach ($combustibles as $combustible)
                            <option value="{{ $combustible->id_movil_combustible }}">
                                {{ $combustible->tipo ?? 'N/A' }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                {{-- CAMPO CUBIERTAS DELANTERAS --}}
                <div class="col-md-2">
                    <x-adminlte-input name="cubiertas_frente" label="Cubiertas delanteras:"
                        wire:model.live="cubiertas_frente" oninput="this.value = this.value.toUpperCase()" />
                </div>

                {{-- CAMPO CUBIERTAS ATRAS --}}
                <div class="col-md-2">
                    <x-adminlte-input name="cubiertas_frente" label="Cubiertas traseras:"
                        wire:model.live="cubiertas_atras" oninput="this.value = this.value.toUpperCase()" />
                </div>

                {{-- CAMPO CHASIS --}}
                <div class="col-md-2">
                    <x-adminlte-input name="chasis" label="Chasis:" wire:model.live="chasis"
                        oninput="this.value = this.value.toUpperCase()" />
                </div>

                {{-- CAMPO CHAPA --}}
                <div class="col-md-2">
                    <x-adminlte-input name="chapa" label="Chapa:" wire:model.live="chapa"
                        oninput="this.value = this.value.toUpperCase()" />
                </div>

                {{-- BOTON DE GUARDADO --}}
                <div class="col-md-2">
                    <x-adminlte-button label="Actualizar" icon="fas fa-edit" type="submit" theme="warning"
                        class="mb-3" />
                </div>
            </div>

        </x-adminlte-card>
    </form>
</div>
