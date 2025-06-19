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
            CREATE VIEW `MAT_vt_hidraulicos_herr_comentarios` AS
            SELECT
                hhc.idhidraulico_herr_comentario,
                hhc.comentario,
                hhc.herramienta_id,
                hhc.accion_id,
                a.accion,
                hhc.creadoPor,
                u.nombrecompleto,
                hhc.created_at,
                hhc.updated_at,
                hhc.deleted_at
            FROM MAT_hidraulicos_herr_comentarios hhc
            JOIN MAT_hidraulicos_herr hh ON (hh.id_hidraulico_herr = hhc.herramienta_id)
            JOIN MAT_acciones a ON (a.id_accion = hhc.accion_id)
            LEFT JOIN vt_usuarios u ON (u.id_usuario = hhc.creadoPor)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `MAT_vt_hidraulicos_herr_comentarios`');
    }
};
