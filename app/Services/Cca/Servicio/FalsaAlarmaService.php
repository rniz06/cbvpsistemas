<?php

namespace App\Services\Cca\Servicio;

use App\Models\Cca\Servicios\Comentario;
use App\Models\Cca\Servicios\Existente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FalsaAlarmaService
{
    /**
     * ACCION PARA DECLARAR UN SERVICIO COMO FALSA ALARMA
     */
    public function handle(int $servicioId): void
    {
        DB::transaction(function () use ($servicioId) {
            # OBTENER EL REGISTRO
            $servicio = Existente::findOrFail($servicioId);

            # ACTUALIZAR CAMPOS DE LA TABLA
            $servicio->update([
                'falsa_alarma'   => true,
                'actualizadoPor' => Auth::id(),
            ]);

            # GENERAR COMENTARIO AUTOMATICO
            Comentario::create([
                'comentario'  => 'DECLARADO COMO FALSA ALARMA',
                'servicio_id' => $servicioId,
                'creadoPor'   => Auth::id()
            ]);
        });
    }
}
