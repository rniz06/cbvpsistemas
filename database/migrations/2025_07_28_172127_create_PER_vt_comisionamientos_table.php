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
            CREATE VIEW `PER_vt_comisionamientos` AS
            SELECT
                c.id_comisionamiento,
                c.personal_id,
                p.nombrecompleto,
                p.codigo,
                c.compania_id,
                com.compania,
                c.resolucion_id,
                r.n_resolucion,
                r.concepto,
                c.fecha_inicio,
                c.fecha_fin,
                c.codigo_comisionamiento,
                c.culminado,
                c.created_at,
                c.updated_at,
                c.deleted_at
            FROM PER_comisionamientos c
            JOIN personal p ON (p.idpersonal = personal_id)
            JOIN GRAL_companias com ON (com.id_compania = c.compania_id)
            LEFT JOIN cbvp_resoluciones_db.resoluciones r ON (r.id = c.resolucion_id)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS PER_vt_comisionamientos");
    }
};
