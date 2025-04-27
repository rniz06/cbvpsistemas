<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Models\MesaPersonal;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mesas = Mesa::select('id_mesa', 'mesa', 'votos', 'estado')->get();
        return view('mesas.index', compact('mesas'));
    }

    public function asignarpersonalmesa()
    {
        $mesas = Mesa::select('id_mesa', 'mesa', 'votos', 'estado')->get();
        return view('mesas.asignarpersonalmesa', compact('mesas'));
    }
    public function asignarpersonalmesapost(Request $request)
    {
        MesaPersonal::create([
            'mesa_id' => $request->mesa_id,
            'personal_id' => $request->personal_id,
        ]);

        return redirect()->route('mesas.asignarpersonalmesa')
            ->with('success', 'Personal asignado a la mesa correctamente.');
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
    public function show(Mesa $mesa)
    {
        return view('mesas.show', compact('mesa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mesa $mesa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mesa $mesa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mesa $mesa)
    {
        //
    }
}
