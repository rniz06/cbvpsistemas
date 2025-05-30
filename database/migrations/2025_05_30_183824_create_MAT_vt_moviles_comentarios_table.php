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
            CREATE VIEW `MAT_vt_moviles_comentarios` AS
            SELECT
                mc.id_movil_comentario,
                mc.comentario,
                mc.movil_id,
                m.movil,
                m.tipo,
                mc.accion_id,
                a.accion,
                mc.creadoPor,
                u.nombrecompleto,
                mc.created_at,
                mc.updated_at,
                mc.deleted_at
            FROM MAT_moviles_comentarios mc
            JOIN MAT_vt_moviles m ON (m.id_movil = mc.movil_id)
            JOIN MAT_acciones a ON (a.id_accion = mc.accion_id)
            JOIN vt_usuarios u ON (u.id_usuario = mc.creadoPor)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `MAT_vt_moviles_comentarios`');
    }
};
