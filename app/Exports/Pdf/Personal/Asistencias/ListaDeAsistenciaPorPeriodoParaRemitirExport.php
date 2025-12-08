<?php

namespace App\Exports\Pdf\Personal\Asistencias;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ListaDeAsistenciaPorPeriodoParaRemitirExport
{
    protected $query, $nombre_archivo = "Listado de Asistencias", $periodo, $compania;

    public function __construct($query, $nombre_archivo, $periodo, $compania)
    {
        $this->query          = $query;
        $this->nombre_archivo = $nombre_archivo;
        $this->periodo        = $periodo;
        $this->compania       = $compania;
    }

    public function download()
    {
        $usuario = Auth::user();
        $pdf = Pdf::loadView('personal.asistencias.pdf.lista-de-asistencias-por-periodo-para-remitir-export', [
            'query'       => $this->query,
            'usuario'     => $usuario,
            'periodo'     => $this->periodo,
            'compania'    => $this->compania
        ]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $this->nombre_archivo.'.pdf');
    }
}
