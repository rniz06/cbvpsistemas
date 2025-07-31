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
            CREATE VIEW `MAT_vt_hidraulicos` AS
            SELECT
                h.id_hidraulico,
                h.anho,
                h.operativo,
                h.marca_id,
                hm.marca,
                h.modelo_id,
                hmodel.modelo,
                h.motor_id,
                hmotor.motor,
                h.compania_id,
                c.compania,
                c.ciudad_id,
                ciu.departamento_id,
                h.operatividad_id,
                o.operatividad,
                h.creadoPor,
                u.nombrecompleto,
                h.created_at,
                h.updated_at,
                h.deleted_at
            FROM MAT_hidraulicos h
            JOIN MAT_hidraulicos_marcas hm ON (hm.id_hidraulico_marca = h.marca_id)
            JOIN MAT_hidraulicos_modelos hmodel ON (hmodel.id_hidraulico_modelo = h.modelo_id)
            JOIN MAT_hidraulicos_motor hmotor ON (hmotor.id_hidraulico_motor = h.motor_id)
            JOIN GRAL_companias c ON (c.id_compania = h.compania_id)
            JOIN MAT_operatividad o ON (o.id_operatividad = h.operatividad_id)
            JOIN vt_usuarios u ON (u.id_usuario = h.creadoPor)
            JOIN GRAL_ciudades ciu ON (c.ciudad_id = ciu.id_ciudad)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `MAT_vt_hidraulicos`');
    }
};
