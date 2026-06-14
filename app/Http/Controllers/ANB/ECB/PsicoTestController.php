<?php

namespace App\Http\Controllers\ANB\ECB;

use App\Http\Controllers\Controller;

class PsicoTestController extends Controller
{

    public function index()
    {

        return view(
            'anb.ecb.psico-tests.index'
        );

    }

}