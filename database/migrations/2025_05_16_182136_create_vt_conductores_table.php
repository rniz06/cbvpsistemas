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
            CREATE VIEW vt_conductores AS
                SELECT
                    conductores_bomberos.id_conductor_bombero,
                    conductores_bomberos.personal_id,
                    conductores_bomberos.estado_id,
                    conductores_bomberos.ciudad_curso_id,
                    conductores_bomberos.ciudad_licencia_id,
                    conductores_bomberos.tipo_vehiculo_id,
                    conductores_bomberos.clase_licencia_id,
                    conductores_bomberos.resolucion,
                    conductores_bomberos.resolucion_enlace,
                    conductores_bomberos.fecha_curso,
                    conductores_bomberos.numero_licencia,
                    conductores_bomberos.created_at,
                    conductores_bomberos.deleted_at,
                    vt_personales.nombrecompleto,
                    vt_personales.codigo,
                    vt_personales.categoria,
                    vt_personales.compania,
                    conductores_estados.estado,
                    ciudades_curso.ciudad AS ciudad_curso,
                    ciudades_licencia.ciudad AS ciudad_licencia,
                    conductores_tipo_vehiculo.tipo AS tipo_vehiculo,
                    conductores_clase_licencias.clase AS clase_licencia
                FROM conductores_bomberos
                JOIN vt_personales ON (vt_personales.idpersonal = conductores_bomberos.personal_id)
                JOIN conductores_estados ON (conductores_estados.id_conductor_estado = conductores_bomberos.estado_id)
                JOIN emepy_bd.ciudades AS ciudades_curso ON (ciudades_curso.idciudades = conductores_bomberos.ciudad_curso_id)
                JOIN emepy_bd.ciudades AS ciudades_licencia ON (ciudades_licencia.idciudades = conductores_bomberos.ciudad_licencia_id)
                JOIN conductores_tipo_vehiculo ON (conductores_tipo_vehiculo.idconductor_tipo_vehiculo = conductores_bomberos.tipo_vehiculo_id)
                JOIN conductores_clase_licencias ON (conductores_clase_licencias.idconductor_clase_licencia = conductores_bomberos.clase_licencia_id)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `vt_conductores`');
    }
};
