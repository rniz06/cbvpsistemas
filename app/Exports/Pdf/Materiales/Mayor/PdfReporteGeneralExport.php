<?php

namespace App\Exports\Pdf\Materiales\Mayor;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PdfReporteGeneralExport
{
    protected $datos, $nombre_archivo;

    public function __construct($datos, $nombre_archivo = "Mayor")
    {
        $this->datos = $datos;
        $this->nombre_archivo = $nombre_archivo;
    }

    public function download()
    {
        $usuario = Auth::user();
        $pdf = Pdf::loadView('materiales.mayor.pdf.general', [
            'moviles'     => $this->datos,
            'usuario'     => $usuario
        ]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $this->nombre_archivo.'.pdf');
    }
}
