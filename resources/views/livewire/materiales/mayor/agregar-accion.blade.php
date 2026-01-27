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

                @if ($accion_id == 5)
                    <div class="col-md-2">
                        <x-adminlte-select name="compania_id" label="Compañía:" wire:model.live="compania_id">
                            @foreach ($companias as $compania)
                                <option value="{{ $compania->id_compania }}">{{ $compania->compania ?? 'N/A' }}</option>
                            @endforeach

                        </x-adminlte-select>
                    </div>
                @endif

                {{-- FUERA DE SERVICIO --}}
                @if ($accion_id == 2)
                    <div class="col-md-2">
                        <x-adminlte-select name="accion_categoria_id" label="Opciones:"
                            wire:model.live="accion_categoria_id">
                            <option>--- Seleccionar ---</option>
                            @foreach ($accionCategorias as $accionCategoria)
                                <option value="{{ $accionCategoria->id_accion_categoria }}">
                                    {{ $accionCategoria->categoria ?? 'N/A' }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>

                    <div class="col-md-2">
                        <x-adminlte-select name="categoria_detalle_id" label="Detalles:"
                            wire:model.live="categoria_detalle_id">
                            <option>--- Seleccionar ---</option>
                            @foreach ($categoriasDetalles as $categoriaDetalle)
                                <option value="{{ $categoriaDetalle->idaccion_categoria_detalle }}">
                                    {{ $categoriaDetalle->detalle ?? 'N/A' }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                @endif



                <div class="col-md-6">
                    {{-- Minimal --}}
                    <x-adminlte-textarea name="comentario" oninput="this.value = this.value.toUpperCase()"
                        label="Comentario:" wire:model.live="comentario" placeholder="Comentario..." rows=1 />
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
