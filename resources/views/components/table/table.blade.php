<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            {{ $titulo ?? '' }}

            @isset($headerBotones)
                {{ $headerBotones }}
            @endisset

            @isset($excel)
                <button class="btn btn-sm btn-outline-success" wire:click="{{ $excel }}">
                    <i class="fas fa-file-excel"></i> Excel
                </button>
            @endisset

            @isset($pdf)
                <button class="btn btn-sm btn-outline-secondary" wire:click="pdf">
                    <i class="fas fa-file-pdf"></i> Pdf
                </button>
            @endisset
        </h3>

        @if (!isset($ocultarBuscador))
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text"class="form-control float-right" placeholder="Buscar..."
                        wire:model.live="{{ $personalizarBuscador ?? 'buscador' }}">

                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif


    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead>
                @if (isset($cabeceras))
                    <tr>
                        {{ $cabeceras }}
                    </tr>
                @endif
            </thead>
            <tbody>
                @if (trim($slot) == '')
                    <tr>
                        <td colspan="100%" class="text-center text-muted">Sin resultados</td>
                    </tr>
                @else
                    {{ $slot }}
                @endif
            </tbody>
        </table>
    </div>



    <!-- /.card-body -->

    @if (isset($paginacion))
        <div class="card-footer clearfix">
            <center><select class="col-1 form-control form-control-sm mb-4"
                    wire:model.live="{{ $personalizarPaginacion ?? 'paginado' }}">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select></center>
            {{ $paginacion }}
        </div>
    @endif
</div>
