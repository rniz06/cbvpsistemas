<div class="row">
    
    <h4>Ficha de Material Menor</h4>

    {{-- DATOS DEL ITEM --}}
    <div class="col-md-12">
        <x-adminlte-card theme="secondary" theme-mode="outline">
            <div class="row">
                {{-- ITEM --}}
                <x-adminlte-input name="" label="Item:" value="{{ $item->componente->nombre ?? 'S/D' }}"
                    fgroup-class="col-md-3" igroup-size="sm" readonly />

                {{-- CANTIDAD OPERATIVO --}}
                <x-adminlte-input name="" label="Cant. Operativo:" value="{{ $item->cantidad_operativo ?? 'S/D' }}"
                    fgroup-class="col-md-3" igroup-size="sm" readonly />

                {{-- CANTIDAD INOPERATIVO --}}
                <x-adminlte-input name="" label="Cant. Inoperativo:" value="{{ $item->cantidad_inoperativo ?? 'S/D' }}"
                    fgroup-class="col-md-3" igroup-size="sm" readonly />

                {{-- COMPANIA --}}
                <x-adminlte-input name="" label="Compañia:" value="{{ $item->compania->compania ?? 'S/D' }}"
                    fgroup-class="col-md-3" igroup-size="sm" readonly />
            </div>
        </x-adminlte-card>
    </div>

    @if ($ver_form_alta)
        <br>
        <div class="col-md-12">
            @livewire('materiales.menor.menor.edit', ['item' => $item->id_menor_item])
        </div>
    @endif

    {{-- ITEMS --}}

    <div class="col-md-12">
        <x-table.tabla titulo="Comentarios" dropdown_direccion="dropleft" paginado="paginado">

            @can('Material Menor Editar')
                <x-slot name="acciones">
                    <x-adminlte-button :label="$ver_form_alta ? 'Cerrar Formulario' : 'Actualizar'" class="btn-sm dropdown-item" :icon="$ver_form_alta ? 'fas fa-times' : 'fas fa-plus'"
                        wire:click="$toggle('ver_form_alta')" />
                </x-slot>
            @endcan

            <x-slot name="encabezados">
                {{-- NUMERO EN LA FILA --}}
                <th style="width: 10px">N°</th>

                {{-- ACCION --}}
                <th>Acción:</th>

                {{-- COMENTARIO --}}
                <th>Comentario:</th>

                {{-- USUARIO --}}
                <th>Usuario:</th>

                {{-- FECHA HORA --}}
                <th>Fecha Hora:</th>

            </x-slot>

            @forelse ($comentarios as $comentario)
                <tr>
                    <td>{{ $loop->iteration + $comentarios->firstItem() - 1 }}</td>
                    <td>{{ $comentario->accion->accion ?? 'S/D' }}</td>
                    <td>{{ $comentario->comentario ?? 'S/D' }}</td>
                    <td>{{ $item->creadopor->nombrecompleto ?? 'S/D' }}</td>
                    <td>{{ optional($comentario->created_at)->format('d/m/Y H:i:s') ?? 'S/D' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="100%" class="text-center text-muted font-italic">Sin resultados coincidentes...
                    </td>
                </tr>
            @endforelse

            <x-slot name="paginacion">
                {{ $comentarios->links() }}
            </x-slot>
        </x-table.tabla>
    </div>
</div>
