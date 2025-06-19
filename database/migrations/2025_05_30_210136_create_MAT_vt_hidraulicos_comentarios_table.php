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
                h.marca_id,
                hm.marca,
                h.compania_id,
                c.compania,
                hc.accion_id,
                a.accion,
                hc.creadoPor,
                u.nombrecompleto,
                hc.created_at,
                hc.updated_at,
                hc.deleted_at
            FROM personalcbvp.MAT_hidraulicos_comentarios hc
            JOIN personalcbvp.MAT_hidraulicos h ON h.id_hidraulico = hc.hidraulico_id
            JOIN personalcbvp.MAT_acciones a ON a.id_accion = hc.accion_id
            JOIN personalcbvp.vt_usuarios u ON u.id_usuario = hc.creadoPor
            JOIN personalcbvp.MAT_hidraulicos_marcas hm ON hm.id_hidraulico_marca = h.marca_id
            JOIN emepy_bd.companias c ON c.idcompanias = h.compania_id;
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
