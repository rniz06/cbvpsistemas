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
        /**
         * NOTA IMPORTANTE:
         * Al ejecutar esta migración en un entorno local, se ha observado que el valor de la columna `model_type` en la tabla
         * `model_has_roles` no se mantiene como 'App\\Models\\User'. En su lugar, se guarda incorrectamente como 'AppModelsUser' 
         * (sin las barras invertidas), lo que causa que la vista SQL no relacione correctamente los roles con los usuarios.
         * 
         * Esto provoca que, al consultar la vista `vt_usuarios_con_roles`, no se muestren los roles asociados a los usuarios,
         * lo que impacta directamente en el funcionamiento del front-end.
         * 
         * SOLUCIÓN TEMPORAL:
         * Se recomienda revisar y, si es necesario, corregir manualmente el valor de `model_type` en la base de datos local,
         * asegurándose de que sea 'App\\Models\\User' para que la vista funcione como se espera.
         * 
         */
        DB::statement("
                CREATE VIEW `vt_usuarios_con_roles` AS
                SELECT
                    u.id_usuario,
                    u.personal_id,
                    u.name AS usuario_nombre,
                    u.email,
                    u.deleted_at,
                    u.ultimo_acceso,
                    p.nombrecompleto,
                    p.codigo,
                    p.categoria,
                    p.categoria_id,
                    p.documento,
                    p.compania_id,
                    p.compania,
                    GROUP_CONCAT(r.name ORDER BY r.name SEPARATOR ', ') AS roles
                FROM users u
                LEFT JOIN vt_personales p 
                    ON p.idpersonal = u.personal_id
                LEFT JOIN model_has_roles mhr 
                    ON mhr.model_id = u.id_usuario
                AND mhr.model_type = 'App\\Models\\User'
                LEFT JOIN roles r 
                    ON r.id = mhr.role_id
                GROUP BY 
                    u.id_usuario,
                    u.personal_id,
                    u.name,
                    u.email,
                    u.deleted_at,
                    u.ultimo_acceso,
                    p.nombrecompleto,
                    p.codigo,
                    p.categoria,
                    p.categoria_id,
                    p.documento,
                    p.compania_id,
                    p.compania;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vt_usuarios_con_roles");
    }
};
