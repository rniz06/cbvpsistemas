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
                p.nombrecompleto,
                p.codigo,
                p.categoria,
                p.compania,
                se.created_at,
                se.deleted_at
            FROM CCA_servicios_existentes_comentarios se
            JOIN vt_personales p ON (p.idpersonal = se.creadoPor)
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
