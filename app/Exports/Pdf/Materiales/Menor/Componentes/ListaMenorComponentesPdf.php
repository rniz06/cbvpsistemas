<?php

namespace App\Exports\Pdf\Materiales\Menor\Componentes;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ListaMenorComponentesPdf
{
    protected $datos;
    protected $nombre_archivo;
    protected $subtitulo;

    public function __construct($datos, $nombre_archivo = 'Documento', $subtitulo = null)
    {
        $this->datos          = $datos;
        $this->nombre_archivo = $nombre_archivo;
        $this->subtitulo = $subtitulo;
    }

    public function download()
    {
        $pdf = Pdf::loadView('materiales.menor.pdf.lista-menor-componentes-pdf', ['datos' => $this->datos, 'usuario' => Auth::user(), 'subtitulo' => $this->subtitulo]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $this->nombre_archivo . '.pdf');
    }
}
