<?php

namespace App\Actions\Personal;

use App\Models\Personal;

class EliminarPersonal
{
    /**
     * Elimina un registro del modelo Personal..
     */
    public function handle(Personal $personal): void
    {
        # VALIDAR QUE EXISTE REGISTRO CON ESE ID
        if (!$personal->exists) {
            throw new \Exception('EL REGISTRO CON ESE ID NO EXISTE');
        }

        # ELIMINAR REGISTRO
        $personal->delete();
    }
}
