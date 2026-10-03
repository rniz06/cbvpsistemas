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
            title="EXISTEN FICHAS NO ACTUALIZADAS. NO PODRA REALIZAR LA CARGA DE ASISTENCIA DE ESOS VOLUNTARIOS" />
    @endif

    {{-- Tabla de Voluntarios --}}
    <x-table.table titulo="Lista De Voluntarios" ocultarBuscador>

        @can('Personal Asistencias Exportar Pdf')
            <x-slot name="headerBotones">
                <button class="btn btn-sm btn-outline-secondary" wire:click="pdf" wire:loading.attr="disabled">

                    {{-- Estado normal --}}
                    <span wire:loading.remove wire:target="pdf">
                        <i class="far fa-file-pdf"></i> Exportar Listado en PDF
                    </span>

                    {{-- Estado cargando --}}
                    <span wire:loading wire:target="pdf">
                        <i class="fas fa-spinner fa-spin"></i> Generando PDF...
                    </span>

                </button>
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

            {{-- Estado --}}
            <th>
                <div>
                    <x-adminlte-input name="" label="Estado:" fgroup-class="col-md-12" igroup-size="sm"
                        disabled />
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
            @if ($asistencia->hubo_citacion == true)
                <th>
                    <div>
                        <x-adminlte-input name="" label="Citación:" fgroup-class="col-md-12" igroup-size="sm"
                            readonly />
                    </div>
                </th>
            @endif

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

        @forelse ($voluntarios as $personal)
            <tr wire:key="fila-{{ $personal->id_asistencia_detalle }}">
                <td>{{ $personal->personal->nombrecompleto ?? 'S/D' }}</td>
                <td>{{ $personal->personal->categoria_codigo_juramento ?? 'S/D' }}</td>
                <td>{{ $personal->personal->estado->estado ?? 'S/D' }}</td>

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
                @if ($asistencia->hubo_citacion == true)
                    <td><span class="badge {{ $personal->citacion !== null ? 'badge-success' : 'badge-danger' }}">
                            {{ $personal->citacion ?? 'S/D' }}
                        </span></td>
                @endif
                <td><span class="badge {{ $personal->total !== null ? 'badge-success' : 'badge-danger' }}">
                        {{ $personal->total ?? 'S/D' }}
                    </span></td>
                <td>
                    @can('Personal Asistencias Carga')
                        {{-- Boton Carga --}}
                        @if (
                            $bloqueoBtnCargar == true or
                                $personal->personal->estado_actualizar_id == 1 or
                                in_array($personal->personal->estado_id, [2, 3, 4, 5, 6, 7, 10, 11]))
                            <x-adminlte-button label="Cargar" icon="fas fa-pencil-alt" theme="outline-success"
                                class="btn-sm" disabled />
                        @else
                            <x-adminlte-button label="Cargar" icon="fas fa-pencil-alt" theme="outline-success"
                                class="btn-sm" wire:click="habilitar_form_carga({{ $personal->id_asistencia_detalle }})"
                                data-toggle="modal" data-target="#modal-carga" />
                        @endif
                    @endcan

                    @if ($personal->personal->estado_actualizar_id == 1)
                        <a href="{{ route('personal.edit', $personal->personal_id) }}"
                            class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i> Act. Ficha Vol.</a>
                    @endif
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

                // EMITIR UNA NOTIFICACION DE EXITO EN LA PANTALLA SUPERIOR LADO DERECHO
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: "Asistencia Registrada!"
                });
            });
        });

        // Limpieza después del cierre del modal
        $('#modal-carga').on('hidden.bs.modal', function() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css('padding-right', '').css('overflow', '');
        });
    </script>
@endpush
