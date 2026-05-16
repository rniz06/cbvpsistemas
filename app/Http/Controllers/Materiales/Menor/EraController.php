<?php

namespace App\Http\Controllers\Materiales\Menor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EraController extends Controller
{
    /**
     * Establece los middleware necesarios para gestionar permisos
     * Se utilizan permisos específicos para cada acción del controlador.
     */
    function __construct()
    {
        $this->middleware('permission:Material Menor Listar', ['only' => ['index']]);
    }

    public function index()
    {
        return view('materiales.menor.eras.index');
    }
}
