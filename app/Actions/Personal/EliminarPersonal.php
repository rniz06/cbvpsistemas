<?php

namespace App\Actions\Personal;

use App\Models\Personal;
use Illuminate\Support\Facades\DB;

class EliminarPersonal
{
    /**
     * Elimina un registro del modelo Personal..
     */
    public function handle(Personal $personal): void
    {
        DB::transaction(function () use ($personal) {

            $personal->tableusuario?->delete();

            $personal->delete();
        });
    }
}
