<?php

namespace App\Exports\Pdf\Materiales\Menor\Marcas;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ListaMenorMarcasPdf
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
        $pdf = Pdf::loadView('materiales.menor.pdf.lista-menor-marcas-pdf', ['datos' => $this->datos, 'usuario' => Auth::user()]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $this->nombre_archivo . '.pdf');
    }
}