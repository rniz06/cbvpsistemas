<?php

namespace App\Http\Controllers\ANB\ECB;

use App\Http\Controllers\Controller;

class ExamenFisicoController extends Controller
{

    public function index()
    {

        return view(
            'anb.ecb.examenes-fisicos.index'
        );

    }

}