<?php

namespace App\Http\Controllers\ANB\ECB;

class PsicoBaremoController
{
    public function index($test)
    {
        return view(
            'anb.ecb.psico-baremos.index',
            compact('test')
        );
    }
}