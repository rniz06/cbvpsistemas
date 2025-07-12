<div>
    {{-- Datos del servicio --}}
    <h4>Ficha de despacho - Compañia {{ $servicio->compania ?? 'S/D' }}</h4>
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

            {{-- Movil --}}
            <x-adminlte-input name="" label="Movil:"
                value="{{ $servicio->tipo ?? 'S/D' }}-{{ $servicio->movil ?? 'S/D' }}" fgroup-class="col-md-3"
                disabled />

            {{-- Acargo --}}
            <x-adminlte-input name="" label="A cargo:"
                value="{{ $servicio->nombrecompleto ?? 'S/D' }} - {{ $servicio->codigo ?? 'S/D' }} - {{ $servicio->categoria ?? 'S/D' }} - {{ $servicio->acargo_compania ?? 'S/D' }}"
                fgroup-class="col-md-3" disabled />

            {{-- chofer --}}
            <x-adminlte-input name="" label="Chofer:" value="{{ $servicio->chofer ?? 'S/D' }}"
                fgroup-class="col-md-3" disabled />

            {{-- Cantidad Tripulantes --}}
            <x-adminlte-input name="" value="{{ $servicio->cantidad_tripulantes ?? 'S/D' }}"
                label="Tripulantes:" fgroup-class="col-md-3" disabled />

            {{-- <div class="col-md-2">
               <label for="">Llegada de móvil:</label> <br>
                <x-adminlte-button type="submit" label="Guardar" theme="success" icon="fas fa-lg fa-save" />
            </div> --}}

            {{-- Botones --}}
            {{-- <div class="card-footer">
                <x-adminlte-button type="submit" label="Guardar" theme="success" icon="fas fa-lg fa-save" />
            </div> --}}
        </form>
    </x-adminlte-card>
</div>
