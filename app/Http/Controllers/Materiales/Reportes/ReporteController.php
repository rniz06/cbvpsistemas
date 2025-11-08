<?php

namespace App\Http\Controllers\Materiales\Reportes;

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
        $this->middleware('permission:Materiales Reportes Index', ['only' => ['index']]);
    }

    public function index()
    {
        return view('materiales.reportes.index');
    }
}
