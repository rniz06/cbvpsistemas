<?php

namespace App\Http\Controllers\ANB\ECB;

use App\Http\Controllers\Controller;
use App\Models\ANB\ECB\ExamenFisicoPrueba;

class ExamenFisicoParametroController extends Controller
{

    public function index(
        ExamenFisicoPrueba $prueba
    )
    {

        return view(

            'anb.ecb.examenes-fisicos.parametros.index',

            compact(
                'prueba'
            )

        );

    }

}