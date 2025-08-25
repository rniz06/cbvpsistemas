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
            CREATE VIEW `GRAL_vt_direcciones` AS
            SELECT
                d.id_direccion,
                d.direccion,
                d.compania_id,
                c.compania,
                d.creadoPor,
                uc.nombrecompleto AS creadorPor_nombrecompleto,
                uc.codigo AS creadorPor_codigo,
                d.actualizadoPor,
                ua.nombrecompleto AS actualizadoPor_nombrecompleto,
                ua.codigo AS actualizadoPor_codigo,
                d.created_at,
                d.updated_at,
                d.deleted_at
            FROM GRAL_direcciones d
            JOIN GRAL_companias c ON (c.id_compania = d.compania_id)
            LEFT JOIN vt_usuarios uc ON (uc.id_usuario = d.creadoPor)
            LEFT JOIN vt_usuarios ua ON (ua.id_usuario = d.actualizadoPor)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS GRAL_vt_direcciones");
    }
};
