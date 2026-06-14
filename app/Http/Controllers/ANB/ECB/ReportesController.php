<?php

namespace App\Http\Controllers\ANB\ECB;

use App\Http\Controllers\Controller;

class ReportesController extends Controller
{
    public function index()
    {
        return view('anb.ecb.reportes.index');
    }

    public function aspirantesMedicos()
    {
        return view('anb.ecb.reportes.aspirantes-medicos');
    }

    public function examenesFisicos()
    {
        return view('anb.ecb.reportes.examenes-fisicos');
    }

    public function psicologicos()
    {
        return view('anb.ecb.reportes.psicologicos');
    }
}