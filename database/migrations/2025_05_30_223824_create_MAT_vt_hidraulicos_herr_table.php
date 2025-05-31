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
            CREATE VIEW `MAT_vt_hidraulicos_herr` AS
            SELECT
                hh.id_hidraulico_herr,
                hh.serie,
                hh.operativo,
                hh.hidraulico_id,
                hh.marca_id,
                hhm.marca,
                hh.modelo_id,
                hhmodel.modelo,
                hh.motor_id,
                hhmotor.motor,
                hh.tipo_id,
                hhtipo.tipo,
                hh.operatividad_id,
                o.operatividad,
                hh.creadoPor,
                u.nombrecompleto,
                hh.created_at,
                hh.updated_at,
                hh.deleted_at
            FROM MAT_hidraulicos_herr hh
            JOIN MAT_hidraulicos h ON (h.id_hidraulico = hh.hidraulico_id)
            JOIN MAT_hidraulicos_herr_marcas hhm ON (hhm.idhidraulico_herr_marca = hh.marca_id)
            JOIN MAT_hidraulicos_herr_modelos hhmodel ON (hhmodel.idhidraulico_herr_modelo = hh.modelo_id)
            JOIN MAT_hidraulicos_herr_motor hhmotor ON (hhmotor.idhidraulico_herr_motor = hh.motor_id)
            JOIN MAT_hidraulicos_herr_tipos hhtipo ON (hhtipo.idhidraulico_herr_tipo = hh.tipo_id)
            JOIN MAT_operatividad o ON (o.id_operatividad = hh.operatividad_id)
            JOIN vt_usuarios u ON (u.id_usuario = hh.creadoPor)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `MAT_vt_hidraulicos_herr`');
    }
};
