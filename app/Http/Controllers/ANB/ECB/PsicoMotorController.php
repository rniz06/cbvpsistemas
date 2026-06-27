<?php

namespace App\Http\Controllers\ANB\ECB;

class PsicoMotorController
{
    public function index($test)
    {
        return view(
            'anb.ecb.psico-motor.index',
            compact('test')
        );
    }
}