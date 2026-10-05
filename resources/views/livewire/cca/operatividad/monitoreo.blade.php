<div>

    {{-- MODAL COMPONENTE DE ACTUALIZACION --}}
    <div wire:ignore.self>
        <x-adminlte-modal id="modal-actualizar" title="Actualizar Condición de guardia" theme="light" icon="fas fa-edit"
            v-centered static-backdrop size="xl">
            @if ($companiaId)
                @livewire('cca.operatividad.form', ['companiaId' => $companiaId], key('modal-edit' . $companiaId))
            @endif
            <x-slot name="footerSlot"></x-slot>
        </x-adminlte-modal>
    </div>

    {{-- WIDGETS RESUMEN COMPACTOS --WIDGETS DE SITUACIÓN OPERATIVA --}}
    {{-- <x-adminlte-card theme="secondary" theme-mode="outline"> --}}
    <div class="row">
        {{-- COMPANIAS OPERATIVAS --}}
        <x-adminlte-info-box title="Compañías Operativas"
            text="{{ $cant_companias_operativas ?? 'S/D' }}/{{ $cant_companias ?? 'S/D' }}" icon="fas fa-building"
            class="col-xl-2 col-md-4 col-12 px-1" />

        {{-- PERSONAL DE GUARDIA --}}
        <x-adminlte-info-box title="Cant. Personal de guardia" text="{{ $cant_personal ?? 'S/D' }}"
            icon="fas fa-user-friends" class="col-xl-2 col-md-4 col-12 px-1" />

        {{-- EQUIPO HIDRAULICO --}}
        <x-adminlte-info-box title="Comp. Con E. Hidraulico"
            text="{{ $cant_hidraulico ?? 'S/D' }}/{{ $cant_companias ?? 'S/D' }}" icon="fas fa-building"
            class="col-xl-2 col-md-4 col-12 px-1" />

        {{-- CANTIDAD DE CONDUCTORES --}}
        <x-adminlte-info-box title="Cantidad de Conductores" text="{{ $cant_conductores ?? 'S/D' }}"
            icon="fas fa-building" class="col-xl-2 col-md-4 col-12 px-1" />


        <x-adminlte-select name="buscarCompaniaId" wire:model.live.debounce.150ms="buscarCompaniaId"
            label-class="text-black" fgroup-class="col-xl-2 col-md-4 col-12 px-1" label="Filtro por Compañías">
            <option value="">Todas las compañías</option>

            @forelse ($companias as $compania)
                <option value="{{ $compania->id_compania }}">
                    {{ $compania->compania ?? 'S/D' }}
                </option>
            @empty
                <option value="">Sin Datos...</option>
            @endforelse
        </x-adminlte-select>


        <x-adminlte-select name="buscarOperatividad" wire:model.live.debounce.150ms="buscarOperatividad"
            label-class="text-black" fgroup-class="col-xl-2 col-md-4 col-12 px-1" label="Filtro por Operatividad">
            <option value="">Todas Operativo/Inoperativo</option>
            <option value="true">Operativo</option>
            <option value="false">Inoperativo</option>
        </x-adminlte-select>
    </div>

    {{-- </x-adminlte-card> --}}

    {{-- Tabla Monitoreo --}}
    <x-adminlte-card theme="secondary" theme-mode="outline" title="Situación operativa" maximizable collapsible>

        <x-slot name="toolsSlot">
            <button type="button" class="btn btn-sm btn-outline-success" wire:click="excelParaCondicionGuardia">
                <i class="fas fa-file-excel"></i> Excel Para Condición de Guardia
            </button>
        </x-slot>

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
                            <td class="text-center"><span class="badge badge-light border"><i
                                        class="fas fa-users mr-1"></i>
                                    {{ $compania->ultimaOperatividad->cant_personal ?? 'S/D' }}</span>
                            </td>
                            <td class="text-center"><span class="badge badge-light border"><i
                                        class="fas fa-id-card mr-1"></i>
                                    {{ $compania->ultimaOperatividad->cant_conductor ?? 'S/D' }}</span>
                            </td>
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
                                    class="badge badge-secondary">{{ $compania->ultimaOperatividad?->cant_autonomo ?? 'S/D' }}</span>
                            </td>
                            <td class="text-center"><span
                                    class="badge badge-secondary">{{ $compania->ultimaOperatividad->cant_espuma ?? 'S/D' }}</span>
                            </td>
                            <td>
                                <span
                                    class="badge {{ $compania->ultimaOperatividad?->equipo_hidraulico ? 'badge-success' : 'badge-danger' }}">
                                    <i
                                        class="fas {{ $compania->ultimaOperatividad?->equipo_hidraulico ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                    {{ $compania->ultimaOperatividad?->equipo_hidraulico ? 'Operativo' : 'Inoperativo' }}
                                </span>
                            </td>
                            <td>
                                <span
                                    class="badge {{ $compania->ultimaOperatividad?->pileta ? 'badge-success' : 'badge-danger' }}">
                                    <i
                                        class="fas {{ $compania->ultimaOperatividad?->pileta ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                    {{ $compania->ultimaOperatividad?->pileta ? 'Operativo' : 'Inoperativo' }}
                                </span>
                            </td>
                            <td>{{ $compania?->ultimaOperatividad?->fecha_hora?->format('d/m/Y H:i') ?? 'S/D' }}</td>
                            <td class="text-right">
                                <x-adminlte-button label="Actualizar Condición" icon="fas fa-edit"
                                    class="btn-sm"
                                    wire:click="abrirModalActualizar({{ $compania->id_compania }})" />
                                {{-- <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-secondary dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        Acciones
                                    </button>
                                    <div class="dropdown-menu">
                                        <x-adminlte-button label="Ver Móviles" icon="fas fa-car"
                                            class="dropdown-item btn-sm" />
                                        <button class="dropdown-item"><i class="fas fa-history mr-1"></i>Ver
                                            historial</button>
                                        <x-adminlte-button label="Actualizar Condición" icon="fas fa-edit"
                                            class="dropdown-item btn-sm"
                                            wire:click="abrirModalActualizar({{ $compania->id_compania }})" />
                                    </div>
                                </div> --}}
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>

            </table>
        </div>
    </x-adminlte-card>
</div>

@push('styles')
@endpush

@push('scripts')
    <script>
        //ABRIR MODAL DE EDICION
        document.addEventListener('livewire:init', () => {
            Livewire.on('abrir-modal-actualizar', () => {
                $('#modal-actualizar').modal('show');
            });

            // Limpiar el ID en el componente padre cuando se CIERRA el modal
            $('#modal-actualizar').on('hidden.bs.modal', function() {
                @this.call('cerrarModalActualizar');
            });
        });
    </script>
@endpush
