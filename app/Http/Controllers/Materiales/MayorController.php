<?php

namespace App\Http\Controllers\Materiales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MayorController extends Controller
{
    /**
     * Establece los middleware necesarios para gestionar permisos
     * Se utilizan permisos específicos para cada acción del controlador.
     */
    function __construct()
    {
        $this->middleware('permission:Material Mayor Listar', ['only' => ['index']]);
        $this->middleware('permission:Material Mayor Ver', ['only' => ['show', 'verCompania']]);
    }

    public function index()
    {
        return view('materiales.mayor.index');
    }

    public function show($movil)
    {
        return view('materiales.mayor.ficha', compact('movil'));
    }

    public function verCompania($compania)
    {
        return view('materiales.mayor.ver-compania', compact('compania'));
    }
}
