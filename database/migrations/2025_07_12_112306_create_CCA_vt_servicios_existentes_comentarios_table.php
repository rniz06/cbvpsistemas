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
            CREATE VIEW `CCA_vt_servicios_existentes_comentarios` AS
            SELECT
                se.idservicio_existente_comentario,
                se.comentario,
                se.servicio_id,
                se.creadoPor,
                u.nombrecompleto,
                u.codigo,
                u.categoria,
                u.compania,
                se.created_at,
                se.deleted_at
            FROM CCA_servicios_existentes_comentarios se
            JOIN vt_usuarios u ON (u.id_usuario = se.creadoPor)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS CCA_vt_servicios_existentes_comentarios");
    }
};
