@props([
    'titulo' => null,
    'icono' => null,
    'tema' => 'secondary',
    'tema_modo' => 'outline',
    'excel' => null,
    'pdf' => null,
    'buscador' => null,
    'cabeceras' => null,
    'paginacion' => null,
    'paginado' => 'paginado',
    'dropdown_direccion' => '', // Opciones: dropright, dropleft, dropup.
    'acciones' => null,
])

<x-adminlte-card :icon="$icono" :title="$titulo"  :theme="$tema" :theme-mode="$tema_modo" header-class="text-dark">

    {{-- HERRAMIENTAS DEL ENCABEZADO --}}
    @if ($buscador || $excel || $pdf || $acciones)
        <x-slot name="toolsSlot">

            <div class="d-flex justify-content-center align-items-center">

                {{-- ACCIONES --}}
                <div class="btn-group {{$dropdown_direccion}}">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                        aria-expanded="false">
                        Acciones
                    </button>
                    <div class="dropdown-menu">
                        @isset($acciones)
                            {{ $acciones }}
                        @endisset
                        {{-- <a class="dropdown-item" href="#">Crear</a> --}}
                        <div class="dropdown-divider"></div>
                        {{-- ACCIONES ESTATICAS EXCEL Y PDF --}}
                        @if ($excel)
                            <x-adminlte-button label="Excel" class="btn-sm dropdown-item" icon="fas fa-file-excel"
                                wire:click="{{ $excel }}" />
                        @endif

                        @if ($pdf)
                            <x-adminlte-button label="Pdf" class="btn-sm dropdown-item" icon="fas fa-file-pdf"
                                wire:click="{{ $pdf }}" />
                        @endif
                    </div>
                </div>

                {{-- BUSCADOR --}}
                @if ($buscador)
                    <div class="input-group input-group-sm ml-2">
                        <input type="text" name="{{ $buscador ?? 'buscador' }}" class="form-control form-control-sm"
                            placeholder="Buscar..." wire:model.live.debounce.150ms="{{ $buscador ?? 'buscador' }}">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </x-slot>
    @endif

    {{-- CONTENIDO --}}

    <div class="table-responsive">
        <table class="table table-sm table-bordered table-hover table-striped">
            <thead>
                <tr class="text-center">
                    @isset($encabezados)
                        {{ $encabezados }}
                    @endisset
                </tr>
            </thead>
            <tbody>
                @isset($slot)
                    {{ $slot }}
                @endisset
            </tbody>
            @isset($pie)
                <tfoot>
                    {{ $pie }}
                </tfoot>
            @endisset
        </table>
    </div>


    {{-- PIE DE PAGINA --}}
    @if ($paginacion)
        <x-slot name="footerSlot">
            <div class="d-flex justify-content-between align-items-center m-2">
                <div class="">
                    <select class="form-control form-control-sm" style="width: 55px; display:inline-block;"
                        wire:model.live.debounce.150ms="{{ $paginado ?? 'paginado' }}">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                    </select>
                    <small>Por página</small>
                </div>
                <div>
                    {{ $paginacion }}
                </div>
            </div>
        </x-slot>
    @endif

</x-adminlte-card>