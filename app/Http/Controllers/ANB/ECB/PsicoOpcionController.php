<?php

namespace App\Http\Controllers\ANB\ECB;

use App\Http\Controllers\Controller;
use App\Models\ANB\ECB\PsicoPregunta;

class PsicoOpcionController extends Controller
{

    public function index(
        PsicoPregunta $pregunta
    )
    {

        return view(

            'anb.ecb.psico-tests.opciones.index',

            compact(
                'pregunta'
            )

        );

    }

}