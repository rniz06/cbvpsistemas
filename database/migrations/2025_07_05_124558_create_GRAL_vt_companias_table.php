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
            CREATE  OR REPLACE VIEW personalcbvp.GRAL_vt_companias AS
            SELECT 
                c.id_compania,
                c.compania,
                c.ciudad_id,
                ciu.ciudad,
                ciu.departamento_id,
                d.departamento,
                c.region_id,
                r.region,
                c.orden,
                c.deleted_at
            FROM GRAL_companias c
            JOIN GRAL_ciudades ciu ON (ciu.id_ciudad = c.ciudad_id)
            JOIN GRAL_departamentos d ON (d.id_departamento = ciu.departamento_id)
            JOIN GRAL_regiones r ON (r.id_region = c.region_id);
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `GRAL_vt_companias`');
    }
};
