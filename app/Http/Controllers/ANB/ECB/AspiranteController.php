<?php

namespace App\Http\Controllers\ANB\ECB;

use App\Http\Controllers\Controller;
use App\Models\ANB\ECB\Aspirante;

class AspiranteController extends Controller
{
    public function index()
    {
        return view('anb.ecb.aspirantes.index');
    }
    
    public function show(Aspirante $aspirante)
    {
        return view(
            'anb.ecb.aspirantes.show',
            compact('aspirante')
        );
    }

}