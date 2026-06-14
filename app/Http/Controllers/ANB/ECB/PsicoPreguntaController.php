<?php

namespace App\Http\Controllers\ANB\ECB;

use App\Http\Controllers\Controller;
use App\Models\ANB\ECB\PsicoTest;

class PsicoPreguntaController extends Controller
{

    public function index(
        PsicoTest $test
    )
    {

        return view(

            'anb.ecb.psico-tests.preguntas.index',

            compact(
                'test'
            )

        );

    }

}