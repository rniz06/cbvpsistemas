<div>
    {{-- Aa campo codigo a asignar = {{ $codigo_a_asignar ?? 'NULL AUN' }} --}}
    {{-- Datos del personal --}}
    <x-adminlte-callout theme="warning" title="Datos del personal">
        <div class="col-md-12 row">
            {{-- Nombre Completo --}}
            <x-adminlte-input name="" label="Nombre Completo:" value="{{ $personal->nombrecompleto ?? 'S/D' }}"
                fgroup-class="col-md-3" disabled />
            {{-- Categoria --}}
            <x-adminlte-input name="" label="Categoria:" value="{{ $personal->categoria ?? 'S/D' }}"
                fgroup-class="col-md-3" disabled />
            {{-- Codigo --}}
            <x-adminlte-input name="" label="Codigo:" value="{{ $personal->codigo ?? 'S/D' }}"
                fgroup-class="col-md-3" disabled />
            {{-- Compania --}}
            <x-adminlte-input name="" label="Compañia:" value="{{ $personal->compania ?? 'S/D' }}"
                fgroup-class="col-md-3" disabled />
        </div>
    </x-adminlte-callout>

    <div>
        <!-- Formulario para Codigo de un voluntario -->
        <form wire:submit="guardar">

        <x-adminlte-callout theme="warning" title="Actualizar Codigo" icon="fas fa-edit">
            <div class="col-md-12 row">
                {{-- Codigo a Asignar --}}
                <x-adminlte-input name="codigo_a_asignar" wire:model.blur="codigo_a_asignar" label="Codigo a Asignar:"
                    fgroup-class="col-md-2" />
                {{-- Detalles del codigo ingresado --}}
                <x-adminlte-input name="" label="Detalles del Codigo a Asignar:" fgroup-class="col-md-10"
                    value="{{ $codigoDetalles->codigoDetalles ?? 'SIN DATOS DEL CODIGO O CODIDO NO ASIGNADO AUN' }}"
                    disabled />
            </div>
            {{-- Boton Guardar --}}
            <x-adminlte-button type="submit" label="Actualizar" theme="warning" icon="fas fa-lg fa-save"
                    wire:confirm="¿Estas Seguro que desea actualizar este codigo?" />
        </x-adminlte-callout>
        </form>
    </div>

</div>
