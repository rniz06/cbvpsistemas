<?php

namespace App\Http\Controllers;

use App\Models\Vistas\VtPersonalContacto;
use App\Models\Vistas\VtPersonalContactoEmergencia;
use App\Models\Vistas\VtPersonales;
use App\Models\Vistas\VtResolucionPersonal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function verMiFicha()
    {
        $usuario = Auth::user();
        $personal = VtPersonales::findOrFail($usuario->personal_id);
        $personalContactos = VtPersonalContacto::select('personal_id', 'tipo_contacto', 'contacto')
            ->where('personal_id', $usuario->personal_id)->get();
        $personalContactosEmergencias = VtPersonalContactoEmergencia::select('personal_id', 'tipo_contacto', 'parentesco', 'ciudad', 'nombre_contacto', 'direccion', 'contacto')
            ->where('personal_id', $usuario->personal_id)->get();
        $resoluciones = VtResolucionPersonal::select('id_resolucion', 'n_resolucion', 'concepto', 'fecha', 'fuente_origen', 'id_personal')
            ->where('id_personal', $usuario->personal_id)
            ->orderBy('fecha', 'desc')
            ->paginate(5, ['*'], 'resoluciones_page');
        return view('mi_ficha', compact('personal', 'personalContactos', 'personalContactosEmergencias', 'resoluciones'));
    }
}
