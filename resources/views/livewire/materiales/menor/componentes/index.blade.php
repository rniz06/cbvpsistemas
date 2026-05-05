<div>
    {{-- MODAL DE EDICION --}}
    <x-adminlte-modal id="modal-edit-componente" title="Editar Componente" size="lg" static-backdrop
        icon="fas fa-tasks" theme="default" wire:ignore.self v-centered>
        @if ($componente)
            @livewire(
                'materiales.menor.componentes.modal-edit',
                [
                    'componente' => $componente,
                    'routeToRedirect' => 'materiales.menor.componentes.index',
                    'categoriaId' => \App\Enums\Materiales\Menor\CategoriaComponente::MATERIAL_MENOR,
                ],
                key('modal-edit-' . $componente)
            )
        @endif
    </x-adminlte-modal>

    {{-- FILTROS DE BUSQUEDA --}}
    <x-adminlte-card theme="light" title="Filtros de Búsqueda" icon="fas fa-filter" header-class="text-muted text-sm"
        collapsible>

        <div class="col-md-12 row">
            {{-- COMPONENTE --}}
            <x-adminlte-input name="buscarNombre" wire:model.live.debounce.200ms="buscarNombre"
                oninput="this.value = this.value.toUpperCase()" placeholder="Nombre del Componente..."
                label-class="text-lightblue" fgroup-class="col-md-3" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Nombre del Componente</div>
                </x-slot>
            </x-adminlte-input>
        </div>
    </x-adminlte-card>

    <x-table.tabla titulo="Lista de Componentes - Mat. Menor" pdf="exportar('pdf')" excel="exportar('excel')"
        dropdown_direccion="dropleft">

        @can('Materiales Menor Componentes Crear')
            <x-slot name="acciones">
                <x-adminlte-button label="Añadir Componente" class="btn-sm dropdown-item" icon="fas fa-plus"
                    data-toggle="modal" data-target="#modal-create-componente" /> </x-slot>
            @livewire('materiales.menor.componentes.modal-create', ['routeToRedirect' => 'materiales.menor.componentes.index', 'categoriaId' => \App\Enums\Materiales\Menor\CategoriaComponente::MATERIAL_MENOR])
        @endcan

        <x-slot name="encabezados">
            {{-- Numero en la fila --}}
            <th style="width: 10px">N°</th>

            {{-- Nombre --}}
            <th>Nombre</th>

            {{-- Acciones --}}
            <th>Acciones</th>

        </x-slot>

        @forelse ($componentes as $componente)
            <tr>
                <td>{{ $loop->iteration + $componentes->firstItem() - 1 }}</td>
                <td>{{ $componente->nombre ?? 'S/D' }}</td>
                <td>
                    <x-tabla-dropdown>

                        {{-- EDITAR --}}
                        @can('Materiales Menor Componentes Editar')
                            <x-adminlte-button label="Editar" class="dropdown-item btn-sm" icon="fas fa-edit"
                                data-toggle="modal" data-target="#modal-edit-componente"
                                wire:click="abrir_modal_edit({{ $componente->id_menor_componente }})" />
                        @endcan

                        {{-- LINEA DIVISORIA --}}
                        <div class="dropdown-divider"></div>

                        {{-- ELIMINAR --}}
                        @can('Materiales Menor Componentes Eliminar')
                            <x-adminlte-button label="Eliminar" class="dropdown-item btn-sm" icon="fas fa-trash"
                                wire:click="eliminar({{ $componente->id_menor_componente }})"
                                wire:confirm="¿ESTÁ SEGURO DE ELIMINAR {{ $componente->nombre ?? '' }}?" />
                        @endcan
                    </x-tabla-dropdown>
                    {{-- Componente con Modal Fuera del Dropdonw para evitar superposicion --}}
                    {{-- @livewire('materiales.menor.marcas.modal-edit', ['marca_id' => $marca->id_menor_marca]) --}}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100%" class="text-center text-muted font-italic">Sin resultados coincidentes...
                </td>
            </tr>
        @endforelse

        <x-slot name="paginacion">
            {{ $componentes->links() }}
        </x-slot>
    </x-table.tabla>
</div>

@push('scripts')
    <script>
        // ESCUCHAR EVENTOS DE LIVEWIRE
        document.addEventListener('livewire:init', () => {

            // EVENTO PARA ABRIR EL MODAL
            Livewire.on('abrir-modal-edit', (event) => {
                $('#modal-edit-componente').modal('show');
            });

            document.addEventListener('livewire:init', () => {
                $('#modal-edit-componente').on('hidden.bs.modal', function() {

                    // 🔥 Quitar foco del botón problemático
                    document.activeElement.blur();

                    // 🔥 Notificar a Livewire
                    Livewire.dispatch('cerrar-modal-edit');
                });
            });
        });
    </script>
@endpush
