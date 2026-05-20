<?php

namespace App\Actions\Materiales\Hidraulicos;

use App\Models\Materiales\EquipoHidraulico\Herramienta;
use App\Models\Materiales\EquipoHidraulico\Herramienta\Comentario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PasarHerramientaAInoperativo
{
    /**
     * Create a new class instance.
     */
    public function handle(int $herramientaId): void
    {
        DB::transaction(function () use ($herramientaId) {

            # ACTUALIZAR ESTADO A INOPERATIVO
            Herramienta::findOrFail($herramientaId)->update([
                'operatividad_id' => 0,
                'operativo'       => 0,
            ]);

            # GENERAR COMENTARIO
            Comentario::create([
                'herramienta_id' => $herramientaId,
                'accion_id'      => 2, # FUERA DE SERVICIO
                'comentario'     => "HERRAMIENTA FUERA DE SERVICIO",
                'creadoPor'      => Auth::id(),
            ]);
        });
    }
}
