<?php

namespace App\Actions\Materiales\Menor;

use App\Models\Materiales\Menor\Item;
use Illuminate\Support\Facades\Auth;

class AplicarAccionItem
{
    /**
     * PASA A OPERATIVO, INOPERATIVO O BAJA SEGUN LA ACCION
     */
    public function handle(int $accionId, int $itemId): void
    {
        if ($accionId) {
            $userId = Auth::id();
            $item = Item::findOrFail($itemId);

            switch ($accionId) {
                case 1: # EN SERVICIO
                    $item->update(['estado_id' => 1, 'actualizadoPor' => $userId]);
                    break;
                case 2: # FUERA DE SERVICIO
                    $item->update(['estado_id' => 0, 'actualizadoPor' => $userId]);
                    break;
                case 4: # DAR DE BAJA
                    $item->update(['estado_id' => 2, 'actualizadoPor' => $userId]);
                    break;

                default:
                    # code...
                    break;
            }
        }
    }
}
