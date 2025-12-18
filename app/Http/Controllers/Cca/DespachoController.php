<?php

namespace App\Http\Controllers\Cca;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DespachoController extends Controller
{
    /**
     * Establece los middleware necesarios para gestionar permisos
     * Se utilizan permisos específicos para cada acción del controlador.
     */
    function __construct()
    {
        $this->middleware('permission:Despacho Por Compania', ['only' => ['despachoPorCompania', 'despachoPorCompaniaFinal']]);
        $this->middleware('permission:Despacho Por Servicio', ['only' => ['despachoPorServicio', 'despachoPorServicioAddCompania', 'despachoPorServicioFinal']]);
        $this->middleware('permission:Servicios Activos', ['only' => ['serviciosActivos']]);
        $this->middleware('permission:Servicios Activos 911', ['only' => ['serviciosActivos911']]);
        $this->middleware('permission:Apoyos Activos', ['only' => ['apoyosActivos']]);
        $this->middleware('permission:Despacho Por Compania|Despacho Por Servicio|Servicios Activos', ['only' => ['verServicio']]);
    }

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
        return view('cca.despacho.despacho-por-servicio-add-compania', compact('servicio'));
    }

    public function despachoPorServicioFinal($servicio)
    {
        return view('cca.despacho.despacho-por-servicio-final', compact('servicio'));
    }

    public function serviciosActivos()
    {
        return view('cca.despacho.servicios-activos');
    }

    public function serviciosActivos911()
    {
        return view('cca.despacho.servicios-activos-911');
    }

    public function apoyosActivos()
    {
        return view('cca.despacho.apoyos-activos');
    }
}
