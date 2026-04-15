<?php

namespace App\Actions\Materiales\Menor;

use Illuminate\Support\Facades\Auth;

class CrearComentarioItemAccion
{
    /**
     * GENERA COMENTARIO AUTOMATICO CUANOD SE ACTUALIZA UN REGISTRO DE MATERIAL MENOR
     */
    public function execute($item): void
    {
        if ($item) {
            $comentario = "ITEM: {$item->componente->nombre} | OPERATIVO: {$item->cantidad_operativo} | INOPERATIVO: {$item->cantidad_inoperativo}";

            $item->comentarios()->create([
                'comentario' => $comentario,
                'accion_id'  => 3, # REPORTE
                'creadoPor'  => Auth::id(),
            ]);
        }
    }
}
