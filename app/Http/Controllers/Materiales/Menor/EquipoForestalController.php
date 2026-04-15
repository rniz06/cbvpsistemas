<?php

namespace App\Http\Controllers\Materiales\Menor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EquipoForestalController extends Controller
{
    /**
     * Establece los middleware necesarios para gestionar permisos
     * Se utilizan permisos específicos para cada acción del controlador.
     */
    function __construct()
    {
        $this->middleware('permission:Material Menor Listar', ['only' => ['index']]);
        $this->middleware('permission:Material Menor Ver', ['only' => ['verFicha']]);
        $this->middleware('permission:Material Menor Ver Compania', ['only' => ['verCompania']]);
    }

    public function index()
    {
        return view('materiales.menor.forestales.index');
    }

    public function verCompania($compania)
    {
        return view('materiales.menor.forestales.ver-compania', compact('compania'));
    }

    public function verFicha($item)
    {
        return view('materiales.menor.forestales.ver-ficha', compact('item'));
    }
}
