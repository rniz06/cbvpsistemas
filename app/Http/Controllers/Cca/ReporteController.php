<?php

namespace App\Http\Controllers\Cca;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function historico()
    {
        return view('cca.reportes.historico');
    }

    public function graficosPorCompania()
    {
        return view('cca.reportes.graficos-por-compania');
    }
}
