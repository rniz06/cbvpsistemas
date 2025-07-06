<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompaniaController extends Controller
{
    /**
     * Establece los middleware necesarios para gestionar permisos
     * Se utilizan permisos específicos para cada acción del controlador.
     */
    function __construct()
    {
        $this->middleware('permission:Personal Listar', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.companias.index');
    }
}
