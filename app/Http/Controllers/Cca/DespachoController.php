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

    public function verServicio($servicio)
    {
        return view('cca.despacho.ver-servicio', compact('servicio'));
    }

    // Metodos de despacho por servicio

    public function despachoPorServicio()
    {
        return view('cca.despacho.despacho-por-servicio');
    }

    public function despachoPorServicioAddCompania($servicio)
    {
        return view('cca.despacho.despacho-por-compania-final', compact('servicio'));
    }

    public function despachoPorServicioFinal($servicio, $compania)
    {
        return view('cca.despacho.despacho-por-compania-final', compact('servicio', 'compania'));
    }
}
