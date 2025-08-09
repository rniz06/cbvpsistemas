<?php

namespace App\Livewire\Perfil;

use App\Models\Vistas\Cca\VtExistente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MisServicios extends Component
{
    public function obtenerDatos()
    {
        $usuario = Auth::user()->personal_id;

        return DB::select("
        SELECT 
            servicio,
            SUM(cantidad_acargo) AS cantidad_acargo,
            SUM(cantidad_chofer) AS cantidad_chofer,
            SUM(cantidad_acargo + cantidad_chofer) AS total_general
        FROM (
            SELECT 
                servicio,
                SUM(CASE WHEN acargo = :usuario1 THEN 1 ELSE 0 END) AS cantidad_acargo,
                SUM(CASE WHEN chofer = :usuario2 THEN 1 ELSE 0 END) AS cantidad_chofer
            FROM personalcbvp.CCA_vt_servicios_existentes
            WHERE acargo = :usuario3 OR chofer = :usuario4
            GROUP BY servicio

            UNION ALL

            SELECT 
                servicio,
                SUM(CASE WHEN acargo = :usuario5 THEN 1 ELSE 0 END) AS cantidad_acargo,
                SUM(CASE WHEN chofer = :usuario6 THEN 1 ELSE 0 END) AS cantidad_chofer
            FROM personalcbvp.CCA_vt_servicios_existentes_apoyos
            WHERE acargo = :usuario7 OR chofer = :usuario8
            GROUP BY servicio
        ) AS datos_unidos
        GROUP BY servicio
        ORDER BY servicio
    ", [
            'usuario1' => $usuario,
            'usuario2' => $usuario,
            'usuario3' => $usuario,
            'usuario4' => $usuario,
            'usuario5' => $usuario,
            'usuario6' => $usuario,
            'usuario7' => $usuario,
            'usuario8' => $usuario,
        ]);
    }


    public function render()
    {
        return view('livewire.perfil.mis-servicios', [
            'servicios' => $this->obtenerDatos(),
        ]);
    }
}
