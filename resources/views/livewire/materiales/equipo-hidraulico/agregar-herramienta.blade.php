<div>
    <!-- Formulario para Agregar Herramienta Equipo Hidraulico -->
    <form wire:submit="guardar">

        <x-adminlte-card title="Agregar Herramienta" icon="fas fa-plus" theme-mode="outline" header-class="bg-success">

            <div class="row align-items-end">
                {{-- CAMPO TIPO --}}
                <div class="col-md-2">
                    <x-adminlte-select name="tipo_id" label="Tipo:" wire:model.live="tipo_id">
                        <option value="">Seleccione una opcion</option>
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->idhidraulico_herr_tipo }}">{{ $tipo->tipo ?? 'N/A' }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                {{-- CAMPO MOTOR --}}
                <div class="col-md-2">
                    <x-adminlte-select name="motor_id" label="Motor:" wire:model.live="motor_id">
                        <option value="">Seleccione una opcion</option>
                        @foreach ($motores as $motor)
                            <option value="{{ $motor->idhidraulico_herr_motor }}">
                                {{ $motor->motor ?? 'N/A' }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                {{-- CAMPO MARCA --}}
                <div class="col-md-2">
                    <x-adminlte-select name="marca_id" label="Marca:" wire:model.live="marca_id">
                        <option value="">Seleccione una opcion</option>
                        @foreach ($marcas as $marca)
                            <option value="{{ $marca->idhidraulico_herr_marca }}">
                                {{ $marca->marca ?? 'N/A' }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                {{-- CAMPO MODELO --}}
                <div class="col-md-2">
                    <x-adminlte-select name="modelo_id" label="Modelo:" wire:model.live="modelo_id">
                        <option value="">Seleccione una opcion</option>
                        @foreach ($modelos as $modelo)
                            <option value="{{ $modelo->idhidraulico_herr_modelo }}">
                                {{ $modelo->modelo ?? 'N/A' }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                <div class="col-md-2">
                    {{-- CAMPO NUMERO DE SERIE --}}
                    <x-adminlte-input name="serie" label="Número de serie:" wire:model.live="serie"
                        placeholder="Número de serie..." type="number" oninput="this.value = this.value.slice(0, 11)" />
                </div>

                {{-- BOTON DE GUARDADO --}}
                <div class="col-md-2">
                    <x-adminlte-button label="Guardar" icon="fas fa-save" type="submit" theme="success"
                        class="mb-3" />
                </div>
            </div>

        </x-adminlte-card>
    </form>
</div>
