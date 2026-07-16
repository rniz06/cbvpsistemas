<div>

    {{ print_r($columnasSeleccionadas) }}
    <br>
    {{ $fecha_alfa_hasta ?? 'fecha_alfa_hasta' }}
    <h3 class="text-center">Reporte Servicios CCA</h3>

    {{-- Card Principal --}}
    <x-adminlte-card theme="secondary" theme-mode="outline" title="Informe Personalizado" maximizable collapsible>

        {{-- Paso 1 - SELECCIONAR LAS COLUMNAS A MOSTRAR --}}
        <x-adminlte-card theme="secondary" theme-mode="outline" title="Paso 1 - SELECCIONAR LAS COLUMNAS A MOSTRAR"
            collapsible="collapsed">
            <p>Para seleccionar mas de una columna presiona la tecla <kbd>CTRL</kbd> mientras seleccionas las columnas.
            </p>
            <x-adminlte-select name="columnasSeleccionadas" multiple size="20"
                wire:model.live="columnasSeleccionadas">
                @foreach ($columnasDisponibles as $columna)
                    <option value="{{ $columna['campo'] }}">{{ $columna['label'] }}</option>
                @endforeach
            </x-adminlte-select>

        </x-adminlte-card>

        {{-- Paso 2 - FILTROS --}}
        <x-adminlte-card theme="secondary" theme-mode="outline" title="Paso 2 - FILTROS" collapsible="collapsible">
            <p>Fecha de Despacho</p>
            <div class="form-group col-md-6 row">

                {{-- Fecha desde --}}
                <x-adminlte-input type="date" name="fecha_alfa_desde" wire.model.blur="fecha_alfa_desde"
                    fgroup-class="col-md-3" />

                    <span class="font-weight-bold">a</span>

                {{-- Fecha Hasta --}}
                <x-adminlte-input type="date" name="fecha_alfa_hasta" wire.model.blur="fecha_alfa_hasta"
                    fgroup-class="col-md-3" />
            </div>
        </x-adminlte-card>

        {{-- Paso 3 - AGRUPAR POR --}}
        <x-adminlte-card theme="secondary" theme-mode="outline" title="Paso 3 - AGRUPAR POR" collapsible="collapsed">
            A card without header...
        </x-adminlte-card>

        {{-- FOOTER GENERAR REPORTE --}}
        <x-slot name="footerSlot">
            <div class="text-center">
                <x-adminlte-button class="btn-sm" theme="outline-secondary" label="Generar Reporte"
                    icon="fas fa-file-alt" />
            </div>
        </x-slot>

    </x-adminlte-card>
</div>
