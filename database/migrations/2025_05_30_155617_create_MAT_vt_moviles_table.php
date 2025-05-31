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
            CREATE VIEW `MAT_vt_moviles` AS
            SELECT
                m.id_movil,
                m.movil,
                m.chasis,
                m.detalles,
                m.operativo,
                m.anho,
                m.cubiertas_frente,
                m.cubiertas_atras,
                m.chapa,
                m.movil_tipo_id,
                mt.tipo,
                mt.descripcion AS tipo_descripcion,
                m.marca_id,
                mc.marca,
                m.modelo_id,
                mm.modelo,
                m.transmision_id,
                mtrans.transmision,
                m.eje_id,
                me.eje,
                m.combustible_id,
                mcombu.tipo AS combustible,
                m.operatividad_id,
                o.operatividad,
                m.compania_id,
                c.compania,
                c.ciudad_id,
                ciu.departamento_id,
                m.creadoPor,
                m.actualizadoPor,
                m.created_at,
                m.updated_at,
                m.deleted_at
            FROM MAT_moviles m
            JOIN MAT_moviles_tipos mt ON (mt.id_movil_tipo = m.movil_tipo_id)
            JOIN MAT_moviles_marcas mc ON (mc.id_movil_marca = m.marca_id)
            JOIN MAT_moviles_modelos mm ON (mm.id_movil_modelo = m.modelo_id)
            JOIN MAT_moviles_transmision mtrans ON (mtrans.id_movil_transmision = m.transmision_id)
            JOIN MAT_moviles_ejes me ON (me.id_movil_eje = m.eje_id)
            JOIN MAT_moviles_combustibles mcombu ON (mcombu.id_movil_combustible = m.combustible_id)
            JOIN MAT_operatividad o ON (o.id_operatividad = m.operatividad_id)
            JOIN emepy_bd.companias c ON (c.idcompanias = m.compania_id)
            JOIN emepy_bd.ciudades ciu ON (c.ciudad_id = ciu.idciudades)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `MAT_vt_moviles`');
    }
};
