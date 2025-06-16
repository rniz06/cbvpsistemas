<div>
    <!-- Formulario para Editar Ficha Equipo Hidraulico -->
    <form wire:submit="actualizar">
        <x-adminlte-card title="Actualizar Ficha" icon="fas fa-edit" theme-mode="outline" header-class="bg-warning">

            <div class="row align-items-end">

                {{-- CAMPO COMPANIA --}}
                <div class="col-md-2">
                    <x-adminlte-input name="compania" label="Compañia:" value="{{ $hidraulicoRegistro->compania ?? 'N/A' }}"
                        disabled />
                </div>

                {{-- CAMPO MARCA --}}
                <div class="col-md-2">
                    <x-adminlte-select name="marca_id" label="Marca:" wire:model.live="marca_id">
                        @foreach ($marcas as $marca)
                            <option value="{{ $marca->id_hidraulico_marca }}">
                                {{ $marca->marca ?? 'N/A' }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                {{-- CAMPO MODELO --}}
                <div class="col-md-2">
                    <x-adminlte-select name="modelo_id" label="Modelo:" wire:model.live="modelo_id">
                        @foreach ($modelos as $modelo)
                            <option value="{{ $modelo->id_hidraulico_modelo }}">
                                {{ $modelo->modelo ?? 'N/A' }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                {{-- CAMPO MOTOR --}}
                <div class="col-md-2">
                    <x-adminlte-select name="motor_id" label="Motor:" wire:model.live="motor_id">
                        @foreach ($motores as $motor)
                            <option value="{{ $motor->id_hidraulico_motor }}">
                                {{ $motor->motor ?? 'N/A' }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                {{-- CAMPO ANHO --}}
                <div class="col-md-2">
                    <x-adminlte-input name="anho" label="Año: (Si no Cuenta colocar 0000)" wire:model.live="anho" />
                </div>

                {{-- CAMPO OPERATIVIDAD ( ESTADO ) --}}
                <div class="col-md-2">
                    <x-adminlte-input name="operatividad" label="Estado:"
                        value="{{ $hidraulicoRegistro->operatividad ?? 'N/A' }}" disabled />
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
