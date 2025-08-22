<?php

namespace App\Livewire\Materiales\Mayor;

use App\Exports\Materiales\Mayor\Excel\ExcelServiciosPorMovilExport;
use App\Exports\Materiales\Mayor\Pdf\PdfServiciosPorMovilExport;
use App\Models\Vistas\Cca\VtExistente;
use App\Models\Vistas\Materiales\VtMayor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ServiciosPorMovil extends Component
{
    // AL GENERAR EL REPORTE PDF O EXCEL TENER EN CUENTA
    // ANADIR EL CAMPO MOVIL EJ: AB-154 Y EL CAMPO COMPANIA
    // QUE NO SE MUESTRAN EN CADA FILA DE LA TABLA DE LA VISTA,
    // SE MUESTRAN SOLO UNA VEZ EN EL ENCABEZADO
    use WithPagination;

    public $movil;
    public $buscador = '';
    public $paginado = 10;

    public function mount(VtMayor $movil)
    {
        $this->movil = $movil;
    }

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if ($key === 'buscador' || $key === 'paginado') {
            $this->resetPage();
        }
    }

    public function render()
    {
        return view('livewire.materiales.mayor.servicios-por-movil', [
            'servicios' => VtExistente::select(
                'id_servicio_existente',
                'servicio',
                'fecha_alfa',
                'acargo',
                'acargo_nombrecompleto',
                'acargo_codigo',
                'acargo_categoria',
                'acargo_aux',
                'chofer_nombrecompleto',
                'chofer_codigo',
                'chofer_categoria',
                'chofer_aux',
                'chofer_rentado'
            )->where('movil_id', $this->movil->id_movil)
            ->orderByDesc('fecha_alfa')
            ->paginate($this->paginado)
        ]);
    }

    public function cargarDatosExport()
    {
        return VtExistente::select(
                DB::raw("CONCAT(CCA_vt_servicios_existentes.tipo,'-',CCA_vt_servicios_existentes.movil)  AS movil"),
                'compania',
                'servicio',
                'fecha_alfa',
                'acargo',
                'acargo_nombrecompleto',
                'acargo_codigo',
                'acargo_categoria',
                'acargo_aux',
                'chofer_nombrecompleto',
                'chofer_codigo',
                'chofer_categoria',
                'chofer_aux',
                'chofer_rentado'
            )->where('movil_id', $this->movil->id_movil)
            ->orderByDesc('fecha_alfa')
            ->get();
    }

    public function pdf()
    {
        $nombre_archivo = "Servicios Del Móvil " . $this->movil->tipo . '-' . $this->movil->movil;
        $datos = $this->cargarDatosExport();

        return (new PdfServiciosPorMovilExport($datos, $nombre_archivo))->download();
    }

    public function excel()
    {
        $nombre_archivo = "Servicios Del Móvil " . $this->movil->tipo . '-' . $this->movil->movil;
        $datos = $this->cargarDatosExport();

        return Excel::download(new ExcelServiciosPorMovilExport($datos), $nombre_archivo.'.xlsx');
    }
}
