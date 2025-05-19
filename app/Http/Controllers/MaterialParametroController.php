<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaterialParametroController extends Controller
{
    public function index()
    {
        return view('materiales.parametros.index');    
    }

    public function transmision()
    {
        return view('materiales.mayor.transmision');    
    }

    public function ejes()
    {
        return view('materiales.mayor.ejes');    
    }
}
