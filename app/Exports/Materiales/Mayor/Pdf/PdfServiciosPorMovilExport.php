<?php

namespace App\Exports\Materiales\Mayor\Pdf;

use Barryvdh\DomPDF\Facade\Pdf;

class PdfServiciosPorMovilExport
{
    // Reporte Pdf generado desde
    // materiales/mayor/servicios-por-movil/
    protected $datos;
    protected $nombre_archivo;

    public function __construct($datos, $nombre_archivo)
    {
        $this->datos = $datos;
        $this->nombre_archivo = $nombre_archivo;
    }

    public function download()
    {
        $pdf = Pdf::loadView('materiales.mayor.pdf.reporte-servicios-por-movil', ['nombre_archivo' => $this->nombre_archivo, 'datos' => $this->datos]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $this->nombre_archivo . '.pdf');
    }
}