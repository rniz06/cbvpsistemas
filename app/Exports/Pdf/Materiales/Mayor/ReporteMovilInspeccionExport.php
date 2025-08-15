<?php

namespace App\Exports\Pdf\Materiales\Mayor;

use App\Models\Vistas\Materiales\VtMayor;
use App\Models\Vistas\Materiales\VtMayorComentario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReporteMovilInspeccionExport
{
    protected $id_movil, $movil, $comentarios;

    public function __construct($id_movil)
    {
        $this->id_movil = $id_movil;
        $this->movil = VtMayor::findOrFail($id_movil);
        $this->comentarios = VtMayorComentario::select('comentario','accion', 'accion_categoria', 'categoria_detalle', 'nombrecompleto', 'created_at')
            ->where('movil_id', $id_movil)
            ->orderByDesc('created_at')
            ->limit(2)
            ->get();
    }

    public function download()
    {
        $usuario = Auth::user();
        $fechaYhora = now();
        $pdf = Pdf::loadView('materiales.mayor.pdf.reporte-movil-inspeccion', [
            'movil'       => $this->movil,
            'comentarios' => $this->comentarios,
            'fechaYhora'  => $fechaYhora,
            'usuario'     => $usuario
        ]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Ficha Movil DMM-CBVP.pdf');
    }
}
