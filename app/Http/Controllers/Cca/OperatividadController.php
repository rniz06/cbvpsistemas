<?php

namespace App\Http\Controllers\Cca;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OperatividadController extends Controller
{
    /**
     * Establece los middleware necesarios para gestionar permisos
     * Se utilizan permisos específicos para cada acción del controlador.
     */
    function __construct()
    {
        $this->middleware('permission:Despacho Por Compania', ['only' => ['index']]);
        $this->middleware('permission:Despacho Por Compania', ['only' => ['dashboard']]);
    }

    public function index()
    {
        return view('cca.operatividad.index');
    }

    public function dashboard()
    {
        return view('cca.operatividad.dashboard-operatividad');
    }
}
