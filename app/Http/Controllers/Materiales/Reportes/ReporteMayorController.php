<?php

namespace App\Http\Controllers\Materiales\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReporteMayorController extends Controller
{
    /**
     * Establece los middleware necesarios para gestionar permisos
     * Se utilizan permisos específicos para cada acción del controlador.
     */
    function __construct()
    {
        $this->middleware('permission:Materiales Reportes Mayor General', ['only' => ['mayorgeneral']]);
        $this->middleware('permission:Materiales Reportes Mayor Inoperativos', ['only' => ['mayorinoperativos']]);
    }

    public function mayorgeneral()
    {
        return view('materiales.mayor.reportes.general');
    }

    public function mayorinoperativos()
    {
        return view('materiales.mayor.reportes.inoperativos');
    }
}
