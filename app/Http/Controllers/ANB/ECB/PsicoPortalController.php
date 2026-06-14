<?php

namespace App\Http\Controllers\ANB\ECB;

use App\Http\Controllers\Controller;

class PsicoPortalController extends Controller
{

    public function index()
    {

        return view(
            'anb.ecb.psico-portal.index'
        );

    }

}