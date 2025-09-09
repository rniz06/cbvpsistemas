<?php

namespace App\Services\Cca\Despacho;

use App\Models\Cca\Servicios\ServicioMovilReporte;
use App\Models\Materiales\Movil\MovilComentario;

class RegistrarEstadoDeMovilAlDespachar
{
    /**
     * Registrar el estado del móvil al realizar el despacho.
     */
    public function ejecutar($servicioId, $movilId)
    {
        // Buscar el id del ultimo comentario/accion
        $ultComentarioId = MovilComentario::where('movil_id', $movilId)
            ->whereIn('accion_id', [1, 2])
            ->latest('id_movil_comentario')
            ->first();

        // Registrar en la tabla
        ServicioMovilReporte::create([
            'servicio_id' => $servicioId,
            'movil_id' => $movilId,
            'comentario_id' => $ultComentarioId->id_movil_comentario ?? null,
        ]);
    }
}
