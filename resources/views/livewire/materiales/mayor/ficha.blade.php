<div>
    <h4>Datos Generales</h4>
    <div class="row">
        <x-callout.ficha titulo="Compañía">{{ $movil->compania ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha titulo="Acrónimo">{{ $movil->tipo ?? 'N/A' }}-{{ $movil->movil ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha titulo="Marca">{{ $movil->marca ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha titulo="Modelo">{{ $movil->modelo ?? 'N/A' }}</x-callout.ficha>

        <x-callout.ficha titulo="Tipo de Vehículo">{{ $movil->tipo ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha titulo="Estado">{{ $movil->operatividad ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha titulo="Año">{{ $movil->anho ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha titulo="Transmisión">{{ $movil->transmision ?? 'N/A' }}</x-callout.ficha>

        <x-callout.ficha titulo="Ejes">{{ $movil->eje ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha titulo="Combustible">{{ $movil->combustible ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha titulo="Cubiertas delanteras">{{ $movil->cubiertas_frente ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha titulo="Cubiertas traseras">{{ $movil->cubiertas_atras ?? 'N/A' }}</x-callout.ficha>

        <x-callout.ficha titulo="Chapa" colClass="col-md-6 mb-3">{{ $movil->chapa ?? 'N/A' }}</x-callout.ficha>
        <x-callout.ficha titulo="Chasis" colClass="col-md-6 mb-3">{{ $movil->chasis ?? 'N/A' }}</x-callout.ficha>
    </div>

    <x-table.table titulo="Comentarios">
        <x-slot name="headerBotones">

            
            <x-button.button click="excelComentarios" color="btn-block btn-outline-success btn-sm"
                icon="fas fa-file-excel" class="ml-2 btn-sm float-right">
                Excel
            </x-button.button>

            <x-button.button click="pdfComentarios" color="btn-block btn-outline-secondary btn-sm"
                icon="fas fa-file-pdf" class="ml-2 btn-sm float-right">
                Pdf
            </x-button.button>

            {{-- <x-button.button color="btn-block btn-outline-secondary btn-sm" data-toggle="modal" data-target="#staticBackdrop"
                icon="fas fa-plus" class="ml-2 btn-sm float-right">
                Agregar Accion
            </x-button.button> --}}

            <!-- Button trigger modal -->
            {{-- <button type="button" class="btn btn-block btn-outline-success btn-sm" data-toggle="modal" data-target="#staticBackdrop">
                <i class="fas fa-plus"></i> Agregar Accion
            </button> --}}

            <x-button.button click="openFormAgregarAccion" color="btn-block btn-outline-secondary btn-sm"
                icon="fas fa-plus" class="ml-2 btn-sm float-right">
                Agregar Accion
            </x-button.button>

            @livewire('materiales.mayor.agregar-accion', ['movil_id' => $movil->id_movil])

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
                <td>{{ date('d/m/Y h:m:s', strtotime($comentario->created_at)) }}</td>
            </tr>
        @endforeach
        <x-slot name="paginacion">
            {{ $comentarios->links() }}
        </x-slot>
    </x-table.table>

</div>
