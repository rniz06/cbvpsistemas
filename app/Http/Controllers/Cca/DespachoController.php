<?php

namespace App\Http\Controllers\Cca;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DespachoController extends Controller
{
    public function despachoPorCompania()
    {
        return view('cca.despacho.despacho-por-compania');
    }

    public function despachoPorCompaniaFinal($compania)
    {
        return view('cca.despacho.despacho-por-compania-final', compact('compania'));
    }
}
