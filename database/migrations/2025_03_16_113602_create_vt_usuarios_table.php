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
        DB::statement('
            CREATE VIEW `vt_usuarios` AS
            SELECT
                u.id_usuario,
                u.personal_id,
                u.name,
                u.email,
                u.password,
                u.deleted_at,
                p.nombrecompleto,
                p.codigo,
                p.categoria,
                p.categoria_id,
                p.documento,
                p.compania
            FROM users u
            LEFT JOIN vt_personales p ON (p.idpersonal = u.personal_id)
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `vt_usuarios`");
    }
};
