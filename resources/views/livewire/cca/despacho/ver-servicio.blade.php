<div>
    {{-- Datos del servicio --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start">
        {{-- <div>
            <h4 class="mb-1">
                Ficha de despacho - Compañía {{ $servicio->compania ?? 'S/D' }}
            </h4>
        </div> --}}

        {{-- Línea horizontal solo visible en móviles --}}
        <hr class="w-100 my-2 d-md-none">

        <div>
            <h4 class="mb-1 text-md-right">
                Despachado Por: {{ $servicio->creado_por_nombrecompleto ?? 'S/D' }} -
                {{ $servicio->creado_por_codigo ?? 'S/D' }}
            </h4>
        </div>
    </div>



    <x-adminlte-card theme="success" theme-mode="outline"
        title="Ficha de despacho - Compañía {{ $servicio->compania ?? 'S/D' }}">

        {{-- TOOLS DEL CARD --}}
        <x-slot name="toolsSlot">
            {{-- DROPDOWN --}}
            <div class="btn-group dropleft">
                <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                    Mas Acciones
                </button>
                <div class="dropdown-menu">
                    {{-- <a class="btn-sm dropdown-item" href="#">Falsa Alarma</a> --}}
                    {{-- BTN FALSA ALARMA --}}
                    @if ($servicio->falsa_alarma == false)
                        <x-adminlte-button class="btn-sm dropdown-item" label="Falsa Alarma" icon="fas fa-times-circle"
                            wire:click="falsaAlarma"
                            wire:confirm="¿Estas Seguro de Declarar este Servicio Como una Falsa Alarma?" />
                    @else
                        {{-- BTN FALSA ALARMA DESHABILITADO --}}
                        <x-adminlte-button class="btn-sm dropdown-item" label="Falsa Alarma" icon="fas fa-times-circle" disabled />
                    @endif
                </div>
            </div>
        </x-slot>

        <div class="col-md-12 row">
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
            <x-adminlte-input name="" label="Ciudad del Servicio:" value="{{ $servicio->ciudad ?? 'S/D' }}"
                fgroup-class="col-md-3" disabled />

            {{-- Calles/Referencias --}}
            <x-adminlte-input name="" label="Calles/Referencias:"
                value="{{ $servicio->calle_referencia ?? 'S/D' }}" fgroup-class="col-md-9" disabled />

            {{-- Movil --}}
            <x-adminlte-input name="" label="Movil:"
                value="{{ $servicio->tipo ?? 'S/D' }}-{{ $servicio->movil ?? 'S/D' }}" fgroup-class="col-md-3"
                disabled />

            {{-- Acargo --}}
            @if (is_null($servicio->acargo))
                {{-- Mostrar acargo_aux --}}
                <x-adminlte-input name="" label="A cargo:" value="{{ $servicio->acargo_aux ?? 'Rentado' }}"
                    fgroup-class="col-md-3" disabled />
            @else
                {{-- Mostrar datos de acargo --}}
                <x-adminlte-input name="" label="A cargo:"
                    value="{{ $servicio->acargo_codigo_comisionamiento ?? ($servicio->acargo_codigo ?? 'S/D') }} - {{ $servicio->acargo_nombrecompleto ?? 'S/D' }}"
                    fgroup-class="col-md-3" disabled />
            @endif

            {{-- Chofer --}}
            @if (is_null($servicio->chofer))
                {{-- Mostrar acargo_aux --}}
                <x-adminlte-input name="" label="Chofer:" value="{{ $servicio->chofer_aux ?? 'Rentado' }}"
                    fgroup-class="col-md-3" disabled />
            @else
                {{-- Mostrar datos de acargo --}}
                <x-adminlte-input name="" label="Chofer:"
                    value="{{ $servicio->chofer_codigo_comisionamiento ?? ($servicio->chofer_codigo ?? 'S/D') }} - {{ $servicio->chofer_nombrecompleto ?? 'S/D' }}"
                    fgroup-class="col-md-3" disabled />
            @endif

            {{-- Cantidad Tripulantes --}}
            <x-adminlte-input name="" value="{{ $servicio->cantidad_tripulantes ?? 'S/D' }}"
                label="Tripulantes:" fgroup-class="col-md-1" disabled />

            {{-- Hora denuncia --}}
            <x-adminlte-input name="" label="Hora denuncia:"
                value="{{ date('d/m/Y H:i:s', strtotime($servicio->fecha_alfa)) . ' Hs.' ?? 'S/D' }}"
                fgroup-class="col-md-2" disabled />

            {{-- Despacho a Cia --}}
            @if ($servicio->fecha_cia == null)
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Despacho a Cia:</label>
                        <button class="btn btn-primary btn-block"
                            wire:click="horaAccion(1, {{ $servicio->id_servicio_existente }})">Accionar</button>
                    </div>
                </div>
            @else
                <x-adminlte-input name="" label="Despacho a Cia:"
                    value="{{ date('d/m/Y H:i:s', strtotime($servicio->fecha_cia)) . ' Hs.' ?? 'S/D' }}"
                    fgroup-class="col-md-2" disabled />
            @endif

            {{-- Salida de móvil --}}
            @if ($servicio->fecha_movil == null)
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Salida de móvil:</label>
                        <button class="btn btn-primary btn-block"
                            wire:click="horaAccion(2, {{ $servicio->id_servicio_existente }})">Accionar</button>
                    </div>
                </div>
            @else
                <x-adminlte-input name="" label="Salida de móvil:"
                    value="{{ date('d/m/Y H:i:s', strtotime($servicio->fecha_movil)) . ' Hs.' ?? 'S/D' }}"
                    fgroup-class="col-md-2" disabled />
            @endif

            {{-- Llegada de móvil --}}
            @if ($servicio->fecha_servicio == null)
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Llegada de móvil:</label>
                        <button class="btn btn-primary btn-block"
                            wire:click="horaAccion(3, {{ $servicio->id_servicio_existente }})">Accionar</button>
                    </div>
                </div>
            @else
                <x-adminlte-input name="" label="Llegada de móvil:"
                    value="{{ date('d/m/Y H:i:s', strtotime($servicio->fecha_servicio)) . ' Hs.' ?? 'S/D' }}"
                    fgroup-class="col-md-2" disabled />
            @endif

            {{-- Móvil en base --}}
            @if ($servicio->fecha_base == null)
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Móvil en base:</label>
                        <button class="btn btn-primary btn-block"
                            wire:click="horaAccion(4, {{ $servicio->id_servicio_existente }})">Accionar</button>
                    </div>
                </div>
            @else
                <x-adminlte-input name="" label="Móvil en base:"
                    value="{{ date('d/m/Y H:i:s', strtotime($servicio->fecha_base)) . ' Hs.' ?? 'S/D' }}"
                    fgroup-class="col-md-2" disabled />
            @endif

            {{-- KM FINAL --}}
            @if (is_null($servicio->km_final) and $servicio->desperfecto === null)
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Kilometraje Final:</label>
                        <button class="btn btn-success btn-block" wire:click="$toggle('mostrarFormAgregarDetalle')"><i
                                class="fas fa-{{ $mostrarFormAgregarDetalle ? 'minus' : 'plus' }} mr-1"></i>{{ $mostrarFormAgregarDetalle ? 'Cancelar' : 'Agregar' }}</button>
                    </div>
                </div>
            @else
                <x-adminlte-input name="" label="Kilometraje Final:"
                    value="{{ isset($servicio->km_final) ? number_format($servicio->km_final, 0, ',', '.') . ' Km' : ($servicio->desperfecto ? '10.77' : 'NO') }}"
                    fgroup-class="col-md-2" disabled />
            @endif

            @if ($servicio->despacho_policia == true)
                <x-adminlte-input name="" label="Despachado por 911"
                    value="{{ $servicio->despacho_policia ? 'SI' : 'NO' }}" fgroup-class="col-md-2" disabled />
            @endif

            @if ($servicio->falsa_alarma == true)
                <x-adminlte-input name="" label="Falsa Alarma:"
                    value="{{ $servicio->falsa_alarma ? 'SI' : 'NO' }}" fgroup-class="col-md-2" disabled />
            @endif
        </div>
    </x-adminlte-card>

    @if ($mostrarFormAgregarDetalle)
        <!-- Formulario para Agregar Detalles -->
        <form wire:submit="guardarDetalles">

            <x-adminlte-card title="Agregar Detalles" icon="fas fa-plus" theme-mode="outline"
                header-class="bg-success">

                <div class="row align-items-end">

                    {{-- Km Final --}}
                    <div class="col-md-2">
                        <x-adminlte-input type="number" name="km_final" label="Kilometraje Final:"
                            id="myNumberInput" wire:model.blur="km_final" placeholder="Kilometraje Final..."
                            :disabled="$desperfecto" />
                    </div>

                    {{-- BOTON DE DESPERFECTO --}}
                    <div class="form-group">
                        <x-adminlte-button :label="$desperfecto ? 'Cancelar 10.77' : '10.77'" :theme="$desperfecto ? 'secondary' : 'warning'" wire:click="btndesperfecto" />
                    </div>

                    {{-- BOTON DE GUARDADO --}}
                    <div class="col-md-2">
                        <x-adminlte-button label="Guardar" icon="fas fa-save" type="submit" theme="success"
                            class="mb-3" />
                    </div>
                </div>

            </x-adminlte-card>
        </form>
    @endif
</div>
