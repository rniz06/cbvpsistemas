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
                m.movil_tipo_id,
                mt.tipo AS tipo,
                mc.accion_id,
                a.accion,
		        mc.accion_categoria_id,
        	    ac.categoria AS accion_categoria,
        	    mc.categoria_detalle_id,
        	    acd.detalle AS categoria_detalle,
                mc.creadoPor,
                u.nombrecompleto,
                mc.created_at,
                mc.updated_at,
                mc.deleted_at
            FROM personalcbvp.MAT_moviles_comentarios mc
            JOIN personalcbvp.MAT_moviles m ON m.id_movil = mc.movil_id
            JOIN personalcbvp.MAT_moviles_tipos mt ON mt.id_movil_tipo = m.movil_tipo_id
            JOIN personalcbvp.MAT_acciones a ON a.id_accion = mc.accion_id
            JOIN personalcbvp.vt_usuarios u ON u.id_usuario = mc.creadoPor
	    LEFT JOIN personalcbvp.MAT_acciones_categorias ac ON ac.id_accion_categoria = mc.accion_categoria_id
	    LEFT JOIN personalcbvp.MAT_acciones_categorias_detalles acd ON acd.idaccion_categoria_detalle = mc.categoria_detalle_id;
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
