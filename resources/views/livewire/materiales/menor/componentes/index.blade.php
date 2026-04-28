<div>
    {{-- FORMULARIO DE ALTA DE MENOR MARCA --}}
    <x-adminlte-modal id="modal-create-componente" title="Agregar Componente" size="xl" static-backdrop icon="fas fa-tasks"
        theme="default" v-centered>

        @livewire('materiales.menor.componentes.modal-create')
        <x-slot name="footerSlot"></x-slot>
    </x-adminlte-modal>
    {{-- MODAL DE EDICION --}}
    <x-adminlte-modal id="modal-edit-componente" title="Editar Componente" size="lg" static-backdrop
        icon="fas fa-tasks" theme="default" wire:ignore.self v-centered>
        {{-- @if ($componente)
            @livewire(
                'materiales.menor.componentes.modal-edit',
                [
                    'componente' => $componente,
                    'routeToRedirect' => 'materiales.menor.componentes.index',
                    'categoriaId' => \App\Enums\Materiales\Menor\CategoriaComponente::MATERIAL_MENOR,
                ],
                key('modal-edit-' . $componente)
            )
        @endif --}}
    </x-adminlte-modal>

    {{-- FILTROS DE BUSQUEDA --}}
    <x-adminlte-card theme="light" title="Filtros de Búsqueda" icon="fas fa-filter" header-class="text-muted text-sm"
        collapsible>

        <div class="row">
            {{-- COMPONENTE --}}
            <x-adminlte-input name="buscarNombre" wire:model.live.debounce.200ms="buscarNombre"
                oninput="this.value = this.value.toUpperCase()" placeholder="Nombre del Componente..."
                label-class="text-lightblue" fgroup-class="col-md-3">
                <x-slot name="prependSlot">
                    <div class="input-group-text">Nombre del Componente</div>
                </x-slot>
            </x-adminlte-input>

            {{-- TIPOS --}}
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-2" wire:ignore>
                        <div class="input-group-prepend">
                            <div class="input-group-text">Componentes de:</div>
                        </div>
                        <select class="form-control @error('buscarTipoId') is-invalid @enderror" id="buscarTipoId"
                            name="buscarTipoId" wire:model.live.debounce.200ms="buscarTipoId">
                            <option value="">Todos</option>
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id_menor_tipo }}">
                                    {{ $tipo->tipo ?? 'S/D' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- CATEGORIAS --}}
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group mb-2" wire:ignore>
                        <div class="input-group-prepend">
                            <div class="input-group-text">Categorias:</div>
                        </div>
                        <select class="form-control @error('buscarCategoriaId') is-invalid @enderror"
                            id="buscarCategoriaId" name="buscarCategoriaId"
                            wire:model.live.debounce.200ms="buscarCategoriaId">
                            <option value="">Todos</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id_menor_categoria }}">
                                    {{ $categoria->nombre ?? 'S/D' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>


    </x-adminlte-card>

    <x-table.tabla titulo="Lista de Componentes" pdf="exportar('pdf')" excel="exportar('excel')"
        dropdown_direccion="dropleft">

        <x-slot name="acciones">
            <x-adminlte-button label="Añadir Componente" class="btn-sm dropdown-item" icon="fas fa-plus"
                data-toggle="modal" data-target="#modal-create-componente" /> </x-slot>


        <x-slot name="encabezados">
            {{-- Numero en la fila --}}
            <th style="width: 10px">N°</th>

            {{-- Nombre --}}
            <th>Nombre</th>

            {{-- Componente de --}}
            <th>Componente de</th>

            {{-- Categoria --}}
            <th>Categoria</th>

            {{-- Acciones --}}
            <th>Acciones</th>

        </x-slot>

        @forelse ($componentes as $componente)
            <tr>
                <td>{{ $loop->iteration + $componentes->firstItem() - 1 }}</td>
                <td>{{ $componente->nombre ?? 'S/D' }}</td>
                <td>{{ $componente->tipo->tipo ?? 'S/D' }}</td>
                <td>{{ $componente->categoria->nombre ?? 'S/D' }}</td>
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

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/slimselect.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/slimselect.js') }}"></script>

    <script>
        new SlimSelect({
            select: '#buscarTipoId'
        })

        new SlimSelect({
            select: '#buscarCategoriaId'
        })
    </script>
@endpush
