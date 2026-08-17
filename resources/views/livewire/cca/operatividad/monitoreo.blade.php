<div>

    {{-- Tabla Monitoreo --}}
    <x-adminlte-card theme="secondary" theme-mode="outline" title="Situación operativa" maximizable collapsible>

        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="thead-light">
                    <tr>
                        <th>Estado</th>
                        <th>Compañía</th>
                        <th>A cargo</th>
                        <th class="text-center">Personal</th>
                        <th class="text-center">Conductores</th>
                        <th class="text-center">Móviles</th>
                        <th class="text-center">Autónomos</th>
                        <th class="text-center">Espuma</th>
                        <th class="text-center">Hidráulico</th>
                        <th class="text-center">Pileta</th>
                        <th>Actualización</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($datos as $compania)
                        <tr>
                            <td>
                                <span class="badge {{ $compania->cca_operativo ? 'badge-success' : 'badge-danger' }}">
                                    <i
                                        class="fas {{ $compania->cca_operativo ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                    {{ $compania->cca_operativo ? 'Operativo' : 'Inoperativo' }}
                                </span>
                            </td>
                            <td>{{ $compania->compania ?? 'S/D' }}</td>
                            <td>
                                {{ $compania->ultimaOperatividad?->acargo_aux ??
                                    ($compania->ultimaOperatividad?->acargo_rel?->categoria_codigo_juramento ?? 'S/D') }}
                            </td>
                            <td class="text-center"><span
                                    class="badge badge-secondary">{{ $compania->ultimaOperatividad->cant_personal ?? 'S/D' }}</span>
                            </td>
                            <td class="text-center"><span
                                    class="badge badge-secondary">{{ $compania->ultimaOperatividad->cant_conductor ?? 'S/D' }}</span>
                            </td>
                            {{-- <td>
                                <ul>
                                    @forelse ($compania->ultimaOperatividad->moviles as $movil)
                                        @if ($movil->operativo == true)
                                            <li><span class="badge badge-success">{{ $movil->movil->acronimo->tipo . '-' . $movil->movil->movil }}</span></li>
                                        @else
                                        <li><span class="badge badge-danger">{{ $movil->movil->acronimo->tipo . '-' . $movil->movil->movil }}</span></li>
                                        @endif
                                    @empty
                                        <li>Sin datos de moviles</li>
                                    @endforelse
                                </ul>
                            </td> --}}
                            <td class="text-center">
                                @php
                                    $moviles = $compania->ultimaOperatividad?->moviles ?? collect();

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
                                    class="badge badge-secondary">{{ $compania->ultimaOperatividad->cant_autonomo ?? 'S/D' }}</span>
                            </td>
                            <td class="text-center"><span
                                    class="badge badge-secondary">{{ $compania->ultimaOperatividad->cant_espuma ?? 'S/D' }}</span>
                            </td>
                            <td>
                                <span
                                    class="badge {{ $compania->ultimaOperatividad->equipo_hidraulico ? 'badge-success' : 'badge-danger' }}">
                                    <i
                                        class="fas {{ $compania->ultimaOperatividad->equipo_hidraulico ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                    {{ $compania->ultimaOperatividad->equipo_hidraulico ? 'Operativo' : 'Inoperativo' }}
                                </span>
                            </td>
                            <td>
                                <span
                                    class="badge {{ $compania->ultimaOperatividad->pileta ? 'badge-success' : 'badge-danger' }}">
                                    <i
                                        class="fas {{ $compania->ultimaOperatividad->pileta ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                    {{ $compania->ultimaOperatividad->pileta ? 'Operativo' : 'Inoperativo' }}
                                </span>
                            </td>
                            <td>{{ $compania->ultimaOperatividad->fecha_hora->format('d/m/Y H:m') ?? 'S/D' }}</td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>

            </table>
        </div>
    </x-adminlte-card>
    {{ $datos ?? 'S/D' }}
</div>
