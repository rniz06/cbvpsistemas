<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalController extends Controller
{
    /**
     * Establece los middleware necesarios para gestionar permisos
     * Se utilizan permisos específicos para cada acción del controlador.
     */
    function __construct()
    {
        $this->middleware('permission:Personal Listar|Personal Crear|Personal Editar|Personal Eliminar', ['only' => ['index', 'show']]);
        $this->middleware('permission:Personal Crear', ['only' => ['create', 'store']]);
        $this->middleware('permission:Personal Editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Personal Eliminar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('personal.index');
    }

    /**
     * Genera y descarga un PDF con la ficha de un personal.
     */
    public function fichapdf($id)
    {
        $usuario = Auth::user();
        // Cargar todas las relaciones en una sola consulta
        $personal = Personal::with([
            'categoria',
            'estado',
            'sexo',
            'pais',
            'estadoActualizar',
            'grupoSanguineo',
            'contactos.tipoContacto',
            'contactosEmergencias.tipoContacto',
            'contactosEmergencias.parentesco',
            'contactosEmergencias.ciudad',
            'vtcompania'
        ])
            ->findOrFail($id);

        $pdf = Pdf::loadView('personal.fichapdf', [
            'personal' => $personal,
            'usuario' => $usuario,
            'contactos' => $personal->contactos,
            'contactosEmergencias' => $personal->contactosEmergencias
        ]);

        return $pdf->download('CBVP Ficha  de personal ' . $personal->codigo . '.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
