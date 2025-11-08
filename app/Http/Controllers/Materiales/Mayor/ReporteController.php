<?php

namespace App\Http\Controllers\Materiales\Mayor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    /**
     * Establece los middleware necesarios para gestionar permisos
     * Se utilizan permisos específicos para cada acción del controlador.
     */
    function __construct()
    {
        $this->middleware('permission:Mayor Reportes Listar', ['only' => ['index']]);
        $this->middleware('permission:Mayor Reportes General', ['only' => ['general']]);
        $this->middleware('permission:Mayor Reportes Inoperativos', ['only' => ['inoperativos']]);
    }

    public function index()
    {
        return view('materiales.mayor.reportes.index');
    }

    public function general()
    {
        return view('materiales.mayor.reportes.general');
    }

    public function inoperativos()
    {
        return view('materiales.mayor.reportes.inoperativos');
    }
}
