<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW `CCA_vt_servicios_existentes_apoyos` AS
            SELECT
                sea.cantidad_tripulantes,
                sea.servicio_id,
                s.servicio,
                sea.compania_id,
                c.compania,
                sea.movil_id,
                m.movil,
                m.movil_tipo_id,
                mt.tipo,
                sea.acargo,
                p.nombrecompleto,
                sea.chofer,
                sea.fecha_cia,
                sea.fecha_movil,
                sea.fecha_servicio,
                sea.fecha_base,
                sea.creadoPor,
                sea.deleted_at
            FROM CCA_servicios_existentes_apoyos sea
            JOIN CCA_servicios s ON (s.id_servicio = sea.servicio_id)
            JOIN GRAL_companias c ON (c.id_compania = sea.compania_id)
            JOIN MAT_moviles m ON (m.id_movil = sea.movil_id)
            JOIN MAT_moviles_tipos mt ON (mt.id_movil_tipo = m.movil_tipo_id)
            JOIN personal p ON (p.idpersonal = sea.acargo)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS CCA_vt_servicios_existentes_apoyos");
    }
};
