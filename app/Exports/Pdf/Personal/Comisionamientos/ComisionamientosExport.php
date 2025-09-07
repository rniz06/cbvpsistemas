<?php

namespace App\Exports\Pdf\Personal\Comisionamientos;

use App\Models\Vistas\Materiales\VtMayor;
use App\Models\Vistas\Materiales\VtMayorComentario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ComisionamientosExport
{
    protected $query, $nombre_archivo = "Listado de Comisionamientos CBVP";

    public function __construct($query, $nombre_archivo)
    {
        $this->query = $query;
        $this->nombre_archivo = $nombre_archivo;
    }

    public function download()
    {
        $usuario = Auth::user();
        $fechaYhora = now();
        $pdf = Pdf::loadView('personal.comisionamientos.pdf.comisionamientos-export', [
            'query'       => $this->query,
            'fechaYhora'  => $fechaYhora,
            'usuario'     => $usuario
        ]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $this->nombre_archivo.'.pdf');
    }
}
