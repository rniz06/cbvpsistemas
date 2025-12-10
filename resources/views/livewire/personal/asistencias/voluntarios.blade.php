<div>
    {{-- MODAL DE CARGA DE ASISTENCIA --}}
    <x-adminlte-modal id="modal-carga" title="Carga de Asistencia" size="lg" icon="fas fa-tasks" theme="default"
        wire:ignore.self v-centered static-backdrop scrollable>
        @if ($detalle)
            @livewire('personal.asistencias.carga2', ['detalle' => $detalle], key('carga-' . $detalle))
        @endif
    </x-adminlte-modal>

    {{-- SI EXISTEN FICHAS PENDIENTES DE ACTUALIZACION MOSTRAR MENSAJE DE ALERTA --}}
    @if ($mostrarMensajeAleta)
        <x-adminlte-alert theme="danger"
            title="EXISTEN FICHAS NO ACTUALIZADAS. NO PODRA REALIZAR LA CARGA DE ASISTENCIA" />
    @endif

    {{-- Tabla de Voluntarios --}}
    <x-table.table titulo="Listado De Voluntarios" ocultarBuscador>

        @can('Personal Asistencias Exportar Pdf')
            <x-slot name="headerBotones">
                <x-adminlte-button wire:click="pdf" label="Exportar Listado en PDF" icon="far fa-file-pdf"
                    theme="outline-secondary" class="btn-sm" />
            </x-slot>
        @endcan

        <x-slot name="cabeceras">

            {{-- Nombre Completo --}}
            <th>
                <div>
                    <x-adminlte-input name="buscarNombreCompleto" label="Nombre Completo:" fgroup-class="col-md-12"
                        igroup-size="sm" wire:model.live.debounce.250ms="buscarNombreCompleto"
                        oninput="this.value = this.value.toUpperCase()" />
                </div>
            </th>

            {{-- Código --}}
            <th>
                <div>
                    <x-adminlte-input type="number" name="buscarCodigo" label="Código:" fgroup-class="col-md-12"
                        wire:model.live.debounce.250ms="buscarCodigo" igroup-size="sm" />
                </div>
            </th>

            {{-- Práctica --}}
            <th>
                <div>
                    <x-adminlte-input name="" label="Práctica:" fgroup-class="col-md-12" igroup-size="sm"
                        readonly />
                </div>
            </th>

            {{-- Guardia --}}
            <th>
                <div>
                    <x-adminlte-input name="" label="Guardia:" fgroup-class="col-md-12" igroup-size="sm"
                        readonly />
                </div>
            </th>

            {{-- Citación --}}
            <th>
                <div>
                    <x-adminlte-input name="" label="Citación:" fgroup-class="col-md-12" igroup-size="sm"
                        readonly />
                </div>
            </th>

            {{-- Total --}}
            <th>
                <div>
                    <x-adminlte-input name="" label="Total:" fgroup-class="col-md-12" igroup-size="sm"
                        readonly />
                </div>
            </th>

            {{-- Acciones --}}
            <th>
                <div>
                    <x-adminlte-input name="" label="Acciones:" fgroup-class="col-md-12" igroup-size="sm"
                        readonly />
                </div>
            </th>

        </x-slot>

        {{-- Spinner centrado en toda la tabla mientras se actualiza --}}
        {{-- <div wire:loading class="loading-overlay">
            <div class="spinner-container">
                <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                <div class="mt-2">Generando Pdf...</div>
            </div>
        </div> --}}


        @forelse ($voluntarios as $personal)
            <tr wire:key="fila-{{ $personal->id_asistencia_detalle }}">
                <td>{{ $personal->personal->nombrecompleto ?? 'S/D' }}</td>
                <td>{{ $personal->personal->codigo ?? 'S/D' }}</td>

                <td>
                    <span class="badge {{ $personal->practica !== null ? 'badge-success' : 'badge-danger' }}">
                        {{ $personal->practica ?? 'S/D' }}
                    </span>
                </td>

                <td>
                    <span class="badge {{ $personal->guardia !== null ? 'badge-success' : 'badge-danger' }}">
                        {{ $personal->guardia ?? 'S/D' }}
                    </span>
                </td>

                <td><span class="badge {{ $personal->citacion !== null ? 'badge-success' : 'badge-danger' }}">
                        {{ $personal->citacion ?? 'S/D' }}
                    </span></td>

                <td><span class="badge {{ $personal->total !== null ? 'badge-success' : 'badge-danger' }}">
                        {{ $personal->total ?? 'S/D' }}
                    </span></td>
                <td>
                    <div class="d-inline-flex align-items-center gap-2">

                        @can('Personal Asistencias Carga')
                            {{-- Boton Carga --}}
                            <x-adminlte-button label="Cargar" icon="fas fa-pencil-alt" theme="outline-success"
                                class="btn-sm" wire:click="habilitar_form_carga({{ $personal->id_asistencia_detalle }})"
                                data-toggle="modal" data-target="#modal-carga" />
                        @endcan

                        @if ($personal->personal->estado_actualizar_id == 1)
                            <a href="{{ route('personal.edit', $personal->personal_id) }}"
                                class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i> Act. Ficha Vol.</a>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100%" class="text-center text-muted">Sin resultados coincidentes...</td>
            </tr>
        @endforelse
        <x-slot name="paginacion">
            {{ $voluntarios->links() }}
        </x-slot>
    </x-table.table>
</div>


@push('scripts')
    <script>
        // ESCUCHAR EVENTOS DE LIVEWIRE
        document.addEventListener('livewire:init', () => {

            // EVENTO PARA ABRIR EL MODAL
            Livewire.on('abrir-modal-carga', (event) => {
                $('#modal-carga').modal('show');
            });

            // EVENTO PARA CERRAR EL MODAL
            Livewire.on('asistencia-cargada', (event) => {
                $('#modal-carga').modal('hide');
            });
        });

        // Limpieza después del cierre del modal
        $('#modal-carga').on('hidden.bs.modal', function() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css('padding-right', '').css('overflow', '');
        });
    </script>
@endpush
