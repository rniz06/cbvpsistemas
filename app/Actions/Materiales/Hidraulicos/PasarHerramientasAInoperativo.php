<?php

namespace App\Actions\Materiales\Hidraulicos;

use App\Models\Materiales\EquipoHidraulico\Herramienta;
use App\Models\Materiales\EquipoHidraulico\Herramienta\Comentario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PasarHerramientasAInoperativo
{
    /**
     * Create a new class instance.
     */
    public function handle(array $herramientasIds): void
    {
        DB::transaction(function () use ($herramientasIds) {

            $herramientas = Herramienta::whereIn('id_hidraulico_herr', $herramientasIds)
                ->with('tipo')
                ->get();

            foreach ($herramientas as $herramienta) {

                # ACTUALIZAR ESTADO A INOPERATIVO
                $herramienta->update([
                    'operatividad_id' => 0,
                    'operativo'       => 0,
                ]);

                # REGISTRAR COMENTARIO PARA CADA HERRAMIENTA
                Comentario::create([
                    'herramienta_id' => $herramienta->id_hidraulico_herr,
                    'accion_id'      => 2, # FUERA DE SERVICIO
                    'comentario'     => "HERRAMIENTA FUERA DE SERVICIO",
                    'creadoPor'      => Auth::id(),
                ]);
            }
        });
    }
}
