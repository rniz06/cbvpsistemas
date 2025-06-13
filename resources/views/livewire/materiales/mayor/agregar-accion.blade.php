<div>
    <!-- Formulario para Agregar Accion Material Mayor -->
    <form wire:submit="guardar">

        <x-adminlte-card title="Agregar Acción" icon="fas fa-plus" theme-mode="outline" header-class="bg-success">

            <div class="row align-items-end">
                {{-- CAMPO ACCION --}}
                <div class="col-md-2">
                    <x-adminlte-select name="accion_id" label="Acción:" wire:model.live="accion_id">
                        <option value="">Seleccione una acción</option>
                        <option value="1">EN SERVICIO</option>
                        <option value="2">FUERA DE SERVICIO</option>
                        <option value="3">REPORTAR NOVEDAD</option>
                        @can('Material Mayor Dar De Baja')
                            <option value="4">DAR DE BAJA</option>
                        @endcan
                        @can('Material Mayor Cambiar de Compania')
                            <option value="5">CAMBIO DE COMPAÑIA</option>
                        @endcan
                    </x-adminlte-select>
                </div>

                <div class="col-md-6">
                    {{-- Minimal --}}
                    <x-adminlte-textarea name="comentario" oninput="this.value = this.value.toUpperCase()" label="Comentario:" wire:model.live="comentario" placeholder="Comentario..." rows=1 />
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
