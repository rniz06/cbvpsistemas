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
            CREATE VIEW MAT_vt_conductores AS
                SELECT
                    MAT_conductores_bomberos.id_conductor_bombero,
                    MAT_conductores_bomberos.personal_id,
                    MAT_conductores_bomberos.estado_id,
                    MAT_conductores_bomberos.ciudad_curso_id,
                    MAT_conductores_bomberos.ciudad_licencia_id,
                    MAT_conductores_bomberos.tipo_vehiculo_id,
                    MAT_conductores_bomberos.clase_licencia_id,
                    MAT_conductores_bomberos.resolucion,
                    MAT_conductores_bomberos.resolucion_enlace,
                    MAT_conductores_bomberos.fecha_curso,
                    MAT_conductores_bomberos.numero_licencia,
                    MAT_conductores_bomberos.created_at,
                    MAT_conductores_bomberos.deleted_at,
                    vt_personales.nombrecompleto,
                    vt_personales.codigo,
                    vt_personales.categoria,
                    vt_personales.compania,
                    MAT_conductores_estados.estado,
                    ciudades_curso.ciudad AS ciudad_curso,
                    ciudades_licencia.ciudad AS ciudad_licencia,
                    MAT_conductores_tipo_vehiculo.tipo AS tipo_vehiculo,
                    MAT_conductores_clase_licencias.clase AS clase_licencia
                FROM MAT_conductores_bomberos
                JOIN vt_personales ON (vt_personales.idpersonal = MAT_conductores_bomberos.personal_id)
                JOIN MAT_conductores_estados ON (MAT_conductores_estados.id_conductor_estado = MAT_conductores_bomberos.estado_id)
                JOIN emepy_bd.ciudades AS ciudades_curso ON (ciudades_curso.idciudades = MAT_conductores_bomberos.ciudad_curso_id)
                JOIN emepy_bd.ciudades AS ciudades_licencia ON (ciudades_licencia.idciudades = MAT_conductores_bomberos.ciudad_licencia_id)
                JOIN MAT_conductores_tipo_vehiculo ON (MAT_conductores_tipo_vehiculo.idconductor_tipo_vehiculo = MAT_conductores_bomberos.tipo_vehiculo_id)
                JOIN MAT_conductores_clase_licencias ON (MAT_conductores_clase_licencias.idconductor_clase_licencia = MAT_conductores_bomberos.clase_licencia_id)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS `MAT_vt_conductores`');
    }
};
