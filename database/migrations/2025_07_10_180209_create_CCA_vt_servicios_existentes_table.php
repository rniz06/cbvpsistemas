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
            CREATE VIEW `CCA_vt_servicios_existentes` AS
            SELECT
                se.id_servicio_existente,
                se.informacion_servicio,
                se.calle_referencia,
                se.cantidad_tripulantes,
                se.compania_id,
                c.compania,
                se.servicio_id,
                s.servicio,
                se.clasificacion_id,
                cla.clasificacion,
                se.ciudad_id,
                ciu.ciudad,
                se.movil_id,
                m.movil,
                m.movil_tipo_id,
                mt.tipo,
                se.acargo,
                p.nombrecompleto AS acargo_nombrecompleto,
                p.codigo AS acargo_codigo,
                p.codigo_comisionamiento AS acargo_codigo_comisionamiento,
                p.categoria_id AS acargo_categoria_id,
                pc.categoria AS acargo_categoria,
                se.acargo_aux,
                se.chofer,
                p_chofer.nombrecompleto AS chofer_nombrecompleto,
                p_chofer.codigo AS chofer_codigo,
                p_chofer.categoria_id AS chofer_categoria_id,
                p_chofer_cat.categoria AS chofer_categoria,
                se.chofer_rentado,
                se.estado_id,
                sestados.estado,
                se.fecha_alfa,
                se.fecha_cia,
                se.fecha_movil,
                se.fecha_servicio,
                se.fecha_base,
                se.falsa_alarma,
                se.creadoPor,
                se.deleted_at
            FROM CCA_servicios_existentes se
            LEFT JOIN GRAL_companias c ON (c.id_compania = se.compania_id)
            LEFT JOIN CCA_servicios s ON (s.id_servicio = se.servicio_id)
            LEFT JOIN CCA_servicios_clasificaciones cla ON (cla.id_servicio_clasificacion = se.clasificacion_id)
            LEFT JOIN GRAL_ciudades ciu ON (ciu.id_ciudad = se.ciudad_id)
            LEFT JOIN MAT_moviles m ON (m.id_movil = se.movil_id)
            LEFT JOIN MAT_moviles_tipos mt ON (mt.id_movil_tipo = m.movil_tipo_id)
            LEFT JOIN personal p ON (p.idpersonal = se.acargo)
            LEFT JOIN personal_categorias pc ON (pc.idpersonal_categorias = p.categoria_id)
            LEFT JOIN personal p_chofer ON (p_chofer.idpersonal = se.chofer)
            LEFT JOIN personal_categorias p_chofer_cat ON (p_chofer_cat.idpersonal_categorias = p_chofer.categoria_id)
            LEFT JOIN CCA_servicios_estados sestados ON (sestados.id_servicio_estado = se.estado_id)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS CCA_vt_servicios_existentes");
    }
};
