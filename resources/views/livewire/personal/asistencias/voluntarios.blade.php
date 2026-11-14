
<div>
    {{-- MODAL DE CARGA DE ASISTENCIA --}}
    <x-adminlte-modal
        id="modal-carga"
        title="Carga de Asistencia"
        size="lg"
        icon="fas fa-tasks"
        theme="default"
        wire:ignore.self
        v-centered
        static-backdrop
        scrollable
    >
        @if ($detalle)
            @livewire(
                'personal.asistencias.carga2',
                ['detalle' => $detalle],
                key('carga-' . $detalle)
            )
        @endif
    </x-adminlte-modal>

    {{-- ALERTA POR FICHAS PENDIENTES --}}
    @if ($mostrarMensajeAleta)
        <x-adminlte-alert
            theme="danger"
            title="EXISTEN FICHAS NO ACTUALIZADAS. NO PODRA REALIZAR LA CARGA DE ASISTENCIA DE ESOS VOLUNTARIOS"
        />
    @endif

    {{-- TABLA DE VOLUNTARIOS --}}
    <x-table.table titulo="Lista De Voluntarios" ocultarBuscador>

        @can('Personal Asistencias Exportar Pdf')
            <x-slot name="headerBotones">
                <button
                    class="btn btn-sm btn-outline-secondary"
                    wire:click="pdf"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove wire:target="pdf">
                        <i class="far fa-file-pdf"></i>
                        Exportar Listado en PDF
                    </span>

                    <span wire:loading wire:target="pdf">
                        <i class="fas fa-spinner fa-spin"></i>
                        Generando PDF...
                    </span>
                </button>
            </x-slot>
        @endcan

        <x-slot name="cabeceras">

            {{-- NOMBRE COMPLETO --}}
            <th>
                <x-adminlte-input
                    name="buscarNombreCompleto"
                    label="Nombre Completo:"
                    fgroup-class="col-md-12"
                    igroup-size="sm"
                    wire:model.live.debounce.250ms="buscarNombreCompleto"
                    oninput="this.value = this.value.toUpperCase()"
                />
            </th>

            {{-- CÓDIGO --}}
            <th>
                <x-adminlte-input
                    type="number"
                    name="buscarCodigo"
                    label="Código:"
                    fgroup-class="col-md-12"
                    wire:model.live.debounce.250ms="buscarCodigo"
                    igroup-size="sm"
                />
            </th>

            {{-- ESTADO --}}
            <th>
                <x-adminlte-input
                    name="estado"
                    label="Estado:"
                    fgroup-class="col-md-12"
                    igroup-size="sm"
                    disabled
                />
            </th>

            {{-- PRÁCTICA: SOLO P4 --}}
            @if ($asistencia->tipo_asistencia !== 'P5')
                <th>
                    <x-adminlte-input
                        name="practica"
                        label="Práctica:"
                        fgroup-class="col-md-12"
                        igroup-size="sm"
                        readonly
                    />
                </th>
            @endif

            {{-- GUARDIA --}}
            <th>
                <x-adminlte-input
                    name="guardia"
                    label="Guardia:"
                    fgroup-class="col-md-12"
                    igroup-size="sm"
                    readonly
                />
            </th>

            {{-- CITACIÓN --}}
            @if ($asistencia->hubo_citacion)
                <th>
                    <x-adminlte-input
                        name="citacion"
                        label="Citación:"
                        fgroup-class="col-md-12"
                        igroup-size="sm"
                        readonly
                    />
                </th>
            @endif

            {{-- TOTAL --}}
            <th>
                <x-adminlte-input
                    name="total"
                    label="Total:"
                    fgroup-class="col-md-12"
                    igroup-size="sm"
                    readonly
                />
            </th>

            {{-- ACCIONES --}}
            <th>
                <x-adminlte-input
                    name="acciones"
                    label="Acciones:"
                    fgroup-class="col-md-12"
                    igroup-size="sm"
                    readonly
                />
            </th>

        </x-slot>

        {{-- FILAS --}}
        @forelse ($voluntarios as $personal)
            <tr wire:key="fila-{{ $personal->id_asistencia_detalle }}">

                <td>
                    {{ $personal->personal->nombrecompleto ?? 'S/D' }}
                </td>

                <td>
                    {{ $personal->personal->categoria_codigo_juramento ?? 'S/D' }}
                </td>

                <td>
                    {{ $personal->personal->estado->estado ?? 'S/D' }}
                </td>

                {{-- VALOR DE PRÁCTICA: SOLO P4 --}}
                @if ($asistencia->tipo_asistencia !== 'P5')
                    <td>
                        <span class="badge {{ $personal->practica !== null ? 'badge-success' : 'badge-danger' }}">
                            {{ $personal->practica ?? 'S/D' }}
                        </span>
                    </td>
                @endif

                {{-- VALOR DE GUARDIA --}}
                <td>
                    <span class="badge {{ $personal->guardia !== null ? 'badge-success' : 'badge-danger' }}">
                        {{ $personal->guardia ?? 'S/D' }}
                    </span>
                </td>

                {{-- VALOR DE CITACIÓN --}}
                @if ($asistencia->hubo_citacion)
                    <td>
                        <span class="badge {{ $personal->citacion !== null ? 'badge-success' : 'badge-danger' }}">
                            {{ $personal->citacion ?? 'S/D' }}
                        </span>
                    </td>
                @endif

                {{-- TOTAL --}}
                <td>
                    <span class="badge {{ $personal->total !== null ? 'badge-success' : 'badge-danger' }}">
                        {{ $personal->total ?? 'S/D' }}
                    </span>
                </td>

                {{-- ACCIONES --}}
                <td>
                    @can('Personal Asistencias Carga')
                        @if (
                            $bloqueoBtnCargar == true ||
                            $personal->personal->estado_actualizar_id == 1 ||
                            in_array($personal->personal->estado_id, [2, 3, 4, 5, 6, 7, 10, 11])
                        )
                            <x-adminlte-button
                                label="Cargar"
                                icon="fas fa-pencil-alt"
                                theme="outline-success"
                                class="btn-sm"
                                disabled
                            />
                        @else
                            <x-adminlte-button
                                label="Cargar"
                                icon="fas fa-pencil-alt"
                                theme="outline-success"
                                class="btn-sm"
                                wire:click="habilitar_form_carga({{ $personal->id_asistencia_detalle }})"
                                data-toggle="modal"
                                data-target="#modal-carga"
                            />
                        @endif
                    @endcan

                    @if ($personal->personal->estado_actualizar_id == 1)
                        <a
                            href="{{ route('personal.edit', $personal->personal_id) }}"
                            class="btn btn-sm btn-outline-warning"
                        >
                            <i class="fas fa-edit"></i>
                            Act. Ficha Vol.
                        </a>
                    @endif
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="100%" class="text-center text-muted">
                    Sin resultados coincidentes...
                </td>
            </tr>
        @endforelse

        <x-slot name="paginacion">
            {{ $voluntarios->links() }}
        </x-slot>

    </x-table.table>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('abrir-modal-carga', () => {
                $('#modal-carga').modal('show');
            });

            Livewire.on('asistencia-cargada', () => {
                $('#modal-carga').modal('hide');

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Asistencia Registrada!'
                });
            });
        });

        $('#modal-carga').on('hidden.bs.modal', function () {
            $('.modal-backdrop').remove();
            $('body')
                .removeClass('modal-open')
                .css('padding-right', '')
                .css('overflow', '');
        });
    </script>
@endpush
