<?php

namespace App\Http\Controllers\Cca;

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
        $this->middleware('permission:Reportes Historico', ['only' => ['historico']]);
        $this->middleware('permission:Reportes Por Compania', ['only' => ['graficosPorCompania']]);
    }

    public function historico()
    {
        return view('cca.reportes.historico');
    }

    public function graficosPorCompania()
    {
        return view('cca.reportes.graficos-por-compania');
    }
}
