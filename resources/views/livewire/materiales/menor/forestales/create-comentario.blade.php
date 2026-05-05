<div>
    {{-- Formulario --}}
    <x-adminlte-card theme="light" title="Agregar Acción" icon="fas fa-plus-circle"
        header-class="text-muted text-sm">
        <form class="col-md-12 row" wire:submit="guardar">

            {{-- ACCION --}}
            <x-adminlte-select name="accion_id" label="Acción:" wire:model.blur="accion_id" fgroup-class="col-md-3">
                <option>Seleccionar...</option>
                <option value="1">EN SERVICIO</option>
                <option value="2">FUERA DE SERVICIO</option>
                <option value="3">REPORTE</option>
                @can('Material Menor Dar De Baja')
                    <option value="4">DAR DE BAJA</option>
                @endcan
            </x-adminlte-select>

            {{-- COMENTARIO --}}
            <x-adminlte-textarea name="comentario" oninput="this.value = this.value.toUpperCase()" label="Comentario:"
                wire:model.blur="comentario" placeholder="Comentario..." rows=1 fgroup-class="col-md-9" />

            {{-- Botón de Guardar --}}
            <div class="form-group col-xl-3 d-flex align-items-end">
                <x-adminlte-button type="submit" label="Guardar" theme="outline-success" icon="fas fa-lg fa-save"
                    class="w-100 btn-sm" />
            </div>
        </form>
    </x-adminlte-card>
</div>
