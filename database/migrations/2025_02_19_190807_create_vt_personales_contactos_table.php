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
        DB::statement("DROP VIEW IF EXISTS `vt_personales_contactos`");
        DB::statement("
            CREATE 
                VIEW `personalcbvp`.`vt_personales_contactos` AS
                    SELECT 
                        `personalcbvp`.`personal_contactos`.`id_personal_contacto` AS `id_personal_contacto`,
                        `personalcbvp`.`personal_contactos`.`personal_id` AS `personal_id`,
                        `vt_personales`.`nombrecompleto` AS `nombrecompleto`,
                        `vt_personales`.`codigo` AS `codigo`,
                        `vt_personales`.`documento` AS `documento`,
                        `personalcbvp`.`personal_contactos`.`tipo_contacto_id` AS `tipo_contacto_id`,
                        `personalcbvp`.`personal_tipo_contactos`.`tipo_contacto` AS `tipo_contacto`,
                        `personalcbvp`.`personal_contactos`.`contacto` AS `contacto`,
                        `personalcbvp`.`personal_contactos`.`deleted_at` AS `deleted_at`
                    FROM
                        ((`personalcbvp`.`personal_contactos`
                        LEFT JOIN `personalcbvp`.`vt_personales` ON (`vt_personales`.`idpersonal` = `personalcbvp`.`personal_contactos`.`personal_id`))
                        LEFT JOIN `personalcbvp`.`personal_tipo_contactos` ON (`personalcbvp`.`personal_tipo_contactos`.`id_tipo_contacto` = `personalcbvp`.`personal_contactos`.`tipo_contacto_id`))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Schema::dropIfExists('vt_personales_contactos');
    }
};
