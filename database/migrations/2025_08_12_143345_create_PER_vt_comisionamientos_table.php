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
            CREATE VIEW `PER_vt_comisionamientos` AS
            SELECT
                c.id_comisionamiento,
                c.fecha_inicio,
                c.fecha_fin,
                c.tipo_id,
                t.tipo,
                c.codigo_comisionamiento,
                c.personal_id,
                p.nombrecompleto,
                p.codigo,
                c.inicio_resolucion_id,
                r.n_resolucion AS inicio_n_resolucion,
                r.concepto AS inicio_concepto,
                c.fin_resolucion_id,
                finr.n_resolucion AS fin_n_resolucion,
                finr.concepto AS fin_concepto,
                c.cargo_id,
                car.cargo,
                car.codigo_cargo,
                car.rango_id,
                ran.rango,
                c.compania_id,
                com.compania,
                c.direccion_id,
                d.direccion,
                c.culminado,
                c.creadoPor,
                uc.nombrecompleto AS creadorPor_nombrecompleto,
                uc.codigo AS creadorPor_codigo,
                c.actualizadoPor,
                ua.nombrecompleto AS actualizadoPor_nombrecompleto,
                ua.codigo AS actualizadoPor_codigo,
                c.created_at,
                c.updated_at,
                c.deleted_at
            FROM PER_comisionamientos c
            JOIN PER_comisionamientos_tipos t ON (t.id_comisionamiento_tipo =  c.tipo_id)
            JOIN personal p ON (p.idpersonal = c.personal_id)
            LEFT JOIN cbvp_resoluciones_db.resoluciones r ON (r.id = c.inicio_resolucion_id)
            LEFT JOIN cbvp_resoluciones_db.resoluciones finr ON (finr.id = c.fin_resolucion_id)
            LEFT JOIN PER_cargos car ON (car.id_cargo = c.cargo_id)
            LEFT JOIN PER_rangos ran ON (ran.id_rango = car.rango_id)
            LEFT JOIN GRAL_companias com ON (com.id_compania = c.compania_id)
            LEFT JOIN GRAL_direcciones d ON (d.id_direccion = c.direccion_id)
            LEFT JOIN vt_usuarios uc ON (uc.id_usuario = c.creadoPor)
            LEFT JOIN vt_usuarios ua ON (ua.id_usuario = c.actualizadoPor)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS PER_vt_comisionamientos");
    }
};
