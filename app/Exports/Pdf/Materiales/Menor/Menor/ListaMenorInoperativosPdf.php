<?php

namespace App\Exports\Pdf\Materiales\Menor\Menor;

use Barryvdh\DomPDF\Facade\Pdf;

class ListaMenorInoperativosPdf
{
    protected $datos;
    protected $nombre_archivo;

    public function __construct($datos, $nombre_archivo = 'Documento')
    {
        $this->datos          = $datos;
        $this->nombre_archivo = $nombre_archivo;
    }

    public function download()
    {
        $pdf = Pdf::loadView('materiales.menor.pdf.lista-menor-inoperativos-pdf', ['datos' => $this->datos]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $this->nombre_archivo . '.pdf');
    }
}