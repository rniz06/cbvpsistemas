<div>
    {{-- FORMULARIO DE ALTA DE MENOR MARCA --}}
    <x-adminlte-modal id="modal-create-categoria" title="Agregar Categoria" size="lg" static-backdrop
        icon="fas fa-plus" theme="default" v-centered>

        @livewire('materiales.menor.categorias.modal-create')
        <x-slot name="footerSlot"></x-slot>
    </x-adminlte-modal>

    {{-- MODAL DE EDICION --}}
    <x-adminlte-modal id="modal-edit-categoria" title="Editar Categoria" size="lg" static-backdrop icon="fas fa-edit"
        theme="default" v-centered>
        {{-- @if ($componente)
            @livewire('materiales.menor.componentes.modal-edit', ['componente' => $componente], key($componente))
        @endif --}}
        <x-slot name="footerSlot"></x-slot>
    </x-adminlte-modal>

    {{-- FILTROS DE BUSQUEDA --}}
    <x-adminlte-card theme="light" title="Filtros de Búsqueda" icon="fas fa-filter" header-class="text-muted text-sm"
        collapsible>

        <div class="row">
            {{-- CATEGORIA --}}
            <x-adminlte-input name="buscador" wire:model.live.debounce.200ms="buscador"
                oninput="this.value = this.value.toUpperCase()" placeholder="Nombre de la Categoria..."
                label-class="text-lightblue" fgroup-class="col-md-3">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Nombre de la Categoria</div>
                </x-slot>
            </x-adminlte-input>

        </div>


    </x-adminlte-card>

    <x-table.tabla titulo="Lista de Categorias" dropdown_direccion="dropleft">

        <x-slot name="acciones">
            <x-adminlte-button label="Añadir Categoria" class="btn-sm dropdown-item" icon="fas fa-plus"
                data-toggle="modal" data-target="#modal-create-categoria" /> </x-slot>


        <x-slot name="encabezados">
            {{-- Numero en la fila --}}
            <th style="width: 10px">N°</th>

            {{-- Nombre --}}
            <th>Nombre</th>

            {{-- Acciones --}}
            <th>Acciones</th>

        </x-slot>

        @forelse ($categorias as $categoria)
            <tr>
                <td>{{ $loop->iteration + $categorias->firstItem() - 1 }}</td>
                <td>{{ $categoria->nombre ?? 'S/D' }}</td>
                <td>
                    <x-tabla-dropdown>

                        {{-- EDITAR --}}
                        <x-adminlte-button label="Editar" class="dropdown-item btn-sm" icon="fas fa-edit"
                            data-toggle="modal" data-target="#modal-edit-categoria"
                            wire:click="abrir_modal_edit({{ $categoria->id_menor_categoria }})" />

                        {{-- LINEA DIVISORIA --}}
                        <div class="dropdown-divider"></div>

                        {{-- ELIMINAR --}}
                        <x-adminlte-button label="Eliminar" class="dropdown-item btn-sm" icon="fas fa-trash"
                            wire:click="eliminar({{ $categoria->id_menor_categoria }})"
                            wire:confirm="¿ESTÁ SEGURO DE ELIMINAR {{ $categoria->nombre ?? '' }}?" />
                    </x-tabla-dropdown>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100%" class="text-center text-muted font-italic">Sin resultados coincidentes...
                </td>
            </tr>
        @endforelse

        <x-slot name="paginacion">
            {{ $categorias->links() }}
        </x-slot>
    </x-table.tabla>
</div>
