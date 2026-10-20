<div>

    {{-- MODAL COMPONENTE DE ACTUALIZACION PRODUCCION --}}
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
    {{-- Agregamos el total de moviles--}}
  @php
      $cant_moviles_operativos = $datos->sum(function ($compania) {
          $moviles = $compania->ultimaOperatividad?->moviles ?? collect();
  
          return $moviles->where('operativo', true)->count();
      });
  @endphp    
    

<x-adminlte-card theme="secondary" theme-mode="outline" maximizable collapsible>

    <x-slot name="title">
        <div class="d-flex align-items-center flex-wrap" style="gap: 20px;">
            <span>Situación operativa</span>

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
    <button type="button"
        class="btn btn-sm btn-outline-success"
        wire:click="excelParaCondicionGuardia">
        <i class="fas fa-file-excel"></i> Excel Para Condición de Guardia
    </button>

    <button type="button"
        class="btn btn-sm btn-outline-primary ml-1"
        onclick="copiarCondicionGuardia(this)">
        <i class="fas fa-copy"></i> Copiar Información
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
                        <th>Comunicado P.</th>
                        <th>Actualización</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="tabla-operatividad">
                    @forelse ($datos as $compania)
                        <tr>
                            <td>

@php
    $operatividad = $compania->ultimaOperatividad;

    if (!$compania->cca_operativo) {
        $claseEstado = 'badge-danger';
        $textoEstado = 'INOPERATIVO';
    } elseif (($operatividad?->cant_personal ?? 0) == 0) {
        $claseEstado = 'badge-warning';
        $textoEstado = 'OPERATIVO';
    } elseif (($operatividad?->cant_conductor ?? 0) == 0) {
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
                            <td>{{ $compania?->ultimaOperatividad?->comunicado_por ?? 'S/D' }}</td>
                            <td>{{ $compania?->ultimaOperatividad?->fecha_hora?->format('d/m/Y H:i') ?? 'S/D' }}</td>
                            <td class="text-right">
                                <x-adminlte-button label="Actualizar Condición" icon="fas fa-edit" class="btn-sm"
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
    <style>
        .tabla-operatividad tr td {
            font-size: 1.3rem;
            vertical-align: middle;
        }

        .tabla-operatividad .badge {
            font-size: 1rem;
        }
    </style>
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
  <script>
    // =========================================================
    // COPIAR INFORMACIÓN DE CONDICIÓN DE GUARDIA
    // =========================================================
    function copiarCondicionGuardia(boton) {

        const filas = document.querySelectorAll('.tabla-operatividad tr');

        let informacion = [];

        // =========================================================
        // VARIABLES DEL RESUMEN
        // =========================================================

        let totalCompanias = 0;
        let totalPersonal = 0;
        let companiasHidraulico = 0;
        let totalConductores = 0;
        


        // =========================================================
        // RECORRER LAS COMPAÑÍAS
        // =========================================================

        filas.forEach(function(fila) {

            const columnas = fila.querySelectorAll('td');

            // La fila debe tener las 12 columnas de la tabla
            if (columnas.length < 12) {
                return;
            }


            // =====================================================
            // FUNCIÓN PARA LIMPIAR TEXTO
            // =====================================================

            function texto(elemento) {

                if (!elemento) {
                    return 'S/D';
                }

                return elemento.innerText
                    .replace(/\s+/g, ' ')
                    .trim();
            }


            // =====================================================
            // DATOS DE LA COMPAÑÍA
            // =====================================================

            // 0 - Estado
            const estado = texto(columnas[0]);

            // 1 - Compañía
            const compania = texto(columnas[1]);

            // 2 - A cargo
            const acargo = texto(columnas[2]);

            // 3 - Cantidad de personal
            const personal = texto(columnas[3]);

            // 4 - Conductores
            const conductores = texto(columnas[4]);

            // 5 - Móviles
            const moviles = columnas[5].querySelectorAll('.badge');

            let movilesOperativos = '0';
            let movilesInoperativos = '0';

            if (moviles.length >= 1) {
                movilesOperativos = texto(moviles[0]);
            }

            if (moviles.length >= 2) {
                movilesInoperativos = texto(moviles[1]);
            }


            // =====================================================
            // 6 - Autónomos
            // =====================================================

            const autonomos = texto(columnas[6]);


            // =====================================================
            // 7 - Espuma
            // =====================================================

            const espuma = texto(columnas[7]);


            // =====================================================
            // 8 - Hidráulico
            // =====================================================

            const hidraulico = texto(columnas[8]);


            // =====================================================
            // 9 - Pileta
            // =====================================================

            const pileta = texto(columnas[9]);


            // =====================================================
            // 10 - Actualización
            // =====================================================

            const actualizacion = texto(columnas[10]);


            // =====================================================
            // CALCULAR RESUMEN
            // =====================================================

            // Total de compañías
            totalCompanias++;


         

            // Cantidad de personal
            const cantidadPersonal =
                parseInt(personal.replace(/\D/g, '')) || 0;

            totalPersonal += cantidadPersonal;


            // Cantidad de conductores
            const cantidadConductores =
                parseInt(conductores.replace(/\D/g, '')) || 0;

            totalConductores += cantidadConductores;


            // =====================================================
            // COMPAÑÍAS CON HIDRÁULICO OPERATIVO
            // =====================================================

            if (hidraulico.toLowerCase().includes('operativo')) {
                companiasHidraulico++;
            }


            // =====================================================
            // ARMAR INFORMACIÓN DE LA COMPAÑÍA
            // =====================================================

            const bloque = [
                `*${compania}*: ${estado}`,
                `*A cargo:* ${acargo}`,
                `*Cantidad de personal:* ${personal}`,
                `*Conductores:* ${conductores}`,
                `*Móviles operativos:* ${movilesOperativos}`,
                `*Móviles inoperativos:* ${movilesInoperativos}`,
                `*Autónomos:* ${autonomos}`,
                `*Espuma:* ${espuma}`,
                `*Equipo hidráulico:* ${hidraulico}`,
                `*Pileta:* ${pileta}`,
                `*Actualización:* ${actualizacion}`
            ].join('\n');

            informacion.push(bloque);

        });


        // =========================================================
        // VERIFICAR SI HAY INFORMACIÓN
        // =========================================================

        if (informacion.length === 0) {
            alert('No hay información para copiar.');
            return;
        }


        // =========================================================
        // FECHA Y HORA ACTUAL
        // =========================================================

        const ahora = new Date();

        const fechaHora = ahora.toLocaleString('es-PY', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        });


        // =========================================================
        // TEXTO FINAL
        // =========================================================

        const textoFinal =
            `Condición de guardia - ${fechaHora} Hs.\n\n` +

            `Datos extraidos del SINABOM - Sistema Nacional de Bomberos desarrollado por el Dpto de TI\n\n` +

            `Compañías operativas: {{ $cant_companias_operativas ?? 0 }} de {{ $cant_companias ?? 0 }}\n` +

            `Cantidad de personal: {{ $cant_personal ?? 0 }}\n` +

            `Compañías con equipos hidráulicos operativos: {{ $cant_hidraulico ?? 0 }} de {{ $cant_companias ?? 0 }}\n` +

            `Cantidad de conductores: {{ $cant_conductores ?? 0 }}\n` +

            `Cantidad de móviles operativos: {{ $cant_moviles_operativos }}\n\n` +

            informacion.join('\n\n');


        // =========================================================
        // COPIAR AL PORTAPAPELES
        // =========================================================

        navigator.clipboard.writeText(textoFinal)
            .then(function() {

                const textoOriginal = boton.innerHTML;

                boton.innerHTML =
                    '<i class="fas fa-check"></i> ¡Copiado!';

                boton.classList.remove('btn-outline-primary');
                boton.classList.add('btn-outline-success');


                setTimeout(function() {

                    boton.innerHTML = textoOriginal;

                    boton.classList.remove('btn-outline-success');
                    boton.classList.add('btn-outline-primary');

                }, 2000);

            })
            .catch(function(error) {

                console.error('Error al copiar:', error);


                // =================================================
                // MÉTODO ALTERNATIVO
                // =================================================

                const textarea = document.createElement('textarea');

                textarea.value = textoFinal;

                textarea.style.position = 'fixed';
                textarea.style.left = '-9999px';

                document.body.appendChild(textarea);

                textarea.focus();
                textarea.select();


                try {

                    document.execCommand('copy');

                    const textoOriginal = boton.innerHTML;

                    boton.innerHTML =
                        '<i class="fas fa-check"></i> ¡Copiado!';


                    setTimeout(function() {

                        boton.innerHTML = textoOriginal;

                    }, 2000);

                } catch (error) {

                    alert('No se pudo copiar la información.');

                }

                document.body.removeChild(textarea);

            });

    }
</script>
   
   @endpush
