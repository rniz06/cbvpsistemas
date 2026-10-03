<?php

namespace App\Http\Controllers\ANB\ECB;

use App\Http\Controllers\Controller;
use App\Models\ANB\ECB\ExamenFisico;

class ExamenFisicoPruebaController extends Controller
{

    public function index(
        ExamenFisico $examen
    )
    {

        return view(

            'anb.ecb.examenes-fisicos.pruebas.index',

            compact(
                'examen'
            )

        );

    }

}