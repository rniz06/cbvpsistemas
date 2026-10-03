<?php

namespace App\Http\Controllers\ANB\ECB;

use App\Http\Controllers\Controller;

class LlamadoController extends Controller
{
    public function index()
    {
        return view('anb.ecb.llamados.index');
    }
}