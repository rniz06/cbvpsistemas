<div>
    <x-adminlte-card theme="secondary" theme-mode="outline" maximizable collapsible>

        <x-slot name="title">
            <div class="d-flex align-items-center flex-wrap" style="gap: 20px;">
                <span>Situación operativa de {{ $cia ?? 'S/D' }}</span>

                <span class="d-inline-flex align-items-center" style="gap: 4px;">
                    <span class="badge badge-success">&nbsp;</span>
                    <small>Operativo</small>
                </span>

                <span class="d-inline-flex align-items-center" style="gap: 4px;">
                    <span class="badge badge-info">&nbsp;</span>
                    <small>Sin conductores</small>
                </span>

                <span class="d-inline-flex align-items-center" style="gap: 4px;">
                    <span class="badge badge-warning">&nbsp;</span>
                    <small>Sin personal</small>
                </span>

                <span class="d-inline-flex align-items-center" style="gap: 4px;">
                    <span class="badge badge-danger">&nbsp;</span>
                    <small>Inoperativo</small>
                </span>
            </div>
        </x-slot>

        <x-slot name="toolsSlot">
            <button type="button" class="btn btn-sm btn-outline-success" wire:click="excelParaCondicionGuardia">
                <i class="fas fa-file-excel"></i> Exportar a Excel
            </button>
        </x-slot>

        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="thead-light">
                    <tr>
                        <th>Estado</th>
                        <th>A cargo</th>
                        <th class="text-center">Personal</th>
                        <th class="text-center">Conductores</th>
                        <th class="text-center">Móviles</th>
                        <th class="text-center">Autónomos</th>
                        <th class="text-center">Espuma</th>
                        <th class="text-center">Hidráulico</th>
                        <th class="text-center">Pileta</th>
                        <th>Comunicado P.</th>
                        <th>Fecha Hora</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($datos as $x)
                        <tr>
                            <td>
                                @php

                                    if (!$x->operativo) {
                                        $claseEstado = 'badge-danger';
                                        $textoEstado = 'INOPERATIVO';
                                    } elseif (($x?->cant_personal ?? 0) == 0) {
                                        $claseEstado = 'badge-warning';
                                        $textoEstado = 'OPERATIVO';
                                    } elseif (($x?->cant_conductor ?? 0) == 0) {
                                        $claseEstado = 'badge-info';
                                        $textoEstado = 'OPERATIVO';
                                    } else {
                                        $claseEstado = 'badge-success';
                                        $textoEstado = 'OPERATIVO';
                                    }
                                @endphp

                                <span class="badge {{ $claseEstado }}">
                                    {{ $textoEstado }}
                                </span>
                            </td>
                            <td>
                                {{ $x->acargo_aux ?? ($x?->acargo_rel?->categoria_codigo_juramento ?? 'S/D') }}
                            </td>
                            <td class="text-center"><span class="badge badge-light border"><i
                                        class="fas fa-users mr-1"></i>
                                    {{ $x->cant_personal ?? 'S/D' }}</span>
                            </td>
                            <td class="text-center"><span class="badge badge-light border"><i
                                        class="fas fa-id-card mr-1"></i>
                                    {{ $x->cant_conductor ?? 'S/D' }}</span>
                            </td>
                            <td class="text-center">
                                @php
                                    $moviles = $x?->moviles ?? collect();

                                    $operativos = $moviles->where('operativo', true)->count();
                                    $inoperativos = $moviles->where('operativo', false)->count();
                                @endphp

                                <span class="badge badge-success mr-1">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    {{ $operativos }}
                                </span>

                                <span class="badge badge-danger">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    {{ $inoperativos }}
                                </span>
                            </td>
                            <td class="text-center"><span
                                    class="badge badge-secondary">{{ $x?->cant_autonomo ?? 'S/D' }}</span>
                            </td>
                            <td class="text-center"><span
                                    class="badge badge-secondary">{{ $x->cant_espuma ?? 'S/D' }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $x?->equipo_hidraulico ? 'badge-success' : 'badge-danger' }}">
                                    <i
                                        class="fas {{ $x?->equipo_hidraulico ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                    {{ $x?->equipo_hidraulico ? 'Operativo' : 'Inoperativo' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $x?->pileta ? 'badge-success' : 'badge-danger' }}">
                                    <i class="fas {{ $x?->pileta ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                    {{ $x?->pileta ? 'Operativo' : 'Inoperativo' }}
                                </span>
                            </td>
                            <td>{{ $x?->comunicado_por ?? 'S/D' }}</td>
                            <td>{{ $x?->fecha_hora?->format('d/m/Y H:i') ?? 'S/D' }}</td>
                        </tr>
                    @empty
                        <td>
                        <td colspan="100%" class="font-weight-bold font-italic">Sin datos registrados...</td>
                        </td>
                    @endforelse
                </tbody>



            </table>
        </div>

        <x-slot name="footerSlot">
            {{ $datos->links() }}
        </x-slot>
    </x-adminlte-card>

</div>
