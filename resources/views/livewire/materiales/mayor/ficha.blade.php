<div>
    <h4>Ficha de Material Mayor</h4>
    {{-- Minimal without header / body only --}}
    <x-adminlte-card theme="warning" theme-mode="outline">
        <div class="row">
            <x-adminlte-input name="" fgroup-class="col-md-2" label="Compañía:"
                value="{{ $movil->compania ?? 'N/A' }}" disabled />
            <x-adminlte-input name="" fgroup-class="col-md-2" label="Acrónimo:" value="{{ $movil->tipo ?? 'N/A' }}"
                disabled />
            <x-adminlte-input name="" fgroup-class="col-md-2" label="Marca:" value="{{ $movil->marca ?? 'N/A' }}"
                disabled />
            <x-adminlte-input name="" fgroup-class="col-md-2" label="Modelo:"
                value="{{ $movil->modelo ?? 'N/A' }}" disabled />
            <x-adminlte-input name="" fgroup-class="col-md-2" label="Tipo de Vehículo:"
                value="{{ $movil->tipo ?? 'N/A' }}" disabled />
            <x-adminlte-input name="" fgroup-class="col-md-2" label="Estado:"
                value="{{ $movil->operatividad ?? 'N/A' }}" disabled />
            <x-adminlte-input name="" fgroup-class="col-md-2" label="Año:" value="{{ $movil->anho ?? 'N/A' }}"
                disabled />
            <x-adminlte-input name="" fgroup-class="col-md-2" label="Transmisión:"
                value="{{ $movil->transmision ?? 'N/A' }}" disabled />
            <x-adminlte-input name="" fgroup-class="col-md-2" label="Eje:" value="{{ $movil->eje ?? 'N/A' }}"
                disabled />
            <x-adminlte-input name="" fgroup-class="col-md-2" label="Combustible:"
                value="{{ $movil->combustible ?? 'N/A' }}" disabled />
            <x-adminlte-input name="" fgroup-class="col-md-2" label="Cubiertas delanteras:"
                value="{{ $movil->cubiertas_frente ?? 'N/A' }}" disabled />
            <x-adminlte-input name="" fgroup-class="col-md-2" label="Cubiertas traseras:"
                value="{{ $movil->cubiertas_atras ?? 'N/A' }}" disabled />
            <x-adminlte-input name="" fgroup-class="col-md-2" label="Chapa:"
                value="{{ $movil->chapa ?? 'N/A' }}" disabled />
            <x-adminlte-input name="" fgroup-class="col-md-2" label="Chasis:"
                value="{{ $movil->chasis ?? 'N/A' }}" disabled />
        </div>
    </x-adminlte-card>

    @if ($mostrarFormAgregarAccion)
        @livewire('materiales.mayor.agregar-accion', ['movil_id' => $movil->id_movil])
    @endif

    <x-table.table titulo="Comentarios">
        <x-slot name="headerBotones">

            @can('Material Mayor Exportar Excel')
                <x-button.button click="excelComentarios" color="btn-block btn-outline-success btn-sm"
                    icon="fas fa-file-excel" class="ml-2 btn-sm float-right">
                    Excel
                </x-button.button>
            @endcan

            @can('Material Mayor Exportar Pdf')
                <x-button.button click="pdfComentarios" color="btn-block btn-outline-secondary btn-sm"
                    icon="fas fa-file-pdf" class="ml-2 btn-sm float-right">
                    Pdf
                </x-button.button>
            @endcan

            @can('Material Mayor Agregar Accion')
                <x-adminlte-button class="btn-sm" type="button"
                    label="{{ $mostrarFormAgregarAccion ? 'Cancelar' : 'Agregar Acción' }}"
                    icon="fas fa-{{ $mostrarFormAgregarAccion ? 'minus' : 'plus' }}" theme="outline-success"
                    wire:click="$toggle('mostrarFormAgregarAccion')" />
                {{-- <x-button.button click="openFormAgregarAccion" color="btn-block btn-outline-secondary btn-sm"
                    icon="fas fa-plus" class="ml-2 btn-sm float-right">
                    Agregar Accion
                </x-button.button> --}}
            @endcan

        </x-slot>

        <x-slot name="cabeceras">
            <th>Acción:</th>
            <th>Comentarios:</th>
            <th>Usuario:</th>
            <th>Fecha y Hora:</th>
        </x-slot>

        @foreach ($comentarios as $comentario)
            <tr>
                <td>{{ $comentario->accion ?? 'N/A' }}</td>
                <td>{{ $comentario->comentario ?? 'N/A' }}</td>
                <td>{{ $comentario->nombrecompleto ?? 'N/A' }}</td>
                <td>{{ date('d/m/Y H:m:s', strtotime($comentario->created_at)) }}</td>
            </tr>
        @endforeach
        <x-slot name="paginacion">
            {{ $comentarios->links() }}
        </x-slot>
    </x-table.table>

</div>
