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
            CREATE VIEW `PER_vt_cargos` AS
            SELECT
                c.id_cargo,
                c.cargo,
                c.rango_id,
                r.rango,
                c.creadoPor,
                uc.nombrecompleto AS creadorPor_nombrecompleto,
                uc.codigo AS creadorPor_codigo,
                c.actualizadoPor,
                ua.nombrecompleto AS actualizadoPor_nombrecompleto,
                ua.codigo AS actualizadoPor_codigo,
                c.created_at,
                c.updated_at,
                c.deleted_at
            FROM PER_cargos c
            JOIN PER_rangos r ON (r.id_rango = c.rango_id)
            LEFT JOIN vt_usuarios uc ON (uc.id_usuario = c.creadoPor)
            LEFT JOIN vt_usuarios ua ON (ua.id_usuario = c.actualizadoPor)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS PER_vt_cargos");
    }
};
