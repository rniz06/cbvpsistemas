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
            CREATE VIEW `CCA_vt_servicios_existentes_apoyos` AS
            SELECT
                sea.idservicio_existente_apoyo,
                sea.cantidad_tripulantes,
                sea.servicio_id AS servicio_existente_id,
                se.clasificacion_id,
                cla.clasificacion,
                se.servicio_id,
                s.servicio,
                sea.compania_id,
                c.compania,
                sea.movil_id,
                m.movil,
                m.movil_tipo_id,
                mt.tipo,
                sea.acargo,
                p.nombrecompleto AS acargo_nombrecompleto,
                p.codigo AS acargo_codigo,
                p.categoria_id AS acargo_categoria_id,
                pc.categoria AS acargo_categoria,
                sea.acargo_aux,
                p_acargo_aux.codigo_comisionamiento,
                sea.chofer,
                p_chofer.nombrecompleto AS chofer_nombrecompleto,
                p_chofer.codigo AS chofer_codigo,
                p_chofer.categoria_id AS chofer_categoria_id,
                p_chofer_cat.categoria AS chofer_categoria,
                sea.chofer_rentado,
                sea.fecha_cia,
                sea.fecha_movil,
                sea.fecha_servicio,
                sea.fecha_base,
                sea.creadoPor,
                sea.created_at,
                sea.deleted_at
            FROM CCA_servicios_existentes_apoyos sea
            JOIN CCA_servicios_existentes se ON (se.id_servicio_existente = sea.servicio_id)
            JOIN CCA_servicios s ON (s.id_servicio = se.servicio_id)
            JOIN CCA_servicios_clasificaciones cla ON (cla.id_servicio_clasificacion = se.clasificacion_id)
            JOIN GRAL_companias c ON (c.id_compania = sea.compania_id)
            JOIN MAT_moviles m ON (m.id_movil = sea.movil_id)
            JOIN MAT_moviles_tipos mt ON (mt.id_movil_tipo = m.movil_tipo_id)
            LEFT JOIN personal p ON (p.idpersonal = sea.acargo)
            LEFT JOIN personal_categorias pc ON (pc.idpersonal_categorias = p.categoria_id)
            LEFT JOIN personal p_chofer ON (p_chofer.idpersonal = sea.chofer)
            LEFT JOIN personal_categorias p_chofer_cat ON (p_chofer_cat.idpersonal_categorias = p_chofer.categoria_id)
            LEFT JOIN personal p_acargo_aux ON (p_acargo_aux.idpersonal = sea.acargo_aux)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS CCA_vt_servicios_existentes_apoyos");
    }
};
