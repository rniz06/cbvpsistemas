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
        DB::statement("DROP VIEW IF EXISTS `vt_personales_contactos_emergencias`");
        DB::statement("
            CREATE 
                VIEW `personalcbvp`.`vt_personales_contactos_emergencias` AS
                    SELECT 
                        `personalcbvp`.`personal_contactos_emergencias`.`id_contacto_emergencia` AS `id_contacto_emergencia`,
                        `personalcbvp`.`personal_contactos_emergencias`.`personal_id` AS `personal_id`,
                        `vt_personales`.`nombrecompleto` AS `nombrecompleto`,
                        `vt_personales`.`codigo` AS `codigo`,
                        `vt_personales`.`documento` AS `documento`,
                        `personalcbvp`.`personal_contactos_emergencias`.`tipo_contacto_id` AS `tipo_contacto_id`,
                        `personalcbvp`.`personal_tipo_contactos`.`tipo_contacto` AS `tipo_contacto`,
                        `personalcbvp`.`personal_contactos_emergencias`.`parentesco_id` AS `parentesco_id`,
                        `personalcbvp`.`personal_parentescos`.`parentesco` AS `parentesco`,
                        `personalcbvp`.`personal_contactos_emergencias`.`ciudad_id` AS `ciudad_id`,
                        `emepy_bd`.`ciudades`.`ciudad` AS `ciudad`,
                        `personalcbvp`.`personal_contactos_emergencias`.`nombre_completo` AS `nombre_contacto`,
                        `personalcbvp`.`personal_contactos_emergencias`.`direccion` AS `direccion`,
                        `personalcbvp`.`personal_contactos_emergencias`.`contacto` AS `contacto`
                    FROM
                        ((((`personalcbvp`.`personal_contactos_emergencias`
                        JOIN `personalcbvp`.`personal_tipo_contactos` ON (`personalcbvp`.`personal_contactos_emergencias`.`tipo_contacto_id` = `personalcbvp`.`personal_tipo_contactos`.`id_tipo_contacto`))
                        JOIN `personalcbvp`.`vt_personales` ON (`personalcbvp`.`personal_contactos_emergencias`.`personal_id` = `vt_personales`.`idpersonal`))
                        JOIN `personalcbvp`.`personal_parentescos` ON (`personalcbvp`.`personal_contactos_emergencias`.`parentesco_id` = `personalcbvp`.`personal_parentescos`.`id_parentesco`))
                        JOIN `emepy_bd`.`ciudades` ON (`personalcbvp`.`personal_contactos_emergencias`.`ciudad_id` = `emepy_bd`.`ciudades`.`idciudades`))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Schema::dropIfExists('vt_personales_contactos_emergencias');
    }
};
