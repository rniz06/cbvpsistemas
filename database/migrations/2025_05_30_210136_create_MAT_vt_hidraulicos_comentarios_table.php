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
            CREATE VIEW `MAT_vt_hidraulicos_comentarios` AS
            SELECT
                hc.id_hidraulico_comentario,
                hc.comentario,
                hc.hidraulico_id,
                hc.accion_id,
                a.accion,
                hc.creadoPor,
                u.nombrecompleto,
                hc.created_at,
                hc.updated_at,
                hc.deleted_at
            FROM MAT_hidraulicos_comentarios hc
            JOIN MAT_hidraulicos h ON (h.id_hidraulico = hc.hidraulico_id)
            JOIN MAT_acciones a ON (a.id_accion = hc.accion_id)
            JOIN vt_usuarios u ON (u.id_usuario = hc.creadoPor)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `MAT_vt_hidraulicos_comentarios`');
    }
};
